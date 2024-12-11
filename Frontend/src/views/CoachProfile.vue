<template>
  <div class="sidebar-layout">
    <button @click="toggleSidebar" class="sidebar-toggle">☰</button>

    <aside :class="['sidebar', { show: showSidebar }]">
      <div class="logo">
        <router-link to="/CoachClient">
          <img src="@/assets/logononame.png" alt="Logo" class="logo-img" />
        </router-link>
      </div>

      <nav>
        <ul>
          <li>
            <a href="/CoachClient">CLIENTS</a>
          </li>
          <li>
            <a href="/CoachProfile" style="color: #ac0700">PROFILE</a>
          </li>
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

    <main class="profile-cont">
      <div class="profile-conts">
        <div class="profile-deets">
          <div class="deets-item">
            <label>Name:</label>
            <p>{{ profile.name }}</p>
          </div>
          <div class="detail-item">
            <label>Contact Number:</label>
            <p>{{ profile.conNumm }}</p>
          </div>
          <div class="detail-item">
            <label>Address:</label>
            <p>{{ profile.address }}</p>
          </div>
          <div class="detail-item">
            <label>Age:</label>
            <p>{{ profile.age }}</p>
          </div>
          <div class="detail-item">
            <label>Sex:</label>
            <p>{{ profile.sex }}</p>
          </div>
          <div class="detail-item">
            <label>Gender:</label>
            <p>{{ profile.gender }}</p>
          </div>
          <div class="detail-item">
            <label>Weight (kg):</label>
            <p>{{ profile.height }}</p>
          </div>
          <div class="detail-item">
            <label>Height (cm):</label>
            <p>{{ profile.weight }}</p>
          </div>
        </div>
        <button @click="openEditModal" class="update-button">Update</button>
      </div>
    </main>

    <transition name="fade">
      <div class="overlay" v-if="showEditModal" @click="closeEditModal">
      <div v-if="showEditModal" class="edit-modal" @click.stop>
        <div class="modal-content">
          <h2>Edit Profile</h2>
          <div class="form-group">
            <label for="name">Name:</label>
            <input
              type="text"
              id="name"
              v-model="profile.name"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="conNumm">Contact Number:</label>
            <input
              type="text"
              id="conNumm"
              v-model="profile.conNumm"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <input
              type="text"
              id="address"
              v-model="profile.address"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="age">Age:</label>
            <input
              type="number"
              id="age"
              v-model="profile.age"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="sex">Sex:</label>
            <input
              type="text"
              id="sex"
              v-model="profile.sex"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="gender">Gender:</label>
            <input
              type="text"
              id="gender"
              v-model="profile.gender"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="weight">Weight (kg):</label>
            <input
              type="number"
              id="weight"
              v-model="profile.height"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="height">Height (cm):</label>
            <input
              type="number"
              id="height"
              v-model="profile.weight"
              class="form-input"
            />
          </div>
          <div class="modal-buttons">
            <button @click="updateInfo" class="save-button">Save</button>
            <button @click="closeEditModal" class="cancel-button">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>  
    </transition>

    <main class="sched">
        <div class="sched-section">
          <h2>Schedule</h2>
          <div
            class="sched-item"
            v-for="(item, index) in schedule"
            :key="index"
          >
            <p>{{ item.time }} - {{ item.topic }}</p>
          </div>
        </div>
    </main>
  </div>
</template>

<script>
import apiClient from "@/api/axios"; // Import the API client

