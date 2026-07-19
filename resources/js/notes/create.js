import api from "../api/axios";

import {
    showSuccess,
    showError
} from "../utils/alerts";

import {
    disableButton,
    enableButton
} from "../utils/loader";

document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("createNoteForm");

    if (!form) return;

    const title = document.getElementById("title");
    const content = document.getElementById("content");

    const titleError = document.getElementById("titleError");
    const contentError = document.getElementById("contentError");

    const characterCount = document.getElementById("characterCount");

    const saveButton = document.getElementById("saveButton");

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
     * Submit Form
     */
    form.addEventListener("submit", async function (e) {

        e.preventDefault();

        clearErrors();

        disableButton(saveButton, "Saving...");

        try {

            const response = await api.post("/notes", {

                title: title.value.trim(),

                content: content.value.trim()

            });

            showSuccess(response.data.message);

            form.reset();

            characterCount.textContent = 0;

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

            enableButton(saveButton);

        }

    });

});