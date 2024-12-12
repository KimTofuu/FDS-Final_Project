<template>
  <div class="sidebar-layout" @click="closeDropdownOnOutsideClick">
    <button @click="toggleSidebar" class="sidebar-toggle">☰</button>

    <aside :class="['sidebar', { show: showSidebar }]">
      <div class="logo">
        <router-link to="/CoachClient">
          <img src="@/assets/logononame.png" alt="Logo" class="logo-img" />
        </router-link>
      </div>

      <nav>
        <ul>
          <li><a href="/MemberDashboard">Overview</a></li>
          <li><a href="/MemberProfile">Profile</a></li>
          <li><a href="/MemberCoaches" style="color: #ac0700">Coaches</a></li>
          <li><a href="/MemberUpgrade">Upgrade</a></li>
        </ul>
      </nav>
      <button @click="showLogoutConfirm = true" class="logout-buttons">
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
        <div v-if="showLogoutConfirm" class="logout-confirm">
          <p>Are you sure you want to logout?</p>
          <div class="button-group">
            <button @click="logout">Yes</button>
            <button @click="showLogoutConfirm = false">No</button>
          </div>
        </div>
      </transition>
    </div>

    <main class="content">
      <header class="page-header">
        <h1>Coaches</h1>
      </header>
      <div class="clients-container">
        <div
          class="client-box"
          v-for="(client, index) in clients"
          :key="index"
          @click.stop
        >
          <div class="client-icon">
            <img src="../assets/pfp.jpg" alt="Client Icon" />
          </div>
          <div class="client-info">
            <h5>{{ client.name }}</h5>
            <h2>{{ client.Username }}</h2>
          </div>
          <div class="client-actions">
            <button
              @click="enrollToCoach(client)"
              class="action-button"
              :disabled="clientEnrollmentStatus[client.Username] == true"
            >
              Enroll
            </button>
            <button
              @click="dropCoach(client)"
              class="action-button"
              :disabled="clientEnrollmentStatus[client.Username] == false"
            >
              Drop
            </button>
            <button @click="viewClientPopup(client)" class="action-button">
              View
            </button>
          </div>
        </div>
      </div>
      <div v-if="showClientPopup" class="overlay" @click="closeClientPopup">
        <div class="client-popup" @click.stop>
          <h2>{{ clientDeets.name }}</h2>
          <p><strong>Username:</strong> {{ clientDeets.Username }}</p>
          <p><strong>Contact Number:</strong> {{ clientDeets.conNum }}</p>
          <p><strong>Email:</strong> {{ clientDeets.email }}</p>
          <p><strong>Age:</strong> {{ clientDeets.age }}</p>
          <p><strong>Sex:</strong> {{ clientDeets.sex }}</p>
          <p><strong>Weight:</strong> {{ clientDeets.weight }}</p>
          <p><strong>Height:</strong> {{ clientDeets.height }}</p>
          <div class="button-group">
            <button @click="closeClientPopup">Close</button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import apiClient from "@/api/axios";

