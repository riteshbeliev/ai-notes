/**
 * Show loading spinner.
 *
 * @param {string} elementId
 */
export function showLoader(elementId = "loadingSpinner") {
    const loader = document.getElementById(elementId);

    if (loader) {
        loader.classList.remove("hidden");
    }
}

/**
 * Hide loading spinner.
 *
 * @param {string} elementId
 */
export function hideLoader(elementId = "loadingSpinner") {
    const loader = document.getElementById(elementId);

    if (loader) {
        loader.classList.add("hidden");
    }
}

/**
 * Show empty state.
 *
 * @param {string} elementId
 */
export function showEmptyState(elementId = "emptyState") {
    const empty = document.getElementById(elementId);

    if (empty) {
        empty.classList.remove("hidden");
    }
}

/**
 * Hide empty state.
 *
 * @param {string} elementId
 */
export function hideEmptyState(elementId = "emptyState") {
    const empty = document.getElementById(elementId);

    if (empty) {
        empty.classList.add("hidden");
    }
}

/**
 * Disable a button while processing.
 *
 * @param {HTMLElement} button
 * @param {string} loadingText
 */
export function disableButton(button, loadingText = "Processing...") {
    if (!button) return;

    button.dataset.originalText = button.innerHTML;

    button.disabled = true;

    button.innerHTML = `
        <span class="inline-flex items-center gap-2">
            <span class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
            ${loadingText}
        </span>
    `;
}

/**
 * Enable button after processing.
 *
 * @param {HTMLElement} button
 */
export function enableButton(button) {
    if (!button) return;

    button.disabled = false;

    if (button.dataset.originalText) {
        button.innerHTML = button.dataset.originalText;
    }
}