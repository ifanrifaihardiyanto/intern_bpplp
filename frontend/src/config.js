const environment = import.meta.env;

let BASE_URL = environment.VITE_DEV_BASE_URL;
let API_BASE_URL = environment.VITE_DEV_API_BASE_URL;

if (environment.VITE_ENV == "production") {
  BASE_URL = environment.VITE_PROD_BASE_URL;
  API_BASE_URL = environment.VITE_PROD_API_BASE_URL;
}

export { BASE_URL, API_BASE_URL };
