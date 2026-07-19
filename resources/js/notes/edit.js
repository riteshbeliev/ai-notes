import api from "../api/axios";

import { showSuccess, showError } from "../utils/alerts";

import { disableButton, enableButton } from "../utils/loader";

import { formatDate } from "../utils/helpers";

document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("editNoteForm");

    if (!form) return;

    const noteId = document.getElementById("noteId").value;

    const title = document.getElementById("title");
    const content = document.getElementById("content");

    const titleError = document.getElementById("titleError");
    const contentError = document.getElementById("contentError");

    const characterCount = document.getElementById("characterCount");

    const updateButton = document.getElementById("updateButton");

    const loadingBadge = document.getElementById("loadingBadge");

    const createdDate = document.getElementById("createdDate");
    const updatedDate = document.getElementById("updatedDate");
    const summaryStatus = document.getElementById("summaryStatus");
    const summaryPreview = document.getElementById("summaryPreview");
    const generateSummaryBtn = document.getElementById("generateSummaryBtn");
    const summaryLoading = document.getElementById("summaryLoading");

    /**
     * Character Counter
     */
    content.addEventListener("input", () => {

        characterCount.textContent = content.value.length;

    });

    /**
     * Clear Validation Errors
     */
    function clearErrors() {

        titleError.textContent = "";
        contentError.textContent = "";

        title.classList.remove("border-red-500");
        content.classList.remove("border-red-500");

    }

    /**
     * Show Validation Errors
     */
    function showValidationErrors(errors) {

        if (errors.title) {
            titleError.textContent = errors.title[0];
            title.classList.add("border-red-500");
        }

        if (errors.content) {
            contentError.textContent = errors.content[0];
            content.classList.add("border-red-500");
        }

    }

    /**
     * Load Note
     */
    async function loadNote() {

        loadingBadge.classList.remove("hidden");

        try {

            const response = await api.get(`/notes/${noteId}`);

            const note = response.data.data;

            title.value = note.title;
            content.value = note.content;

            characterCount.textContent = note.content.length;

            createdDate.textContent = formatDate(note.created_at);
            updatedDate.textContent = formatDate(note.updated_at);

            if (note.summary) {

                summaryStatus.textContent = "Available";

                summaryStatus.className =
                    "px-3 py-1 rounded-full text-xs bg-green-100 text-green-700";

            } else {

                summaryStatus.textContent = "Pending";

                summaryStatus.className =
                    "px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700";

            }

            summaryPreview.textContent = note.summary ?? 'AI summary not available.';
            summaryStatus.textContent = "Outdated";

            summaryStatus.className =
                "px-3 py-1 rounded-full text-xs bg-red-100 text-red-700";

            summaryPreview.innerHTML = `
            <div class="text-red-600">
            Current summary may be outdated.
            Click <strong>Generate Summary</strong>.
            </div>
            `;

        } catch (error) {

            showError("Unable to load note.");

            console.error(error);

        } finally {

            loadingBadge.classList.add("hidden");

        }

    }

    /**
     * Update Note
     */
    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        clearErrors();

        disableButton(updateButton, "Updating...");

        try {

            const response = await api.put(`/notes/${noteId}`, {

                title: title.value.trim(),

                content: content.value.trim()

            });

            showSuccess(response.data.message);

            setTimeout(() => {

                window.location.href = "/notes";

            }, 1200);

        } catch (error) {

            if (error.response) {

                if (error.response.status === 422) {

                    showValidationErrors(error.response.data.errors);

                } else {

                    showError(error.response.data.message);

                }

            } else {

                showError("Network error. Please try again.");

            }

        } finally {

            enableButton(updateButton);

        }

    });

    /**
     * Initialize
     */
    loadNote();


    generateSummaryBtn.addEventListener("click", async () => {

        summaryLoading.classList.remove("hidden");
        generateSummaryBtn.disabled = true;

        try {

            const response = await api.post(
                `/notes/${noteId}/summary`
            );

            summaryPreview.textContent =
                response.data.summary;

            summaryStatus.textContent = "Available";

            summaryStatus.className =
                "px-3 py-1 rounded-full text-xs bg-green-100 text-green-700";

            showSuccess("AI Summary generated.");

        } catch (error) {

            showError("Unable to generate summary.");

        } finally {

            summaryLoading.classList.add("hidden");

            generateSummaryBtn.disabled = false;

        }

    });

});