export default {
  data() {
    return {
      showMessagePopup: false,
      messageContent: "",
      selectedClientIndex: null,
      showLogoutConfirm: false,
      showSidebar: true,
      clients: [],
      activeDropdown: null,
      clientDeets: {
        Username: "",
        name: "",
        email: "",
        conNum: "",
        age: 0,
        sex: 0,
        weight: "",
        height: "",
      },
      showClientPopup: false,
      loading: false,
      clientEnrollmentStatus: [],
    };
  },
  mounted() {
    this.fetchData();
    // this.checkEnrollmentStatus();
  },
  methods: {
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
    async fetchData() {
      try {
        const response = await apiClient.get("/Coaches");
        if (
          response.data.status.remarks === "success" &&
          Array.isArray(response.data.payload)
        ) {
          this.clients = response.data.payload.map((member) => ({
            Username: member.Username,
            name: member.Name,
          }));
          await this.loadCliebntEnrollmentStatus();
          console.log(this.clientEnrollmentStatus);
        }
      } catch (error) {
        console.error("Error fetching clients:", error);
      }
    },
    async enrollToCoach(client) {
      const clientDataArg = {
        Username: client.Username,
      };
      try {
        const response = await apiClient.post(
          "/Member/Enroll-Class",
          clientDataArg,
          { withCredentials: true }
        );
        if (response.data?.status?.remarks === "success") {
          alert("Enrollment successful!");
          this.checkEnrollmentStatus();
          this.fetchData();
        }
      } catch (error) {
        console.error(error);
      }
    },
    async dropCoach(client) {
      const clientDataArg = {
        Username: client.Username,
      };
      try {
        const response = await apiClient.post(
          "/Member/Drop-Coach",
          clientDataArg,
          { withCredentials: true }
        );
        if (response.data?.status?.remarks === "success") {
          alert("Drop successful!");
          this.checkEnrollmentStatus();
          this.fetchData();
        }
      } catch (error) {
        console.error(error);
      }
    },
    async loadCliebntEnrollmentStatus() {
      for (let client of this.clients) {
        const status = await this.checkEnrollmentStatus(client);
        this.clientEnrollmentStatus[client.Username] = status;
      }
    },
    async checkEnrollmentStatus(client) {
      if (!client || !client.Username) {
        console.error("Client or Username is undefined.");
        return false; // Default to not enrolled if there is an issue
      }
      const param = {
        Username: client.Username,
      };
      try {
        const response = await apiClient.post("/Member/isEnrolled", param, {
          withCredentials: true,
        });
        if (response.data?.status?.remarks === "success") {
          if (response.data.payload === false) {
            return false;
          }
          if (response.data.payload === true) {
            return true;
          }
        } else {
          console.error(
            "Error checking enrollment status:",
            response.data.message
          );
          return false; // Default to not enrolled
        }
      } catch (error) {
        console.error("Error checking enrollment status:", error);
        console.log("basta may error daw");
      }
    },
    async viewClientPopup(client) {
      const clientDataArg = {
        Username: client.Username,
      };
      this.showClientPopup = true;
      try {
        const response = await apiClient.post(
          "/Member/CoachesInfo",
          clientDataArg,
          { withCredentials: true }
        );
        if (response.data?.status?.remarks === "success") {
          console.log(response.data);
          this.clientDeets.name = response.data.payload[0].name;
          this.clientDeets.Username = response.data.payload[0].Username;
          this.clientDeets.email = response.data.payload[0].Email;
          this.clientDeets.conNum = response.data.payload[0].ContactNo;
          this.clientDeets.age = response.data.payload[0].Age;
          if (response.data.payload[0].Sex === 1) this.clientDeets.sex = "Male";
          if (response.data.payload[0].Sex === 0)
            this.clientDeets.sex = "Female";
          this.clientDeets.weight = response.data.payload[0].Weight;
          this.clientDeets.height = response.data.payload[0].Height;
        }
      } catch (error) {
        console.error(error);
        console.log(client.Username);
      }
    },
    closeClientPopup() {
      this.showClientPopup = false; // Close the client popup
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
    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
    },
    deleteClient(index) {
      console.log(`Delete client at index ${index}`);
    },
    closeDropdownOnOutsideClick() {
      this.activeDropdown = null;
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
  transform: translateX(-100%);
  transition: transform 0.3s ease;
  z-index: 1001;
}

.sidebar.show {
  transform: translateX(0);
}

.logo {
  margin-bottom: 10vh;
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

.sidebar-toggle {
  position: absolute;
  top: 20px;
  left: 10px;
  z-index: 1002; /* Above the sidebar */
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

.logout-buttons {
  background-color: #ac0700;
  border: none;
  cursor: pointer;
  margin-top: 10vh !important;
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

.logout-buttons:hover {
  width: 15vh;
  padding: 5px 10px;
}

.logout-buttons:hover .logout-text {
  opacity: 1;
}

.logout-confirm {
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

.logout-confirm p {
  font-size: 1.5rem;
  margin-bottom: 5%;
}

.logout-confirm button {
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

.logout-confirm button:hover {
  background-color: #ac0700;
  color: #fff;
  transform: scale(1.05);
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.overlay {
  position: fixed;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.message-popup {
  background: #fff;
  color: #000;
  padding: 20px;
  border-radius: 10px;
  width: 100vh;
  height: 50vh;
  margin-left: 23vh;
  text-align: center;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
}

.message-popup h2 {
  margin-bottom: 15px;
}

.message-popup textarea {
  width: 100%;
  height: 200px;
  margin-bottom: 1px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

.button-group {
  display: flex;
  justify-content: space-between;
}

.button-group button {
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.button-group button:first-child {
  background-color: #ccc;
}

.button-group button:first-child:hover {
  background-color: #ac0700;
  color: white;
}

.button-group button:last-child {
  background-color: #ac0700;
  color: white;
}

.button-group button:last-child:hover {
  background-color: #ffffff;
  color: #ac0700;
}
.content header h1 {
  color: #000000;
  font-size: 2.5rem;
}
.clients-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  z-index: 0;
}

.client-box {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #fff;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
  position: relative;
  z-index: 1;
}

.client-icon img {
  width: 40px;
  height: 40px;
}

.client-info {
  flex-grow: 1;
  margin-left: 20px;
  color: #333;
}

.client-info h5 {
  font-size: 1rem;
  color: #ac0700;
  margin-bottom: 5px;
  text-transform: uppercase;
  font-weight: bold;
}

.client-info h2 {
  font-size: 1.2rem;
  color: #000;
  font-weight: normal;
}

.client-actions .action-button {
  background-color: #ac0700;
  color: #fff;
  border: none;
  padding: 0px 10px;
  border-radius: 10px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.3s ease;
}
.client-actions .action-button:hover {
  background-color: #ffffff;
  color: #ac0700;
  transform: scale(1.05);
}

.client-actions .more-options {
  font-size: 1.5rem;
  background: none;
  border: none;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.client-actions .more-options:hover {
  transform: rotate(90deg);
}

.options-menu {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 100;
  overflow: hidden;
}

.options-menu button {
  padding: 10px 15px;
  background: none;
  border: none;
  cursor: pointer;
  text-align: left;
  font-size: 14px;
  transition: style 0.3s ease-in-out;
}

.options-menu button:hover {
  background: #ac0700;
}

.client-popup {
  background: #fff;
  color: #000;
  padding: 20px;
  border-radius: 10px;
  width: 80vh;
  height: 60vh;
  padding-left: 5vh;
  margin-left: 19vh;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
  text-align: left;
  z-index: 1003;
}

.client-popup h2 {
  margin-bottom: 15px;
}

.client-popup p {
  margin-bottom: 10px;
  font-size: 1rem;
}

.client-popup .button-group {
  display: flex;
  justify-content: flex-end;
}

.client-popup .button-group button {
  padding: 10px 15px;
  border: none;
  background-color: #ac0700;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.client-popup .button-group button:hover {
  background-color: #fff;
  color: #ac0700;
}
.client-actions .action-button:disabled {
  background-color: #d3d3d3; /* Light gray to indicate it's disabled */
  color: #121111; /* Darker gray for text */
  cursor: not-allowed; /* Change cursor to indicate it's not clickable */
  transform: none; /* Remove hover transform effect */
  box-shadow: none; /* Remove any shadows for a flat look */
  opacity: 0.7; /* Reduce opacity for a subtle effect */
}
.client-actions .action-button:disabled:hover {
  background-color: #d3d3d3; /* Keep the background as gray when disabled */
  color: #121111; /* Keep the text color gray */
  transform: none; /* Ensure no transform on hover */
}

@media (max-width: 1024px) {
  .sidebar {
    width: 25vw;
    z-index: 1000 !important;
  }

  .sidebar-toggle {
    z-index: 1001 !important;
  }
  .content {
    margin-left: 25vw;
  }

  .client-box {
    flex: 1 1 calc(100% - 20px);
    z-index: 10 !important;
    position: relative;
  }
}

@media (max-width: 768px) {
  .sidebar {
    width: 30vw;
  }

  .content {
    margin-left: 30vw;
  }

  .client-box {
    flex: 1 1 calc(100% - 20px);
  }
}

@media (max-width: 425px) {
  .sidebar {
    position: absolute;
    width: 100%;
    height: auto;
    transform: translateY(-100%);
  }

  .sidebar.show {
    transform: translateY(0);
  }

  .sidebar-toggle {
    position: fixed;
    top: 10px;
    left: 10px;
    z-index: 1001;
  }

  .content {
    margin-left: 0;
    padding: 10px;
  }

  .client-box {
    flex: 1 1 100%;
    padding: 10px;
    font-size: 14px;
  }
}

@media (max-width: 375px) {
  .sidebar {
    width: 90%;
  }

  .client-box {
    padding: 10px !important;
    padding-top: 10px !important;
    padding-bottom: 10px !important;
    margin-left: -35px !important;
    width: 40vh;
    height: 10vh!;
    font-size: 12px;
    z-index: 10 !important;
  }
}

@media (max-width: 320px) {
  .sidebar {
    width: 100%;
  }

  .client-box {
    padding: 6px;
    font-size: 10px;
  }
}
</style>
