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
          <li><a href="/AdminMemberemail">Members Email</a></li>
          <li>
            <a href="/AdminMembercondition" style="color: #ac0700"
              >Members Condition</a
            >
          </li>
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
        <h1>MEMBERS CONDITION</h1>
      </header>
      <button class="create-profile-button" @click="toggleProfilePopup">
        Create Account
      </button>
      <table>
        <thead>
          <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Conditions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(member, index) in members" :key="index">
            <td>{{ member.User_ID }}</td>
            <td>{{ member.Username }}</td>
            <td>
              <ul>
                <li
                  v-for="(condition, cIndex) in member.Conditions"
                  :key="cIndex"
                >
                  {{ condition }}
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>

      <div
        v-if="showProfilePopup"
        class="overlay"
        @click="toggleProfilePopup"
      ></div>
      <div v-if="showProfilePopup" class="profile-popup">
        <h2>Enter Client Details</h2>
        <form @submit.prevent="createProfile">
          <div class="input-group">
            <label for="clientEmail">Email:</label>
            <input
              type="email"
              id="clientEmail"
              v-model="clientDetails.email"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientName">Username:</label>
            <input
              type="text"
              id="clientName"
              v-model="clientDetails.username"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientPassword">Password:</label>
            <input
              type="password"
              id="clientPassword"
              v-model="clientDetails.password"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientSubscription">Subscription Status:</label>
            <select
              id="clientSubscription"
              v-model="clientDetails.subscription"
              required
              class="custom-dropdown"
            >
              <option value="" disabled selected>Subscription Status</option>
              <option value="paid">Paid</option>
              <option value="unpaid">Unpaid</option>
            </select>
          </div>
          <div class="input-group">
            <label for="clientSubplan">Subscription Plan:</label>
            <select
              id="clientSubplan"
              v-model="clientDetails.subplan"
              required
              class="custom-dropdown"
            >
              <option value="" disabled selected>Subscription Plan</option>
              <option value="basic">Basic Plan</option>
              <option value="master">Master Plan</option>
              <option value="advanced">Advanced Plan</option>
            </select>
          </div>
          <div class="input-group">
            <label for="clientCondition">Condition:</label>
            <input
              type="number"
              id="clientCondition"
              v-model="clientDetails.condition"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientName">Name:</label>
            <input
              type="text"
              id="clientName"
              v-model="clientDetails.name"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientconNum">Contact Number:</label>
            <input
              type="tel"
              id="clientconNum"
              v-model="clientDetails.conNum"
              required
            />
          </div>
          <div class="input-group">
            <label for="clienteconNum">Emergency Contact Number:</label>
            <input
              type="tel"
              id="clienteconNum"
              v-model="clientDetails.econNum"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientAddress">Address:</label>
            <input
              type="text"
              id="clientAddress"
              v-model="clientDetails.address"
            />
          </div>
          <div class="input-group">
            <label for="clientage">Age:</label>
            <input
              type="number"
              id="clientage"
              v-model="clientDetails.age"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientsex">Sex:</label>
            <select
              id="clientsex"
              v-model="clientDetails.sex"
              required
              class="custom-dropdown"
            >
              <option value="" disabled selected>Select your sex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="input-group">
            <label for="clientgender">Gender:</label>
            <select
              id="clientgender"
              v-model="clientDetails.gender"
              required
              class="custom-dropdown"
            >
              <option value="" disabled selected>Select your gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Non-Binary">Non-Binary</option>
              <option value="Genderqueer">Genderqueer</option>
              <option value="Genderfluid">Genderfluid</option>
              <option value="Agender">Agender</option>
              <option value="Bigender">Bigender</option>
              <option value="Two-Spirit">Two-Spirit</option>
              <option value="Prefer not to say">Prefer not to say</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="input-group">
            <label for="clientbodyType">Body Type:</label>
            <select
              id="clientbodyType"
              v-model="clientDetails.bodyType"
              required
              class="custom-dropdown"
            >
              <option value="" disabled selected>Select your body type</option>
              <option>Ectomorph</option>
              <option>Mesomorph</option>
              <option>Endomorph</option>
              />
            </select>
          </div>
          <div class="input-group">
            <label for="clientactivityLevel">Activity Level:</label>
            <input
              type="text"
              id="clientactivityLevel"
              v-model="clientDetails.activityLevel"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientweight">Weight:</label>
            <input
              type="number"
              id="clientweight"
              v-model="clientDetails.weight"
              required
            />
          </div>
          <div class="input-group">
            <label for="clientHeight">Height:</label>
            <input
              type="number"
              id="clientHeight"
              v-model="clientDetails.height"
              required
            />
          </div>

          <div class="button-group">
            <button
              type="button"
              class="close-button"
              @click="toggleProfilePopup"
            >
              Close
            </button>
            <button type="submit" class="create-button">Create</button>
          </div>
        </form>
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
      members: [],
      showProfilePopup: false,
      clientDetails: {
        email: "",
        Username: "",
        Password: "",
        SubscriptionStat: "",
        subPlan: "",
        condition_ids: "",
        name: "",
        conNum: "",
        eConNum: "",
        address: "",
        age: "",
        sex: "",
        gender: "",
        bodyType: "",
        activityLevel: "",
        weight: "",
        height: "",
      },
    };
  },
  mounted() {
    apiClient.get("/Get/All").then((response) => {
      if (
        response.data.status.remarks === "success" &&
        Array.isArray(response.data.payload)
      ) {
        this.members = response.data.payload.map((member) => ({
          User_ID: member.User_ID,
          Username: member.Username,
          Conditions: member.conditions || [],
        }));
      }
    });
  },
  methods: {
    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
    },
    toggleProfilePopup() {
      this.showProfilePopup = !this.showProfilePopup;
    },
    createProfile() {
      console.log("Client Details:", this.clientDetails);
      alert("Profile created successfully!");
      this.toggleProfilePopup();
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

.create-profile-button {
  background-color: #ac0700;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  margin-left: 120vh;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  margin-bottom: 5px;
  transition: background-color 0.3s ease;
}

.create-profile-button:hover {
  background-color: #ffffff;
  color: #ac0700;
}

.profile-popup {
  position: fixed;
  top: 50%;
  left: 56%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  color: #000;
  padding: 20px;
  border-radius: 20px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  z-index: 1001;
  width: 90vh;
  height: 80vh;
  overflow: auto;
}

.input-group {
  margin-bottom: 15px;
}

.input-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.input-group input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.button-group {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.create-button,
.close-button {
  padding: 10px 20px;
  font-size: 1rem;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.create-button {
  background-color: #28a745;
  color: #fff;
}

.create-button:hover {
  background-color: #ffffff;
  color: #000;
}

.close-button {
  background-color: #ac0700;
  color: white;
}

.close-button:hover {
  background-color: #ffffff;
  color: #ac0700;
}

.custom-dropdown {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  background-color: white;
  appearance: none;
}

.custom-dropdown:focus {
  border-color: #4caf50;
  outline: none;
}

.custom-dropdown option {
  padding: 10px;
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
