import api from "../api/axios";
import { formatDate, truncateText, actionButtons } from "../utils/helpers";
import { showSuccess, showError, confirmDelete } from "../utils/alerts";
import { showLoader, hideLoader, showEmptyState, hideEmptyState } from "../utils/loader";

/**
 * Fetch Notes
 */
async function loadNotes(page = 1) {

    showLoader();

    hideEmptyState();

    try {

        const response = await api.get(`/notes?page=${page}`);

        // const notes = response.data.data;
        const notes = response.data?.data?.items ?? [];
        const pagination = response.data.data.pagination;

        renderNotes(notes);
        updateStatistics(notes);
        renderPagination(pagination);

    } catch (error) {

        showError("Unable to load notes.");

        console.error(error);

    } finally {

        hideLoader();

    }

}

/**
 * Render Notes Table
 */
function renderNotes(notes) {

    const tbody = document.getElementById("notesTableBody");

    tbody.innerHTML = "";

    if (!Array.isArray(notes) || notes.length === 0) {

        showEmptyState();

        return;

    }

    let html = "";

    notes.forEach(note => {

        html += `
            <tr class="border-t hover:bg-slate-50 transition">

                <td class="px-6 py-5 font-semibold">
                    ${note.title}
                </td>

                <td class="px-6 py-5">

                    ${
                        note.summary
                        ? `
                            <p class="text-slate-600 text-sm leading-6">
                                ${truncateText(note.summary, 120)}
                            </p>
                        `
                        : `
                            <span class="text-slate-400 italic">
                                No AI Summary
                            </span>
                        `
                    }

                </td>
                <td class="px-6 py-5">

                    ${
                        note.score !== undefined
                            ? `
                            <span class="inline-flex items-center rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700">
                                ${(note.score * 100).toFixed(1)}%
                            </span>
                            `
                            : `
                            <span class="text-slate-400">
                                --
                            </span>
                            `
                    }

                </td>

                <td class="px-6 py-5">
                    ${formatDate(note.updated_at)}
                </td>

                <td class="px-6 py-5">
                    ${actionButtons(note.id)}
                </td>

            </tr>
        `;

    });

    tbody.innerHTML = html;

    registerDeleteEvents();
}

/**
 * Update Dashboard Statistics
 */
function updateStatistics(notes) {

    document.getElementById("totalNotes").textContent = notes.length;

    const summaries = notes.filter(note => note.summary);

    const totalSummaries = document.getElementById("totalSummaries");

    if (totalSummaries) {

        totalSummaries.textContent = summaries.length;

    }

}

function renderPagination(pagination) {

    const container = document.getElementById("paginationContainer");

    if (!container) return;

    let html = '';

    // Previous
    html += `
        <button
            class="px-4 py-2 rounded-lg border bg-white hover:bg-slate-100 disabled:opacity-50"
            ${pagination.prev_page_url ? '' : 'disabled'}
            data-page="${pagination.current_page - 1}">
            Previous
        </button>
    `;

    // Page Numbers
    for (let i = 1; i <= pagination.last_page; i++) {

        html += `
            <button
                class="px-4 py-2 rounded-lg
                ${i === pagination.current_page
                    ? 'bg-blue-600 text-white'
                    : 'bg-white border hover:bg-slate-100'}"
                data-page="${i}">
                ${i}
            </button>
        `;

    }

    // Next
    html += `
        <button
            class="px-4 py-2 rounded-lg border bg-white hover:bg-slate-100 disabled:opacity-50"
            ${pagination.next_page_url ? '' : 'disabled'}
            data-page="${pagination.current_page + 1}">
            Next
        </button>
    `;

    container.innerHTML = html;

    container.querySelectorAll("button[data-page]").forEach(button => {

        button.addEventListener("click", () => {

            loadNotes(button.dataset.page);

        });

    });

}

/**
 * Register Delete Events
 */
function registerDeleteEvents() {

    document.querySelectorAll(".delete-note").forEach(button => {

        button.addEventListener("click", async function () {

            const id = this.dataset.id;

            const confirmed = await confirmDelete();

            if (!confirmed) return;

            try {

                await api.delete(`/notes/${id}`);

                showSuccess("Note deleted successfully.");

                loadNotes();

            } catch (error) {

                showError("Unable to delete note.");

            }

        });

    });

}

/**
 * Semantic Search
 */
async function searchNotes() {
    const searchInput = document.getElementById("semanticSearch");

    const searchButton = document.getElementById("searchButton");

    const clearButton = document.getElementById("clearSearch");

    const searchStatus = document.getElementById("searchStatus");

    const query = searchInput.value.trim();

    if (!query) {

        loadNotes();

        return;

    }

    showLoader();

    hideEmptyState();

    try {

        const response = await api.post("/notes/search", {

            query

        });

        const results = response.data.results ?? [];

        renderNotes(results);

        searchStatus.classList.remove("hidden");

        searchStatus.innerHTML = `
            Showing <strong>${results.length}</strong>
            semantic search result(s) for
            <strong>"${query}"</strong>.
        `;

    } catch (error) {

        console.error(error);

        showError("Semantic search failed.");

    } finally {

        hideLoader();

    }

}

/**
 * Initialize Dashboard
 */
document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("notesTableBody");
     
    const searchInput = document.getElementById("semanticSearch");

    const searchButton = document.getElementById("searchButton");

    const clearButton = document.getElementById("clearSearch");

    const searchStatus = document.getElementById("searchStatus");

    if (tbody) {
        loadNotes();
    }

    if (searchButton) {
        searchButton.addEventListener("click", searchNotes);
    }

    if (searchInput) {

        searchInput.addEventListener("keypress", function(e){

            if(e.key==="Enter"){

                e.preventDefault();

                searchNotes();

            }

        });

    }

    if(clearButton){

        clearButton.addEventListener("click",()=>{

            searchInput.value="";

            searchStatus.classList.add("hidden");

            loadNotes();

        });

    }


});