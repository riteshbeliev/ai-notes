import api from "../api/axios";

import { showSuccess, showError, confirmDelete } from "../utils/alerts";

import { formatDate } from "../utils/helpers";

document.addEventListener("DOMContentLoaded", () => {

    const noteIdElement = document.getElementById("noteId");

    if (!noteIdElement) return;

    const noteId = noteIdElement.value;

    const noteTitle = document.getElementById("noteTitle");
    const noteContent = document.getElementById("noteContent");
    const noteSummary = document.getElementById("noteSummary");

    const createdDate = document.getElementById("createdDate");
    const updatedDate = document.getElementById("updatedDate");

    const summaryStatus = document.getElementById("summaryStatus");

    const characterCount = document.getElementById("characterCount");
    const wordCount = document.getElementById("wordCount");

    const editButton = document.getElementById("editButton");
    const deleteButton = document.getElementById("deleteButton");

    /**
     * Load Note
     */
    async function loadNote() {

        try {

            const response = await api.get(`/notes/${noteId}`);

            const note = response.data.data;

            noteTitle.textContent = note.title;

            noteContent.textContent = note.content;
            noteSummary.textContent = note.summary ?? 'No AI summary available.';
            createdDate.textContent = formatDate(note.created_at);

            updatedDate.textContent = formatDate(note.updated_at);

            if (note.summary) {

                summaryStatus.innerHTML = `
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                        <i class="bi bi-check-circle-fill"></i>
                        AI Generated
                    </span>
                `;

            } else {

                summaryStatus.innerHTML = `
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-medium">
                        <i class="bi bi-hourglass-split"></i>
                        Pending
                    </span>
                `;

            }
            characterCount.textContent = note.content.length;

            wordCount.textContent =
                note.content.trim().split(/\s+/).filter(Boolean).length;

            editButton.href = `/notes/${note.id}/edit`;

        } catch (error) {

            console.error(error);

            showError("Unable to load note.");

        }

    }

    /**
     * Delete Note
     */
    deleteButton.addEventListener("click", async () => {

        const confirmed = await confirmDelete(
            "Delete Note?",
            "This action cannot be undone."
        );

        if (!confirmed) return;

        try {

            const response = await api.delete(`/notes/${noteId}`);

            showSuccess(response.data.message);

            setTimeout(() => {

                window.location.href = "/notes";

            }, 1000);

        } catch (error) {

            console.error(error);

            showError("Failed to delete note.");

        }

    });

    loadNote();

});