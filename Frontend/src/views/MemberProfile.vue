<template>
  <div class="sidebar-layout">
    <button @click="toggleSidebar" class="sidebar-toggle">☰</button>

    <aside :class="['sidebar', { show: showSidebar }]">
      <div class="logo">
        <router-link to="/MemberDashboard">
          <img src="@/assets/logononame.png" alt="Logo" class="logo-img" />
        </router-link>
      </div>

      <nav>
        <ul>
          <li><a href="/MemberDashboard">Overview</a></li>
          <li><a href="/MemberProfile" style="color: #ac0700">Profile</a></li>
          <li><a href="/MemberCoaches">Coaches</a></li>
          <li><a href="/MemberUpgrade">Upgrade</a></li>
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

    <main class="profile-container">
      <div class="profile-content">
        <div class="profile-details">
          <div class="detail-item">
            <label>Name:</label>
            <p>{{ profile.name }}</p>
          </div>
          <div class="detail-item">
            <label>Contact Number:</label>
            <p>{{ profile.conNumm }}</p>
          </div>
          <div class="detail-item">
            <label>Emergency Contact Number:</label>
            <p>{{ profile.econNumm }}</p>
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
            <label>Body Type:</label>
            <p>{{ profile.bodyType }}</p>
          </div>
          <div class="detail-item">
            <label>Level of Activity:</label>
            <p>{{ profile.activityLevel }}</p>
          </div>
          <div class="detail-item">
            <label>Weight (kg):</label>
            <p>{{ profile.weight }}</p>
          </div>
          <div class="detail-item">
            <label>Height (cm):</label>
            <p>{{ profile.height }}</p>
          </div>
        </div>
        <button @click="openEditModal" class="update-button">Update</button>
      </div>
    </main>

    <transition name="fade">
      <div v-if="showEditModal" class="edit-modal" @click.self="closeEditModal">
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
            <label for="econNumm">Emergency Contact Number:</label>
            <input
              type="text"
              id="econNumm"
              v-model="profile.econNumm"
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
            <label for="gender">Body Type:</label>
            <input
              type="text"
              id="gender"
              v-model="profile.bodyType"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="gender">Level of Activity:</label>
            <input
              type="text"
              id="gender"
              v-model="profile.activityLevel"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="weight">Weight (kg):</label>
            <input
              type="number"
              id="weight"
              v-model="profile.weight"
              class="form-input"
            />
          </div>
          <div class="form-group">
            <label for="height">Height (cm):</label>
            <input
              type="number"
              id="height"
              v-model="profile.height"
              class="form-input"
            />
          </div>
          <div class="modal-buttons">
            <button @click="saveProfile" class="save-button">Save</button>
            <button @click="closeEditModal" class="cancel-button">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </transition>

    <main class="session-container">
      <div class="session-box set-session">
        <h2>Set Session</h2>
        <p>Configure your session details here.</p>
        <button @click="showSessionPopup = true">Set Session</button>
      </div>

      <transition name="fade">
        <div
          v-if="showSessionPopup"
          class="session-popup"
          @click.self="closeSessionPopup"
        >
          <div class="popup-content">
            <h2>Set Session</h2>
            <div class="form-group">
              <label for="session-date">Date:</label>
              <input
                type="date"
                id="session-date"
                v-model="sessionDetails.date"
                class="form-input"
              />
            </div>
            <div class="form-group">
              <label for="session-time">Time:</label>
              <input
                type="time"
                id="session-time"
                v-model="sessionDetails.time"
                class="form-input"
              />
            </div>
            <div class="form-group">
              <label for="session-coach">Coach:</label>
              <input
                type="text"
                id="session-coach"
                v-model="sessionDetails.coach"
                class="form-input"
              />
            </div>
            <div class="modal-buttons">
              <button @click="submitSession" class="save-button">Submit</button>
              <button @click="closeSessionPopup" class="cancel-button">
                Cancel
              </button>
            </div>
          </div>
        </div>
      </transition>

      <div class="session-box set-alarm">
        <h2>Set Alarm</h2>
        <p>Set the time for your alarm.</p>
        <button @click="openAlarmPopup">Set Alarm</button>
      </div>

      <transition name="fade">
        <div
          v-if="showAlarmPopup"
          class="session-popup"
          @click.self="closeAlarmPopup"
        >
          <div class="popup-content">
            <h2>Set Alarm</h2>
            <div class="form-group">
              <label for="alarm-day">Day:</label>
              <input
                type="text"
                id="alarm-day"
                v-model="alarmDetails.day"
                class="form-input"
                placeholder="Enter the day (e.g., Monday)"
              />
            </div>
            <div class="form-group">
              <label for="alarm-time">Time:</label>
              <input
                type="time"
                id="alarm-time"
                v-model="alarmDetails.time"
                class="form-input"
              />
            </div>
            <div class="modal-buttons">
              <button @click="submitAlarm" class="save-button">Submit</button>
              <button @click="closeAlarmPopup" class="cancel-button">
                Cancel
              </button>
            </div>
          </div>
        </div>
      </transition>
    </main>
  </div>
