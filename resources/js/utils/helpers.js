/**
 * Format date into a readable format.
 *
 * @param {string} date
 * @returns {string}
 */
export function formatDate(date) {
    if (!date) return "-";

    return new Date(date).toLocaleDateString("en-IN", {
        day: "2-digit",
        month: "short",
        year: "numeric",
    });
}

/**
 * Format date & time.
 *
 * @param {string} date
 * @returns {string}
 */
export function formatDateTime(date) {
    if (!date) return "-";

    return new Date(date).toLocaleString("en-IN", {
        day: "2-digit",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
}

/**
 * Truncate long text.
 *
 * @param {string} text
 * @param {number} length
 * @returns {string}
 */
export function truncateText(text, length = 80) {
    if (!text) return "";

    return text.length > length
        ? text.substring(0, length) + "..."
        : text;
}

/**
 * Escape HTML characters.
 *
 * @param {string} text
 * @returns {string}
 */
export function escapeHtml(text) {
    if (!text) return "";

    const div = document.createElement("div");
    div.innerText = text;

    return div.innerHTML;
}

/**
 * Debounce function.
 *
 * Useful for Search API.
 *
 * @param {Function} callback
 * @param {number} delay
 * @returns {Function}
 */
export function debounce(callback, delay = 500) {
    let timer;

    return (...args) => {
        clearTimeout(timer);

        timer = setTimeout(() => {
            callback(...args);
        }, delay);
    };
}

/**
 * Generate View/Edit/Delete buttons.
 *
 * @param {number} id
 * @returns {string}
 */
export function actionButtons(id) {
    return `
        <div class="flex justify-center gap-2">

            <a href="/notes/${id}"
                class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-2 rounded-lg transition">

                <i class="bi bi-eye"></i>

            </a>

            <a href="/notes/${id}/edit"
                class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded-lg transition">

                <i class="bi bi-pencil"></i>

            </a>

            <button
                class="delete-note bg-red-100 hover:bg-red-200 text-red-600 px-3 py-2 rounded-lg transition"
                data-id="${id}">

                <i class="bi bi-trash"></i>

            </button>

        </div>
    `;
}