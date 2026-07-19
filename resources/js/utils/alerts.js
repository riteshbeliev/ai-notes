import Swal from "sweetalert2";

/**
 * Success Alert
 *
 * @param {string} message
 */
export function showSuccess(message = "Operation completed successfully.") {
    Swal.fire({
        icon: "success",
        title: "Success",
        text: message,
        confirmButtonColor: "#2563eb",
        timer: 2000,
        showConfirmButton: false,
    });
}

/**
 * Error Alert
 *
 * @param {string} message
 */
export function showError(message = "Something went wrong.") {
    Swal.fire({
        icon: "error",
        title: "Error",
        text: message,
        confirmButtonColor: "#dc2626",
    });
}

/**
 * Warning Alert
 *
 * @param {string} message
 */
export function showWarning(message = "Please check your input.") {
    Swal.fire({
        icon: "warning",
        title: "Warning",
        text: message,
        confirmButtonColor: "#f59e0b",
    });
}

/**
 * Information Alert
 *
 * @param {string} message
 */
export function showInfo(message = "Information") {
    Swal.fire({
        icon: "info",
        title: "Information",
        text: message,
        confirmButtonColor: "#0ea5e9",
    });
}

/**
 * Delete Confirmation Dialog
 *
 * @returns {Promise<boolean>}
 */
export async function confirmDelete() {
    const result = await Swal.fire({
        title: "Delete Note?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#64748b",
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        reverseButtons: true,
    });

    return result.isConfirmed;
}