export default {
  data() {
    return {
      showLogoutConfirm: false,
      showSidebar: true,
      showEditModal: false,
      loadingProfile: false, // Loading state for profile fetching
      profileError: null, // Error state for profile fetching
      profile: {
        name: "John Doe",
        conNumm: "09XX-XXX-XXXX",
        address: "123 Main St. This City, This Country",
        age: 0,
        sex: "XX/XY",
        gender: "RAINBOW<<3",
        weight: 0,
        height: 0,
      },
      tempProfile: {},
    };
  },
  created() {
    this.fetchProfile(); // Fetch profile data when the component is created
  },
  methods: {
    async fetchProfile() {
      this.loadingProfile = true;
      this.profileError = null;
      try {
        const response = await apiClient.get("/Coach/View-Coach-Info", {
          withCredentials: true,
        });
        if (response.data?.status?.remarks === "success") {
          this.profile.name = response.data.payload[0].Name;
          this.profile.conNumm = response.data.payload[0].ContactNo;
          this.profile.address = response.data.payload[0].Address;
          this.profile.age = response.data.payload[0].Age;
          if(response.data.payload[0].Sex === 1) this.profile.sex = "Male";
          if(response.data.payload[0].Sex === 0) this.profile.sex = "Female";
          this.profile.gender = response.data.payload[0].Gender;
          this.profile.weight = response.data.payload[0].Weight;
          this.profile.height = response.data.payload[0].Height;
        } else {
          this.profileError =
            response.data?.message || "Failed to load profile data.";
        }
      } catch (error) {
        console.error("Error fetching profile:", error);
        this.profileError =
          "An error occurred while fetching profile data. Please try again.";
      } finally {
        this.loadingProfile = false;
      }
    },
    async updateInfo() {
      this.loadingProfile = true;
      this.profileError = null;
      const updateData = {
        Name: this.profile.name,
        ContactNo: this.profile.conNumm,
        Address: this.profile.address,
        Age: this.profile.age,
        Sex: this.profile.sex,
        Gender: this.profile.gender,
        Weight: this.profile.weight,
        Height: this.profile.height,
      };
      try {
        const response = await apiClient.post("/Coach/Update-Info", updateData, {
          withCredentials: true,
        });
        console.log(response.data);
        if (response.data?.status?.remarks === "success") {
          this.profile.name= response.data.payload[0].Name; 
          this.profile.conNumm= response.data.payload[0].ContactNo; 
          this.profile.address= response.data.payload[0].address; 
          this.profile.age= response.data.payload[0].Age; 
          this.profile.sex= response.data.payload[0].Sex; 
          this.profile.gender= response.data.payload[0].Gender; 
          this.profile.weight= response.data.payload[0].Weight; 
          this.profile.height= response.data.payload[0].Height;
          console.log("Profile updated successfully");
          this.closeEditModal(); // Close the edit modal after successful update
        }
      } catch (error) {
        console.error("Error updating profile:", error);
        this.profileError =
          "An error occurred while updating profile data. Please try again.";
      } finally {
        this.loadingProfile = false;
      }
    },
    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
    },
    async logout() {
      this.showLogoutConfirm = false;
      try {
        const response = await apiClient.post("/Logout");
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
    openEditModal() {
      this.tempProfile = { ...this.profile }; // Store a copy of the current profile
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
    },
    beforeEnter(el) {
      el.style.opacity = 0;
    },
    enter(el, done) {
      el.offsetHeight; // Trigger reflow
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
  margin-bottom: 10vh;
}

.logo-img {
  width: 50px;
  height: 60px;
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
  margin-top: 30vh!important;
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

.content h1 {
  color: #333;
  margin-bottom: 8vh;
}

.profile-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.form-group {
  width: 80%;
}

.form-group input {
  width: 100%;
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

.update-button {
  padding: 10px 20px;
  background-color: #000;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
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

  .profile-conts {
      display: flex;
      flex-direction: column; 
      gap: 20px;
  }

  .sched-section {
      margin-top: 0; 
      margin-left: 0; 
      width: 100%;
  }

  .edit-modal {
      position: relative; 
      margin-top: 20px; 
      width: 100%; 
      height: auto; 
      transform: none; 
      left: auto; 
      top: auto; 
  }
}

.update-button:hover {
  background-color: #ac0700;
  color: #fff;
}

.edit-modal {
  position: fixed;
  top: 50%;
  left: 55%;
  transform: translate(-50%, -50%);
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
  padding: 20px;
  width: 40%;
  height: 60%;
  z-index: 1100;
  overflow: hidden;
}

.modal-content {
  width: 100%;
  height: calc(100% - 40px);
  overflow-y: auto;
  padding: 20px;
  box-sizing: border-box;
  color: #000;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.modal-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.save-button,
.cancel-button {
  background-color: #ac0700;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.cancel-button {
  background-color: #ddd;
  color: black;
}

.save-button:hover,
.cancel-button:hover {
  opacity: 0.8;
}

.profile-cont {
  margin-left: 0vh;
  margin-top: 3%;
  padding: 20px;
  width: calc(90% - 200px);
  box-sizing: border-box;
}

.profile-conts {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.profile-deets {
  display: flex;
  flex-direction: column;
  gap: 10px;
  width: 70vh;
  height: 81vh;
  background-color: #fff;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.deets-item {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #ddd;
  padding: 10px 0;
}

.deets-item label {
  font-weight: bold;
  color: #333;
}

.deets-item p {
  margin: 0;
  color: #666;
  text-align: right;
}


.sched-section {
  margin-top: 10vh;
  margin-left: -30vh;
  padding: 25vh;
  width: 70vh;
  height: 80vh;
  background-color: #fff;
  color: #000;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
  gap: 10px;
  flex: 1;
}

.sched-container h2 {
  color: #000
}

.dash-content {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
  margin-top: 20px;
}

@media (max-width: 1024px) {
  .sidebar-toggle {
    display: block;
  }

  .sidebar nav ul {
  list-style: none;
  width: 100%;
  padding: 0;
  text-align: center;
  margin-top: 120%;
}

  .sidebar-layout {
    display: flex;
    flex-direction: column; 
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
    margin-bottom: 50px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }

  .profile-cont {
    margin-left: 10px;
    margin-top: 3%; 
    width: 100%; 
    box-sizing: border-box; 
  }

  .profile-conts {
    display: flex;
    flex-direction: column; 
    align-items: center;
    gap: 20px;
  }
  
  .profile-deets {
    width: 100%; 
    height: auto; 
    padding: 20px; 
  }
  
  .sched-section {
    width: 100%;
    height: auto; 
    padding: 20px; 
    box-sizing: border-box; 
    margin-left: 10px;
  }

  .edit-modal {
    width: 60%; 
    height: 70%;
    padding: 10px; 
    margin-top: 5%; 
  }

  .modal-content {
    padding: 10px; 
    box-sizing: border-box; 
  }

  .update-button {
    margin: 0 auto; 
    display: block;
    width: auto;
  }
}

@media (max-width: 768px) {
  
  .sidebar-toggle {
    display: block;
  }

  .sidebar-layout {
    display: flex;
    flex-direction: column; 
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
    margin-bottom: 50px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }

  .profile-cont {
    margin-left: 10px;
    margin-top: 3%; 
    width: 100%; 
    box-sizing: border-box; 
  }

  .profile-conts {
    display: flex;
    flex-direction: column; 
    align-items: center;
    gap: 20px;
  }
  
  .profile-deets {
    width: 100%; 
    height: 90%; 
    padding: 20px; 
  }
  
  .sched-section {
    width: 100%;
    height: 90%; 
    padding: 20px; 
    box-sizing: border-box; 
    margin-left: 10px;
  }

  .edit-modal {
    width: 60%; 
    height: 70%;
    padding: 10px; 
    margin-top: 5%; 
  }

  .modal-content {
    padding: 10px; 
    box-sizing: border-box; 
  }

.update-button {
    margin: 0 auto; 
    display: block;
    width: auto;
  }
}

@media (max-width: 425px) {
  
  .sidebar-toggle {
    display: block;
  }

  .sidebar-layout {
    display: flex;
    flex-direction: column; 
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
    margin-bottom: 50px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }

  .profile-cont {
    margin-left: 10px;
    margin-top: 3%; 
    width: 100%; 
    box-sizing: border-box; 
  }

  .profile-conts {
    display: flex;
    flex-direction: column; 
    align-items: center;
    gap: 20px;
  }
  
  .profile-deets {
    width: 100%; 
    height: 90%; 
    padding: 20px; 
  }
  
  .sched-section {
    width: 100%;
    height: 90%; 
    padding: 20px; 
    box-sizing: border-box; 
    margin-left: 10px;
  }

  .edit-modal {
    width: 80%; 
    height: 80%;
    padding: 10px; 
    margin-top: 3%; 
    margin-left: -3vh; 
   
  }

  .modal-content {
    padding: 5px; 
    box-sizing: border-box; 
  }

.update-button {
    margin: 0 auto; 
    display: block;
    width: auto;
  }
}

@media (max-width: 375px) {
  
  .sidebar-toggle {
    display: block;
  }

  .sidebar-layout {
    display: flex;
    flex-direction: column; 
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
    margin-bottom: 50px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }

  .profile-cont {
    margin-left: 10px;
    margin-top: 3%; 
    width: 100%; 
    box-sizing: border-box; 
  }

  .profile-conts {
    display: flex;
    flex-direction: column; 
    align-items: center;
    gap: 20px;
  }
  
  .profile-deets {
    width: 100%; 
    height: 90%; 
    padding: 20px; 
  }
  
  .sched-section {
    width: 100%;
    height: 90%; 
    padding: 20px; 
    box-sizing: border-box; 
    margin-left: 10px;
  }

  .edit-modal {
    width: 80%; 
    height: 80%;
    padding: 10px; 
    margin-top: 3%; 
    margin-left: -2vh; 
   
  }

  .modal-content {
    padding: 5px; 
    box-sizing: border-box; 
  }

.update-button {
    margin: 0 auto; 
    display: block;
    width: auto;
  }
}
</style>
