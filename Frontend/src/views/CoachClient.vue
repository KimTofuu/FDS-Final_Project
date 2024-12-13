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
          <li><a href="/CoachClient" style="color: #ac0700">CLIENTS</a></li>
          <li><a href="/CoachProfile">PROFILE</a></li>
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
      <header class="page-header">
        <h1>MY CLIENTS</h1>
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
            <button @click="messageClient(client)" class="action-button">
              Message
            </button>
            <div
              v-if="showMessagePopup && selectedClientIndex !== null"
              class="overlay"
              @click="closePopup"
            >
              <div class="message-popup" @click.stop>
                <h2>Send Your Message</h2>
                <textarea
                  v-model="messageContent"
                  placeholder="Type your message here..."
                ></textarea>
                <div class="button-group">
                  <button @click="closePopup">Cancel</button>
                  <button
                    @click="sendMessage(clients[selectedClientIndex]?.Username)"
                    :disabled="loading"
                  >
                    <span v-if="loading">Sending...</span>
                    <span v-else>Send</span>
                  </button>
                </div>
              </div>
            </div>
            <button @click="viewClientPopup(client)" class="action-button">
              View
            </button>
            <button class="more-options" @click.stop="toggleOptions(index)">
              ⋮
            </button>
            <div
              v-if="activeDropdown === index"
              class="options-menu"
              @click.stop
            >
              <button @click="deleteClient(client.Username)">Delete</button>
            </div>
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
          <p><strong>Body Type:</strong> {{ clientDeets.bodyType }}</p>
          <p><strong>Condition:</strong> {{ clientDeets.condition }}</p>
          <p>
            <strong>Activity Level:</strong> {{ clientDeets.activityLevel }}
          </p>
          <p><strong>Weight:</strong> {{ clientDeets.weight }}</p>
          <p><strong>Height:</strong> {{ clientDeets.height }}</p>
          <p><strong>BMI:</strong> {{ clientDeets.BMI }}</p>
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
        bodyType: "",
        condition: "",
        activityLevel: "",
        weight: "",
        height: "",
        BMI: "",
      },
      showClientPopup: false,
      loading: false,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    messageClient(client) {
      this.selectedClientIndex = this.clients.findIndex(
        (c) => c.Username === client.Username
      );
      this.showMessagePopup = true;
    },
    closePopup() {
      this.showMessagePopup = false;
      this.messageContent = "";
      this.selectedClientIndex = null; // Reset the selected index
    },
    async sendMessage(clientUsername) {
      if (this.messageContent.trim()) {
        this.loading = true;
        const messageData = {
          Username: clientUsername,
          Subject: `Message from Coach`,
          Message: this.messageContent,
        };
        try {
          const response = await apiClient.post(
            "/Coach/Send-Message",
            messageData,
            { withCredentials: true }
          );
          console.log(response.data);
          if (response.data?.status?.remarks === "success") {
            alert("Message sent successfully!");
            this.closePopup();
          }
        } catch (error) {
          console.error("Error sending message:", error);
        } finally {
          this.loading = false;
        }
      } else {
        alert("Message cannot be empty.");
      }
    },
    toggleOptions(index) {
      this.activeDropdown = this.activeDropdown === index ? null : index;
    },
    addClient() {
      console.log("Add client button clicked");
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
    async fetchData() {
      try {
        const response = await apiClient.get("/Coach/View-Clients");
        if (
          response.data.status.remarks === "success" &&
          Array.isArray(response.data.payload)
        ) {
          this.clients = response.data.payload.map((member) => ({
            Username: member.Username,
            name: member.name,
          }));
        }
      } catch (error) {
        console.error("Error fetching clients:", error);
      }
    },
    async viewClientPopup(client) {
      const clientDataArg = {
        Username: client.Username,
      };
      this.showClientPopup = true;
      try {
        const response = await apiClient.post(
          "/Coach/View-one-Client",
          clientDataArg,
          { withCredentials: true }
        );
        if (response.data.status.remarks === "success") {
          console.log(response.data);
          this.clientDeets.name = response.data.payload[0].name;
          this.clientDeets.Username = response.data.payload[0].Username;
          this.clientDeets.email = response.data.payload[0].Email;
          this.clientDeets.conNum = response.data.payload[0].conNum;
          this.clientDeets.age = response.data.payload[0].age;
          this.clientDeets.sex = response.data.payload[0].sex;
          this.clientDeets.bodyType = response.data.payload[0].bodyType;
          this.clientDeets.condition = response.data.payload[0].condition;
          this.clientDeets.activityLevel =
            response.data.payload[0].activityLevel;
          this.clientDeets.weight = response.data.payload[0].weight;
          this.clientDeets.height = response.data.payload[0].height;
          this.clientDeets.BMI = response.data.payload[0].BMI;
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
  transition: transform 0.3s ease;
  transform: translateX(-100%);
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
  margin-top: 30vh !important;
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
  z-index: 1100;
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
  z-index: 1100;
}

.logout-confirmation button:hover {
  background-color: #ac0700;
  color: #fff;
  transform: scale(1.05);
  z-index: 1001;
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
  z-index: 1;
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

@media (max-width: 1024px) {
  .sidebar-toggle {
    display: block;
  }

  .sidebar {
    transform: translateX(-100%);
    min-height: 100vh;
    width: 250px;
  }

  .sidebar.show {
    transform: translateX(0);
  }

  .sidebar .logo img {
    width: 60px;
    height: 70px;
    margin-bottom: 10px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }

  .sidebar nav ul {
    list-style: none;
    width: 100%;
    padding: 0;
    text-align: center;
    margin-top: 120%;
  }

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
  .sidebar-toggle {
    display: block;
  }

  .sidebar {
    transform: translateX(-100%);
    min-height: 100vh;
    width: 250px;
  }

  .sidebar.show {
    transform: translateX(0);
  }

  .sidebar .logo img {
    width: 60px;
    height: 70px;
    margin-bottom: 10px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }
}

@media (max-width: 425px) {
  .client-box {
    flex: 1 1 100%;
    z-index: 10 !important;
    margin-left: -4vh !important;
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
  }

  .client-info {
    margin-bottom: 10px;
  }

  .client-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
  }

  .client-actions .action-button {
    padding: 10px;
    border-radius: 8px;
    margin-left: 15vh;
  }

  .client-actions .more-options {
    position: absolute; 
    top: 10px;         
    right: 10px;       
    transform: rotate(90deg);
    font-size: 18px;   
    cursor: pointer;   
  }
}

@media (max-width: 375px) { 
  .client-box {
    flex: 1 1 auto; 
    z-index: 10 !important;
    width: 100%; 
    max-width: 300px; 
    padding: 8px; 
    display: flex; 
    flex-direction: column; 
    align-items: center;
    text-align: center; 
    gap: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  }

  .client-info {
    margin-bottom: 5px;
    font-size: 12px; 
    word-wrap: break-word; 
  }

  .client-actions {
    display: flex;
    flex-direction: column; 
    gap: 5px; 
    width: 80%; 
  }

  .client-actions .action-button {
    padding: 6px; 
    border-radius: 6px; 
    font-size: 12px; 
    margin-left: 3vh; 
  }

  .client-actions .more-options {
    transform: rotate(90deg); 
    font-size: 16px; 
    position: absolute; 
    top: 8px; 
    right: 8px;
    cursor: pointer;
  }
}
</style>