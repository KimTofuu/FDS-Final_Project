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
          <li><a href="/AdminMemberinfo" style="color: #ac0700">Members Information</a></li>
          <li><a href="/AdminMemberemail">Members Email</a></li>
          <li><a href="/AdminMembercondition">Members Condition</a></li>
          <li><a href="/AdminMembersubscription">Members Subscription</a></li>
          <li><a href="/AdminCoach">Coaches Information</a></li>
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
        Create Account</button
      >>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact Number</th>
            <th>Emergency Contact Number</th>
            <th>Address</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Gender</th>
            <th>Body Type</th>
            <th>Activity Level</th>
            <th>Weight</th>
            <th>Height</th>
            <th>BMI</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(member, index) in members" :key="index">
            <td>{{ member.User_ID }}</td>
            <td>{{ member.name }}</td>
            <td>{{ member.conNum }}</td>
            <td>{{ member.eConNum }}</td>
            <td>{{ member.address }}</td>
            <td>{{ member.age }}</td>
            <td>{{ member.sex === 1 ? "Male" : "Female" }}</td>
            <td>{{ member.gender }}</td>
            <td>{{ member.bodyType }}</td>
            <td>{{ member.activityLevel }}</td>
            <td>{{ member.weight }}</td>
            <td>{{ member.height }}</td>
            <td>{{ member.BMI }}</td>
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
            <input type="email" id="clientEmail" v-model="clientDetails.Email" required/>
          </div>
          <div class="input-group">
            <label for="clientUsername">Username:</label>
            <input type="text" id="clientUsername" v-model="clientDetails.Username" required/>
          </div>
          <div class="input-group">
            <label for="clientPassword">Password:</label>
            <input type="password" id="clientPassword" v-model="clientDetails.Password" required/>
          </div>
          <div class="input-group">
            <label for="clientSubscription">Subscription Status:</label>
            <select id="clientSubscription" v-model="clientDetails.SubscriptionStat" required class="custom-dropdown">
              <option value="" disabled selected>Subscription Status</option>
              <option value="paid">Paid</option>
              <option value="unpaid">Unpaid</option>
            </select>
          </div>
          <div class="input-group">
            <label for="clientSubplan">Subscription Plan:</label>
            <select id="clientSubplan" v-model="clientDetails.subPlan" required class="custom-dropdown">
              <option value="" disabled selected>Subscription Plan</option>
              <option value="basic plan">Basic Plan</option>
              <option value="advanced plan">Advanced Plan</option>
              <option value="master plan">Master Plan</option>
            </select>
          </div>
          <div class="input-group">
            <label>Condition:</label>
            <div v-for="(condition, index) in conditions" :key="index" class="checkbox-group">
              <input
                type="checkbox"
                :id="'condition_' + index"
                :value="condition.value"
                v-model="clientDetails.condition_ids"
              />
              <label :for="'condition_' + index">{{ condition.label }}</label>
            </div>
          </div>
          <div class="input-group">
            <label for="clientName">Name:</label>
            <input type="text" id="clientName" v-model="clientDetails.name" required/>
          </div>
          <div class="input-group">
            <label for="clientconNum">Contact Number:</label>
            <input type="text" id="clientconNum" v-model="clientDetails.conNum" required/>
          </div>
          <div class="input-group">
            <label for="clienteconNum">Emergency Contact Number:</label>
            <input type="text" id="clienteconNum" v-model="clientDetails.eConNum" required/>
          </div>
          <div class="input-group">
            <label for="clientAddress">Address:</label>
            <input type="text" id="clientAddress" v-model="clientDetails.address"/>
          </div>
          <div class="input-group">
            <label for="clientage">Age:</label>
            <input type="number" id="clientage" v-model="clientDetails.age" required/>
          </div>
          <div class="input-group">
            <label for="clientsex">Sex:</label>
            <select id="clientsex" v-model="clientDetails.sex" required class="custom-dropdown">
              <option value="" disabled selected>Select your sex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="input-group">
            <label for="clientgender">Gender:</label>
            <select id="clientgender" v-model="clientDetails.gender" required class="custom-dropdown">
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
            <select id="clientbodyType" v-model="clientDetails.bodyType" required class="custom-dropdown">
              <option value="" disabled selected>Select your body type</option>
              <option>Ectomorph</option>
              <option>Mesomorph</option>
              <option>Endomorph</option>
              />
            </select>
          </div>
          <div class="input-group">
            <label for="clientactivityLevel">Activity Level:</label>
            <select id="clientactivityLevel" v-model="clientDetails.activityLevel" required class="custom-dropdown">
              <option value="" disabled selected>Select your body type</option>
              <option>Sedentary</option>
              <option>Lightly Active</option>
              <option>Modedately Active</option>
              <option>Very Active</option>
              <option>Extra Active</option>
              />
            </select>
          </div>
          <div class="input-group">
            <label for="clientweight">Weight:</label>
            <input type="number" id="clientweight" v-model="clientDetails.weight" required/>
          </div>
          <div class="input-group">
            <label for="clientHeight">Height:</label>
            <input type="number" id="clientHeight" v-model="clientDetails.height" required/>
          </div>

          <div class="button-group">
            <button type="button" class="close-button" @click="toggleProfilePopup">
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
      members: [], // Initialize an empty array to store the members data
      showProfilePopup: false,
      clientDetails: {
        Email: "",
        Username: "",
        Password: "",
        SubscriptionStat: "",
        subPlan: "",
        condition_ids: [],
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
      conditions: [
        { value: "0", label: "None" },
        { value: "1", label: "Hypertension" },
        { value: "2", label: "Heart Disease" },
        { value: "3", label: "Arrhythmia" },
        { value: "4", label: "Congestive Heart Failure" },
        { value: "5", label: "Peripheral Artery Disease" },
        { value: "6", label: "Asthma" },
        { value: "7", label: "Chronic Obstructive Pulmonary Disease (COPD)" },
        { value: "8", label: "Emphysema" },
        { value: "9", label: "Osteoarthritis" },
        { value: "10", label: "Rheumatoid Arthritis" },
        { value: "11", label: "Osteoporosis" },
        { value: "12", label: "Joint Replacements" },
        { value: "13", label: "Lower Back Pain" },
        { value: "14", label: "Tendonitis" },
        { value: "15", label: "Muscle Strains or Sprains" },
        { value: "16", label: "Diabetes (Type 1 or Type 2)" },
        { value: "17", label: "Obesity" },
        { value: "18", label: "Hypothyroidism" },
        { value: "19", label: "Hyperthyroidism" },
        { value: "20", label: "Stroke Recovery" },
        { value: "21", label: "Parkinson's Disease" },
        { value: "22", label: "Multiple Sclerosis" },
        { value: "23", label: "Epilepsy" },
        { value: "24", label: "Previous Fractures" },
      ],
    };
  },
  mounted() {
    apiClient
      .get("/Get/All")
      .then((response) => {
        // Check if the response status is success and the payload is an array
        if (
          response.data.status?.remarks === "success" &&
          Array.isArray(response.data.payload)
        ) {
          this.members = response.data.payload.map((member) => ({
            User_ID: member.User_ID, // Use Email as a unique ID if User_ID is not provided
            name: member.name,
            conNum: member.conNum,
            eConNum: member.eConNum,
            address: member.address,
            age: member.age,
            sex: member.sex,
            gender: member.gender,
            bodyType: member.bodyType,
            activityLevel: member.activityLevel,
            weight: member.weight,
            height: member.height,
            BMI: member.BMI,
          }));
        } else {
          console.error("Unexpected API response:", response.data);
          this.errorMessage = "Data format error. Please contact support.";
        }
      })
      .catch((error) => {
        console.error("Error fetching members data:", error);
        this.errorMessage = "Failed to fetch members. Please try again later.";
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
    async createProfile(){
      const clientData = {
        Email: this.clientDetails.Email,
        Username: this.clientDetails.Username,
        Password: this.clientDetails.Password,
        SubscriptionStat: this.clientDetails.SubscriptionStat,
        subPlan: this.clientDetails.subPlan,
        condition_ids: this.clientDetails.condition_ids,
        name: this.clientDetails.name,
        conNum: this.clientDetails.conNum,
        eConNum: this.clientDetails.eConNum,
        address: this.clientDetails.address,
        age: this.clientDetails.age,
        sex: this.clientDetails.sex,
        gender: this.clientDetails.gender,
        bodyType: this.clientDetails.bodyType,
        activityLevel: this.clientDetails.activityLevel,
        weight: this.clientDetails.weight,
        height: this.clientDetails.height
      }
      try{
        const response = await apiClient.post("/Create/Member", clientData, {withCredentials: true});
        if(response.data.status.remarks === 'success'){
          alert("Account successfully created");

        }
      }catch(error){
        console.log(error);
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
  margin-top: 20vh !important;
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
  color: #333;
  margin-bottom: 2vh !important;
}

.create-profile-button {
  background-color: #ac0700;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  margin-left: 128vh;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  margin-bottom: -2vh !important;
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
