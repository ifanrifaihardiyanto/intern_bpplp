import axios from "axios";
import { API_BASE_URL } from "../config";

const baseUrl = API_BASE_URL;

export default axios.create({
  baseURL: baseUrl,
  headers: {
    "Content-Type": "application/json",
  },
});
