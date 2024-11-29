import { createRouter, createWebHistory } from "vue-router";
import apiClient from "@/api/axios.js";
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

// Helper function to read cookies
// function getCookie(name) {
//   const value = `; ${document.cookie}`;
//   const parts = value.split(`; ${name}=`);
//   if (parts.length === 2) return decodeURIComponent(parts.pop().split(";").shift());
//   return null;
// }

async function getCookie(name) {
  const cookies = document.cookie;
  console.log("All cookies:", cookies);

  const value = `; ${cookies}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) {
    const cookieValue = decodeURIComponent(parts.pop().split(";").shift());
    console.log(`Retrieved cookie for ${name}:`, cookieValue);
    return cookieValue;
  }
  
  console.warn(`Cookie ${name} not found.`);
  return null;
}


// Validate token with the server
async function isTokenValid() {
  const token = await getCookie("Authorization");
  const tokendata = {
    Token: token,
  };
  if (!token) console.log("Token not found", token); return false;
  try {
    const response = await apiClient.post("/Front/verifyToken", tokendata);
    console.log(response.data);
    return response.data?.is_valid; // API returns { is_valid: true/false }
  } catch (error) {
    console.error("Error validating token:", error);
    return false;
  }
}

// Retrieve user role from token
async function getUserRole() {
  const token = await getCookie("Authorization");
  const tokendata = { Token: token };
  if (!token) return null;
  try {
    const response = await apiClient.post("/Front/getUserType", tokendata);
    console.log(response.data);
    return response.data; // API response: { user_type: "member/admin/etc" }
  } catch (error) {
    console.error("Error retrieving user role:", error);
    return null;
  }
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: "/MainLogin", name: "MainLogin", component: Main },
    { path: "/AdminLogin", name: "AdminLogin", component: Admin },
    { path: "/CoachLogin", name: "CoachLogin", component: Coach },
    { path: "/MemberLogin", name: "MemberLogin", component: Member },
    { path: "/LandingPage", name: "LandingPage", component: Landing },
    { path: "/AboutUs", name: "AboutUs", component: AboutUs },
    { path: "/Services", name: "Services", component: Services },
    { path: "/OurTeam", name: "OurTeam", component: OurTeam },
    { path: "/Contacts", name: "Contacts", component: Contacts },
    {
      path: "/MemberDashboard",
      name: "MemberDashboard",
      component: MemberDashboard,
      meta: { requiresAuth: true, role: "member" },
    },
    {
      path: "/MemberProfile",
      name: "MemberProfile",
      component: MemberProfile,
      meta: { requiresAuth: true, role: "member" },
    },
    {
      path: "/MemberCoaches",
      name: "MemberCoaches",
      component: MemberCoaches,
      meta: { requiresAuth: true, role: "member" },
    },
    {
      path: "/MemberUpgrade",
      name: "MemberUpgrade",
      component: MemberUpgrade,
      meta: { requiresAuth: true, role: "member" },
    },
  ],
});

// Global navigation guard
router.beforeEach(async (to, from, next) => {
  const requiresAuth = to.meta.requiresAuth;

  if (!requiresAuth) {
    return next(); // No auth required for this route
  }

  const isValid = isTokenValid();
  if (!isValid) {
    console.error("Invalid token. Redirecting to login.");  
    return next("/MainLogin");
  }

  const userRole = await getUserRole();
  if (to.meta.role && to.meta.role !== userRole) {
    console.error(`Unauthorized access. Expected role: ${to.meta.role}, got: ${userRole}.`);
    return next("/MainLogin");
  }

  // Token valid and role matched
  next();
});

export default router;
