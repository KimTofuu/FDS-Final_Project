import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "@fortawesome/fontawesome-svg-core/styles.css"; 
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "@fortawesome/fontawesome-free/css/all.css";

import {
  faDumbbell,
  faCreditCard,
  faChartSimple,
  faPaperPlane,
  faPhone,
} from "@fortawesome/free-solid-svg-icons";

import {
  faSquareFacebook,
  faSquareTwitter,
  faSquareInstagram,
} from "@fortawesome/free-brands-svg-icons";

library.add(
  faDumbbell,
  faCreditCard,
  faChartSimple,
  faPaperPlane,
  faPhone,
  faSquareFacebook,
  faSquareTwitter,
  faSquareInstagram
);

const app = createApp(App);

app.component("font-awesome-icon", FontAwesomeIcon);

app.use(router);

app.mount("#app");
