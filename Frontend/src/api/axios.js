import axios from "axios";

const apiClient = axios.create({
    baseURL: "http://localhost/Olympus/Backend",
    headers: {
      "Content-Type": "application/json"
    },
    withCredentials: true
    });

export default apiClient;
