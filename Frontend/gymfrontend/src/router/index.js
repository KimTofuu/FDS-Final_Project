import { createRouter, createWebHistory } from "vue-router";
import Main from "@/views/MainLogin.vue";
import Admin from "@/views/AdminLogin.vue";
import Coach from "@/views/CoachLogin.vue";
import Member from "@/views/MemberLogin.vue";
import Landing from "@/views/LandingPage.vue";
import AboutUs from "@/views/AboutUs.vue";
import Services from "@/views/Services.vue";
import OurTeam from "@/views/OurTeam.vue";
import Contacts from "@/views/Contacts.vue";
import MemberDashboard from "@/views/MemberDashboard.vue";
import MemberProfile from "@/views/MemberProfile.vue";
import MemberCoaches from "@/views/MemberCoaches.vue";
import MemberUpgrade from "@/views/MemberUpgrade.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/MainLogin",
      name: "MainLogin",
      component: Main,
    },

    {
      path: "/AdminLogin",
      name: "AdminLogin",
      component: Admin,
    },

    {
      path: "/CoachLogin",
      name: "CoachLogin",
      component: Coach,
    },

    {
      path: "/MemberLogin",
      name: "MemberLogin",
      component: Member,
    },

    {
      path: "/LandingPage",
      name: "LandingPage",
      component: Landing,
    },

    {
      path: "/AboutUs",
      name: "AboutUs",
      component: AboutUs,
    },

    {
      path: "/Services",
      name: "Services",
      component: Services,
    },

    {
      path: "/OurTeam",
      name: "OurTeam",
      component: OurTeam,
    },

    {
      path: "/Contacts",
      name: "Contacts",
      component: Contacts,
    },

    {
      path: "/MemberDashboard",
      name: "Memberdashboard",
      component: MemberDashboard,
    },

    {
      path: "/MemberProfile",
      name: "MemberProfile",
      component: MemberProfile,
    },

    {
      path: "/MemberCoaches",
      name: "MemberCoaches",
      component: MemberCoaches,
    },

    {
      path: "/MemberUpgrade",
      name: "MemberUpgrade",
      component: MemberUpgrade,
    },
  ],
});

export default router;