</template>

<!-- <script>
export default {
data() {
    return {
      showSidebar: true,
      showLogoutConfirm: false,
      showEditModal: false,
      showSessionPopup: false,
      showAlarmPopup: false,
      sessionDetails: {
        date: "",
        time: "",
        coach: "",
      },
      alarmDetails: {
        day: "",
        time: "",
      },
      profile: {
        name: "John Doe",
        conNumm: "09XX-XXX-XXXX",
        econNumm: "09XX-XXX-XXXX",
        address: "123 Main St. This City, This Country",
        age: "25",
        sex: "Male",
        gender: "Male",
        weight: "65",
        height: "175",
      },
      tempProfile: {},
    };
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
    openEditModal() {
      this.tempProfile = { ...this.profile };
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
    },
    saveProfile() {
      this.profile = { ...this.tempProfile };
      console.log("Profile saved:", this.profile);
      this.closeEditModal();
    },
    openSessionPopup() {
      console.log("Opening session popup");
      this.showSessionPopup = true;
    },
    closeSessionPopup() {
      this.showSessionPopup = false;
    },
    submitSession() {
      console.log("Session details:", this.sessionDetails); // Use sessionDetails
      this.closeSessionPopup();
    },
    openAlarmPopup() {
      this.showAlarmPopup = true;
    },
    closeAlarmPopup() {
      this.showAlarmPopup = false;
    },
    submitAlarm() {
      console.log("Alarm details:", this.alarmDetails); // Log the alarm details
      this.closeAlarmPopup(); // Close the popup
    },
  },
};
</script> -->

<script>
import apiClient from "@/api/axios"; // Assuming you have an API client setup

