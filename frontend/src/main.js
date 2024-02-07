import { createApp } from "vue";
import { createPinia } from "pinia";

import "./assets/main.css";

import App from "./App.vue";

import router from "./router";
import { RouterLink } from "vue-router";

const app = createApp({});

app.use(createPinia());
app.use(router);

// Components
app.component("router-link", RouterLink);

// Views
app.component("app-view", App);

app.mount("#app");
