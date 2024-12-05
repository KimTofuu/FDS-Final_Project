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
          <button @click="addClient" class="add-client-button">
            + Add Client
          </button>
        </header>
        <div class="clients-container">
          <div class="client-box" v-for="(client, index) in clients" :key="index" @click.stop>
            <div class="client-icon">
              <img src="../assets/pfp.jpg" alt="Client Icon" />
            </div>
            <div class="Client-Info" style="color: black;">
              <h5>{{ client.name }}</h5>
              <h2>{{ client.Username }}</h2>
            </div>
            <div class="client-actions">
              <button @click="messageClient(index)" class="action-button">Message</button>
              <button @click="" class="action-button">View</button>
              <button class="more-options" @click.stop="toggleOptions(index)">⋮</button>
              <div v-if="activeDropdown === index" class="options-menu" @click.stop>
                <button @click="messageClient(index)">Message Client</button>
                <button @click="deleteClient(index)">Delete</button>
              </div>
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
      showLogoutConfirm: false, 
      showSidebar: true, 
      clients: [], 
      activeDropdown: null, 
      clientDeets:{
        Username: "",
        name: "",
        conNum: "",
        age: 0,
		    sex: 0,
		    bodyType: "",
		    activityLevel: "",
		    weight: "",
		    height: "",
		    BMI: ""
      }
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async logout() {
      this.showLogoutConfirm = false; // Hide logout confirmation dialog
      try {
        const response = await apiClient.post("/Logout"); // API call for logout
        console.log(response.data);
        if (response.data?.status?.remarks === "success") {
          this.$router.push("/MainLogin"); // Redirect to MainLogin on success
        } else {
          this.error = response.data.message || "Logout failed"; // Set error message
        }
      } catch (error) {
        console.error("Logout Error:", error); // Log any errors
        this.error = "An error occurred while logging out. Please try again."; // Fallback error message
      }
    },
    async fetchData() {
      apiClient.get("/Coach/View-Clients")
    .then((response) => {
      if (response.data.status.remarks === "success" && Array.isArray(response.data.payload)) {
        this.clients = response.data.payload.map((member) => ({
          Username: member.Username,
          name: member.name
        }))
      }
    })
    },
    async viewClient(id){
      try{
        const response = await apiClient.get('/Coach/View-Client', {User_ID: id}, {withCredentials: true} );
        if(response.data.status.remarks === "success"){
          this.clientDeets.Username = response.data.payload[0].Username;
          this.clientDeets.name = response.data.payload[0].name;
          this.clientDeets.conNum = response.data.payload[0].conNum;
          this.clientDeets.age = response.data.payload[0].age;
          this.clientDeets.sex = response.data.payload[0].sex;
          this.clientDeets.bodyType = response.data.payload[0].bodyType;
          this.clientDeets.activityLevel = response.data.payload[0].activityLevel;
          this.clientDeets.weight = response.data.payload[0].weight;
          this.clientDeets.height = response.data.payload[0].height;
          this.clientDeets.BMI = response.data.payload[0].BMI;s
        }
      }catch(error){
        console.error(error);
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
    // Toggles the visibility of the sidebar
    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
    },

    // Toggles options dropdown for a specific client
    toggleOptions(index) {
      this.activeDropdown = this.activeDropdown === index ? null : index;
    },

    // Placeholder for deleting a client
    deleteClient(index) {
      console.log(`Delete client at index ${index}`);
    },

    // Placeholder for messaging a client
    messageClient(index) {
      console.log(`Message client at index ${index}`);
      this.$router.push(`/message-client/${index}`); // Example navigation
    },

    // Closes dropdown when clicking outside
    closeDropdownOnOutsideClick() {
      this.activeDropdown = null;
    },

    // Placeholder for adding a new client
    addClient() {
      console.log("Add client button clicked");
    },

    // Handles the logout process
  
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

.add-client-button {
  background-color: #ac0700;
  color: white;
  padding: 15px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s;
}

.add-client-button:hover {
  background-color: #d10a00;
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

.more-options {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
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
</style>