export default {
  data() {
    return {
      showSidebar: true,
      showLogoutConfirm: false,
      showEditModal: false,
      showSessionPopup: false,
      showAlarmPopup: false,
      sessionDetails: {
        date: "",
        time: "",
        coach: "",
      },
      alarmDetails: {
        day: "",
        time: "",
      },
      profile: {
        name: "John Doe",
        conNumm: "09XX-XXX-XXXX",
        econNumm: "09XX-XXX-XXXX",
        address: "123 Main St. This City, This Country",
        age: 0,
        sex: "XX/XY",
        gender: "RAINBOW<<3",
        bodyType: "XXXXXXX",
        activityLevel: "XXXXXX",
        weight: 0,
        height: 0,
      },
      tempProfile: {},
      loadingProfile: false, // Loading state for profile fetching
      profileError: null, // Error state for profile fetching
    };
  },
  created() {
    this.fetchProfile();
  },
  methods: {
    async fetchProfile() {
      this.loadingProfile = true;
      this.profileError = null;
      try {
        const response = await apiClient.get("/Member/ViewInfo", {withCredentials: true}); // Replace with your API endpoint
        if (response.data?.status?.remarks === "success") {
          this.profile.name = response.data.payload[0].name;
          this.profile.conNumm = response.data.payload[0].conNum;
          this.profile.econNumm = response.data.payload[0].eConNum;
          this.profile.address = response.data.payload[0].address;
          this.profile.age = response.data.payload[0].age;
          if(response.data.payload[0].sex === 1) this.profile.sex = "Male";
          if(response.data.payload[0].sex === 0) this.profile.sex = "Female";
          this.profile.gender = response.data.payload[0].gender;
          this.profile.bodyType = response.data.payload[0].bodyType;
          this.profile.activityLevel = response.data.payload[0].activityLevel;
          this.profile.weight = response.data.payload[0].weight;
          this.profile.height = response.data.payload[0].height;
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
    openEditModal() {
      this.tempProfile = { ...this.profile };
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
    },
    saveProfile() {
      this.profile = { ...this.tempProfile };
      console.log("Profile saved:", this.profile);
      this.closeEditModal();
    },
    openSessionPopup() {
      console.log("Opening session popup");
      this.showSessionPopup = true;
    },
    closeSessionPopup() {
      this.showSessionPopup = false;
    },
    submitSession() {
      console.log("Session details:", this.sessionDetails);
      this.closeSessionPopup();
    },
    openAlarmPopup() {
      this.showAlarmPopup = true;
    },
    closeAlarmPopup() {
      this.showAlarmPopup = false;
    },
    async submitAlarm() {
      const alarmData = {
        day: this.alarmDetails.day,
        time: this.alarmDetails.time,
      };
      try{
        const response = await apiClient.post("/Member/setAlarm", alarmData, {withCredentials: true});
        if(response.data.status.remarks === "success"){
          console.alert("Alarm set successfully");
        }
      }catch(error){
        console.log(error);
        this.error = "An error occurred while logging out. Please try again.";

      }
      this.closeAlarmPopup();
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
  height: 100vh;
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
}

.sidebar .logo img {
  width: 50px;
  height: 60px;
  margin-bottom: 20px;
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

.sidebar a:hover {
  color: #ac0700;
}

.user-info {
  margin-top: auto;
  padding-bottom: 20px;
  text-align: center;
}

.user-info-box {
  background-color: #ac0700;
  color: #fff;
  padding: 10px 20px;
  border-radius: 20px;
  text-align: center;
}

.member-text {
  font-size: 0.8rem;
}

.session-container {
  margin-left: 10vh;
  margin-top: 19vh;
  padding: 20px;
  width: calc(100% - 110px);
  box-sizing: border-box;
}

.session-box {
  width: 65%;
  height: 35%;
  margin: 20px auto;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  padding: 20px;
  margin: 10px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.set-session {
  background-color: #e0f7fa;
}

.set-alarm {
  background-color: #e0f7fa;
}

.session-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: rgba(0, 0, 0, 0.7);
  width: 100%;
  height: 100%;
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
}

.popup-content {
  background: white;
  color: #000;
  padding: 20px;
  border-radius: 10px;
  width: 400px;
  max-width: 90%;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
  text-align: left;
}

.form-group label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
}

.form-input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
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
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.save-button:hover,
.cancel-button:hover {
  background-color: #333;
}

.session-box h2 {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.session-box p {
  font-size: 1rem;
  color: #000000;
  margin-bottom: 15px;
}

.session-box button {
  background-color: #ac0700;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
  transition: background-color 0.3s ease;
  margin-left: 7vh;
  display: block;
}

.session-box button:hover {
  background-color: #ffffff;
  color: #ac0700;
}

.sidebar-toggle {
  display: none;
  position: absolute;
  top: 20px;
  left: 20px;
  background-color: #333;
  color: #fff;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  z-index: 20;
}

.profile-container {
  margin-left: 20%;
  margin-top: 5%;
  padding: 20px;
  width: calc(90% - 200px);
  box-sizing: border-box;
}

.profile-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.profile-avatar .avatar-img {
  width: 50px;
  height: 50px;
  border-radius: 30px;
}

.profile-details {
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 80vh;
  height: 70vh;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.detail-item {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #ddd;
  padding: 10px 0;
}

.detail-item label {
  font-weight: bold;
  color: #333;
}

.detail-item p {
  margin: 0;
  color: #666;
  text-align: right;
}

.update-button {
  background-color: #ac0700;
  color: white;
  border: none;
  padding: 10px 20px;
  margin-top: 1vh;
  margin-left: 67vh;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}

.update-button:hover {
  background-color: #ffffff;
  color: #ac0700;
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
  z-index: 1000;
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
}

.logout-confirmation button:hover {
  background-color: #ac0700;
  color: #fff;
  transform: scale(1.05);
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

  .content {
    margin-left: 10% !important;
    padding-left: 20px;
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
  .sidebar {
    width: 100%;
  }

  .sidebar .logo img {
    width: 50px;
    height: 55px;
    margin-bottom: 15px;
  }

  .user-info-box {
    padding: 8px 15px;
    font-size: 0.9rem;
  }

  .sidebar nav ul li {
    margin: 25px 0;
  }

  .content {
    padding: 20px;
  }

  .content h1 {
    font-size: 1.8rem;
  }
}

@media (max-width: 375px) {
  .sidebar {
    width: 100%;
  }

  .sidebar .logo img {
    width: 45px;
    height: 50px;
    margin-bottom: 10px;
  }

  .user-info-box {
    padding: 6px 12px;
    font-size: 0.85rem;
  }

  .sidebar nav ul li {
    margin: 20px 0;
  }

  .content {
    padding: 15px;
  }

  .content h1 {
    font-size: 1.6rem;
  }
}

@media (max-width: 320px) {
  .sidebar {
    width: 100%;
  }

  .sidebar .logo img {
    width: 40px;
    height: 45px;
    margin-bottom: 10px;
  }

  .user-info-box {
    padding: 5px 10px;
    font-size: 0.8rem;
  }

  .sidebar nav ul li {
    margin: 18px 0;
  }

  .content {
    padding: 10px;
  }

  .content h1 {
    font-size: 1.4rem;
    margin-right: 0%;
  }
}
</style>
