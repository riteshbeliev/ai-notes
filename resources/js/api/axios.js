import axios from "axios";

/**
 * Create a reusable Axios instance
 */
const api = axios.create({
    baseURL: "/api/v1",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
    },
    timeout: 10000,
});

/**
 * Attach CSRF Token (if available)
 */
const token = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute("content");

if (token) {
    api.defaults.headers.common["X-CSRF-TOKEN"] = token;
}

/**
 * Request Interceptor
 */
api.interceptors.request.use(
    (config) => {
        console.log(`${config.method?.toUpperCase()} ${config.url}`);
        return config;
    },
    (error) => Promise.reject(error)
);

/**
 * Response Interceptor
 */
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response) {
            switch (error.response.status) {
                case 401:
                    console.error("Unauthorized");
                    break;

                case 403:
                    console.error("Forbidden");
                    break;

                case 404:
                    console.error("Resource Not Found");
                    break;

                case 422:
                    console.error("Validation Error", error.response.data.errors);
                    break;

                case 500:
                    console.error("Internal Server Error");
                    break;

                default:
                    console.error(error.response.data.message);
            }
        } else if (error.request) {
            console.error("No response received from server.");
        } else {
            console.error(error.message);
        }

        return Promise.reject(error);
    }
);

export default api;