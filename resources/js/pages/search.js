import api from "../api/axios";
import { formatDate, truncateText } from "../utils/helpers";
import { showError } from "../utils/alerts";

document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("searchQuery");
    const searchButton = document.getElementById("searchBtn");
    const clearButton = document.getElementById("clearButton");

    const loader = document.getElementById("searchLoader");
    const resultsContainer = document.getElementById("searchResults");
    const emptyState = document.getElementById("emptySearchState");

    if (!searchInput) return;

    /**
     * Loading
     */
    function showLoader() {
        loader.classList.remove("hidden");
    }

    function hideLoader() {
        loader.classList.add("hidden");
    }

    /**
     * Empty State
     */
    function showEmptyState() {
        emptyState.classList.remove("hidden");
    }

    function hideEmptyState() {
        emptyState.classList.add("hidden");
    }

    /**
     * Clear Results
     */
    function clearResults() {
        resultsContainer.innerHTML = "";
    }

    /**
     * Similarity Badge
     */
    function similarityBadge(score) {

        let color = "bg-red-100 text-red-700";

        if (score >= 0.80) {
            color = "bg-green-100 text-green-700";
        } else if (score >= 0.60) {
            color = "bg-blue-100 text-blue-700";
        } else if (score >= 0.40) {
            color = "bg-yellow-100 text-yellow-700";
        }

        return `
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${color}">
                ${(score * 100).toFixed(1)}% Match
            </span>
        `;
    }

    /**
     * Render Results
     */
    function renderResults(results) {

        clearResults();

        hideEmptyState();

        if (!results.length) {

            showEmptyState();

            return;
        }

        let html = "";

        results.forEach(note => {

            html += `
                <div class="bg-white rounded-2xl border border-slate-200 shadow-md p-6">

                    <div class="flex justify-between items-start gap-4">

                        <div>

                            <h3 class="text-xl font-bold text-slate-800">
                                ${note.title}
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Updated:
                                ${formatDate(note.updated_at)}
                            </p>

                        </div>

                        ${similarityBadge(note.score)}

                    </div>

                    <div class="mt-5">

                        <h4 class="font-semibold text-violet-700 mb-2">

                            <i class="bi bi-stars"></i>

                            AI Summary

                        </h4>

                        <p class="text-slate-600 leading-7">

                            ${
                                note.summary
                                ? truncateText(note.summary, 220)
                                : "No AI summary available."
                            }

                        </p>

                    </div>

                    <div class="mt-6">

                        <h4 class="font-semibold text-slate-700 mb-2">

                            Content

                        </h4>

                        <p class="text-slate-600 leading-7">

                            ${truncateText(note.content, 260)}

                        </p>

                    </div>

                    <div class="mt-6 flex gap-3">

                        <a
                            href="/notes/${note.id}"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">

                            <i class="bi bi-eye"></i>

                            View

                        </a>

                        <a
                            href="/notes/${note.id}/edit"
                            class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-white hover:bg-amber-600">

                            <i class="bi bi-pencil-square"></i>

                            Edit

                        </a>

                    </div>

                </div>
            `;

        });

        resultsContainer.innerHTML = html;
    }

    /**
     * Semantic Search
     */
    async function performSearch() {

        const query = searchInput.value.trim();

        if (!query) {

            showError("Please enter a search query.");

            return;
        }

        showLoader();

        hideEmptyState();

        clearResults();

        try {

            const response = await api.post("/search", {

                query

            });

            renderResults(response.data.results);

        } catch (error) {

            console.error(error);

            showError("Unable to perform semantic search.");

        } finally {

            hideLoader();

        }

    }

    /**
     * Search Button
     */
    searchButton.addEventListener("click", performSearch);

    /**
     * Enter Key
     */
    searchInput.addEventListener("keypress", function (e) {

        if (e.key === "Enter") {

            e.preventDefault();

            performSearch();

        }

    });

    /**
     * Clear Button
     */
    clearButton.addEventListener("click", () => {

        searchInput.value = "";

        clearResults();

        hideEmptyState();

        searchInput.focus();

    });

});