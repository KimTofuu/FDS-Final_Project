<template>
  <div class="sidebar-layout">
    <button @click="toggleSidebar" class="sidebar-toggle">☰</button>

    <aside :class="['sidebar', { show: showSidebar }]">
      <div class="logo">
        <router-link to="/AdminMemberinfo">
          <img src="@/assets/logononame.png" alt="Logo" class="logo-img" />
        </router-link>
      </div>

      <nav>
        <ul>
          <li>
            <a href="/AdminMemberinfo">Members Information</a>
          </li>
          <li>
            <a href="/AdminMemberemail" style="color: #ac0700">Members Email</a>
          </li>
          <li><a href="/AdminMembercondition">Members Condition</a></li>
          <li><a href="/AdminMembersubscription">Members Subscription</a></li>
        </ul>
      </nav>
      <button @click="showLogoutConfirm = true" class="logout-button">
        <img src="../assets/logout.png" alt="Logout" class="logout-img" />
        <span class="logout-text">Logout</span>
      </button>
    </aside>
    
    <div v-show="showLogoutConfirm">
      <div class="overlay" @click="showLogoutConfirm = false"></div>
      <transition
        name="fade"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
      >
        <div v-if="showLogoutConfirm" class="logout-confirmation">
          <p>Are you sure you want to logout?</p>
          <div class="button-group">
            <button @click="logout">Yes</button>
            <button @click="showLogoutConfirm = false">No</button>
          </div>
        </div>
      </transition>
    </div>

    <main class="content">
      <header>
        <h1>MEMBERS EMAIL</h1>
      </header>

      <table>
        <thead>
          <tr>
            <th>User ID</th>
            <th>Email</th>
            <th>Username</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(member, index) in members" :key="index">
            <td>{{ member.User_ID }}</td>
            <td>{{ member.Email }}</td>
            <td>{{ member.Username }}</td>
            <td>{{ member.ArchiveStatus === 1 ? 'Visible' : 'Hidden'}}</td>
            <td>
              <a href="update.html?id=2" class="action-button">Update</a>
              <a
                href="delete.html?id=3" class="action-button"
                onclick="return confirm('Are you sure you want to delete this record?');"
                >Delete</a
              >
            </td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>

<script>
import apiClient from "@/api/axios";

export default {
  data() {
    return {
      showLogoutConfirm: false,
      showSidebar: true,
      members: [],
    };
  },
  mounted(){
    apiClient.get("/Get/All")
    .then((response) => {
      if (response.data.status.remarks === "success" && Array.isArray(response.data.payload)) {
        this.members = response.data.payload.map((member) => ({
          User_ID: member.User_ID,
          Email: member.Email,
          Username: member.Username,
          ArchiveStatus: member.ArchiveStatus
        }))
      }
    })
  },
  methods: {
    toggleSidebar() {
      this.showSidebar = !this.showSidebar; 
    },
    async logout() {
      this.showLogoutConfirm = false;
      try {
        const response = await apiClient.post("/Logout");
        console.log(response.data);
        if (response.data?.status?.remarks === "success") {
          this.$router.push("/MainLogin");
        } else {
          this.error = response.data.message || "Logout failed";
        }
      } catch (error) {
        console.error("Logout Error:", error);
        this.error = "An error occurred while logging out. Please try again.";
      }
    },
    beforeEnter(el) {
      el.style.opacity = 0;
    },
    enter(el, done) {
      el.offsetHeight;
      el.style.transition = "opacity 0.3s ease-in-out";
      el.style.opacity = 1;
      done();
    },
    leave(el, done) {
      el.style.transition = "opacity 0.3s ease-in-out";
      el.style.opacity = 0;
      done();
    },
  },
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
}

html,
body {
  height: 100%;
  font-family: "Figtree", sans-serif;
  background-color: #fff;
}

.sidebar-layout {
  display: flex;
}

.sidebar {
  width: 250px;
  height: 100vh;
  background-color: #000; 
  color: #fff;
  position: fixed;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 8%;
  transition: transform 0.3s ease; 
  transform: translateX(-100%); 
}

.sidebar.show {
  transform: translateX(0); 
}

.logo {
  margin-bottom: 20px;
}

.logo-img {
  width: 50px;
  height: 60px;
}

.sidebar nav ul {
  list-style: none;
  width: 100%;
  padding: 0;
  text-align: center;
}

.sidebar nav ul li {
  margin: 30px 0;
}

.sidebar nav ul li a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s;
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5); 
  z-index: 1000;
}

.logout-button {
  background-color: #ac0700;
  border: none;
  cursor: pointer;
  margin-top: 25vh;
  padding: 5px 10px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  gap: 5px;
  width: 50px;
  overflow: hidden;
  transition: width 0.3s ease, padding 0.3s ease;
}

.logout-img {
  width: 30px;
  height: 30px;
  transition: transform 0.3s ease;
}

.logout-img:hover {
  transform: scale(1.1);
}

.logout-text {
  font-size: 1rem;
  font-weight: bold;
  color: #ffffff;
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
  white-space: nowrap;
}

.logout-button:hover {
  width: 15vh;
  padding: 5px 10px;
}

.logout-button:hover .logout-text {
  opacity: 1;
}

.logout-confirmation {
  position: fixed;
  top: 50%;
  left: 60%;
  transform: translate(-50%, -50%);
  background-color: rgba(0, 0, 0, 0.9);
  color: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  width: 27%;
  height: 20%;
  opacity: 0;
  pointer-events: auto;
  transition: opacity 0.3s ease-in-out;
}

.logout-confirmation p {
  font-size: 1.5rem;
  margin-bottom: 5%;
}

.logout-confirmation button {
  padding: 0px 10px;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  font-size: 1.2rem;
  width: 10vh;
  height: 5vh;
  background-color: #fff;
  color: #ffffff(255, 255, 255);
  transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
}

.logout-confirmation button:hover {
  background-color: #ac0700;
  color: #fff;
  transform: scale(1.05);
}

.content h1 {
  color: #000000; 
  margin-bottom: 8vh;
}

table {
  width: 100%; 
  margin: 20px auto; 
  border-collapse: collapse; 
  background-color: white; 
  border-radius: 10px; 
  overflow: hidden; 
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); 
}
th,
td {
  border: 1px solid #ddd;
  padding: 12px; 
  text-align: center;
}

th {
  background-color: #f2f2f2; 
  color: #333; 
}

td {
  color: black;
  margin-right: 5vh;
}

.action-button {
  display: inline-block;
  width: 80px; 
  height: 30px; 
  background: #ac0700; 
  border-radius: 5px; 
  text-decoration: none;
  color: white; 
  padding: 5px 10px; 
  margin: 0 5px; 
  transition: background-color 0.3s; 
}

.action-button:hover {
  background: #b50a0a; 
}

</style>
