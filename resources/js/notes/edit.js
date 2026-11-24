import api from "../api/axios";

import { showSuccess, showError } from "../utils/alerts";

import { disableButton, enableButton } from "../utils/loader";

import { formatDate } from "../utils/helpers";


document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("editNoteForm");

    if (!form) return;


    const noteIdElement = document.getElementById("noteId");

    if (!noteIdElement) {
        console.error("Note ID not found.");
        return;
    }


    const noteId = noteIdElement.value;


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

    const generateSummaryBtn =
        document.getElementById("generateSummaryBtn");

    const summaryLoading =
        document.getElementById("summaryLoading");


    /*
    |--------------------------------------------------------------------------
    | Embedding Elements
    |--------------------------------------------------------------------------
    */

    const embeddingButton =
        document.getElementById("embeddingButton");

    const embeddingLoading =
        document.getElementById("embeddingLoading");

    const embeddingStatus =
        document.getElementById("embeddingStatus");


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
     * Update Embedding Status
     */
    function updateEmbeddingStatus(hasEmbedding) {

        if (!embeddingStatus) return;


        if (hasEmbedding) {

            embeddingStatus.textContent = "Generated";

            embeddingStatus.className =
                "ml-3 px-3 py-1 rounded-full text-xs bg-green-100 text-green-700";

        } else {

            embeddingStatus.textContent = "Not generated";

            embeddingStatus.className =
                "ml-3 px-3 py-1 rounded-full text-xs bg-slate-100 text-slate-600";

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

            characterCount.textContent =
                note.content.length;


            createdDate.textContent =
                formatDate(note.created_at);

            updatedDate.textContent =
                formatDate(note.updated_at);


            /*
            |--------------------------------------------------------------------------
            | Summary Status
            |--------------------------------------------------------------------------
            */

            if (note.summary) {

                summaryStatus.textContent = "Available";

                summaryStatus.className =
                    "px-3 py-1 rounded-full text-xs bg-green-100 text-green-700";

                summaryPreview.textContent =
                    note.summary;

            } else {

                summaryStatus.textContent = "Pending";

                summaryStatus.className =
                    "px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700";

                summaryPreview.textContent =
                    "AI summary not available.";

            }


            /*
            |--------------------------------------------------------------------------
            | Embedding Status
            |--------------------------------------------------------------------------
            */

            updateEmbeddingStatus(
                !!note.embedding
            );

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

        disableButton(
            updateButton,
            "Updating..."
        );


        try {

            const response = await api.put(
                `/notes/${noteId}`,
                {
                    title: title.value.trim(),
                    content: content.value.trim()
                }
            );


            showSuccess(
                response.data.message
            );


            setTimeout(() => {

                window.location.href = "/notes";

            }, 1200);


        } catch (error) {

            if (error.response) {

                if (error.response.status === 422) {

                    showValidationErrors(
                        error.response.data.errors
                    );

                } else {

                    showError(
                        error.response.data.message ||
                        "Unable to update note."
                    );

                }

            } else {

                showError(
                    "Network error. Please try again."
                );

            }

        } finally {

            enableButton(updateButton);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Generate AI Summary
    |--------------------------------------------------------------------------
    */

    if (generateSummaryBtn) {

        generateSummaryBtn.addEventListener(
            "click",
            async () => {

                summaryLoading.classList.remove(
                    "hidden"
                );

                generateSummaryBtn.disabled = true;


                try {

                    const response =
                        await api.post(
                            `/notes/${noteId}/summary`
                        );


                    /*
                     * Depending on your API response structure,
                     * summary may be inside data.
                     */

                    const summary =
                        response.data.summary ??
                        response.data.data?.summary;


                    summaryPreview.textContent =
                        summary ||
                        "AI summary generated successfully.";


                    summaryStatus.textContent =
                        "Available";


                    summaryStatus.className =
                        "px-3 py-1 rounded-full text-xs bg-green-100 text-green-700";


                    showSuccess(
                        "AI Summary generated."
                    );


                } catch (error) {

                    console.error(
                        "Summary generation error:",
                        error
                    );

                    showError(
                        error.response?.data?.message ||
                        "Unable to generate summary."
                    );

                } finally {

                    summaryLoading.classList.add(
                        "hidden"
                    );

                    generateSummaryBtn.disabled =
                        false;

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Generate Embedding
    |--------------------------------------------------------------------------
    */

    if (embeddingButton) {

        embeddingButton.addEventListener(
            "click",
            async () => {

                /*
                 * Prevent duplicate requests
                 */
                embeddingButton.disabled = true;


                /*
                 * Show loading state
                 */
                if (embeddingLoading) {

                    embeddingLoading.classList.remove(
                        "hidden"
                    );

                }


                embeddingButton.innerHTML = `
                    <i class="bi bi-arrow-repeat animate-spin"></i>
                    Generating...
                `;


                try {

                    /*
                     * Call embedding API
                     *
                     * Expected endpoint:
                     * POST /api/v1/notes/{id}/embedding
                     */

                    const response =
                        await api.post(
                            `/notes/${noteId}/embedding`
                        );


                    console.log(
                        "Embedding response:",
                        response.data
                    );


                    /*
                     * Update status
                     */

                    updateEmbeddingStatus(true);


                    showSuccess(
                        response.data.message ||
                        "Embedding generated successfully."
                    );


                } catch (error) {

                    console.error(
                        "Embedding generation error:",
                        error
                    );


                    showError(
                        error.response?.data?.message ||
                        "Unable to generate embedding."
                    );

                } finally {

                    /*
                     * Restore button
                     */

                    embeddingButton.disabled =
                        false;


                    embeddingButton.innerHTML = `
                        <i class="bi bi-stars"></i>
                        Generate Embedding
                    `;


                    if (embeddingLoading) {

                        embeddingLoading.classList.add(
                            "hidden"
                        );

                    }

                }

            }
        );

    }


    /**
     * Initialize
     */
    loadNote();

});