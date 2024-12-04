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
          <li>
            <a href="/MemberDashboard" style="color: #ac0700">Overview</a>
          </li>
          <li><a href="/MemberProfile">Profile</a></li>
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

    <main class="content">
      <h1>Welcome, {{ username }} !</h1>
      <div class="dashboard-content">
        <div class="bmi-box">
          <h2>BMI</h2>
          <p>{{  BMI  }}</p>
        </div>
        <div class="bmi-box">
          <h2>TIME</h2>
        </div>
        <div class="schedule-section">
          <h2>Schedule</h2>
          <div
            class="schedule-item"
            v-for="(item, index) in schedule"
            :key="index"
          >
            <p>{{ item.time }} - {{ item.topic }}</p>
          </div>
        </div>

        <transition
          name="fade"
          @before-enter="beforeEnter"
          @enter="enter"
          @leave="leave"
        >
          <div v-if="showFoodCalories" class="overlay">
            <div class="food-calories-modal">
              <h2>Insert Food Details</h2>
              <form>
                <label>
                  Food:
                  <input type="text" v-model="foodDetails.food" required />
                </label>
                <label>
                  Protein (g):
                  <input type="number" v-model="foodDetails.protein" required />
                </label>
                <label>
                  Carbs (g):
                  <input type="number" v-model="foodDetails.carbs" required />
                </label>
                <label>
                  Fats (g):
                  <input type="number" v-model="foodDetails.fats" required />
                </label>
                <label>
                  Total Calories:
                  <input
                    type="number"
                    v-model="foodDetails.total_Calories"
                    disabled
                  />
                </label>
                <div class="button-group">
                  <button type="button" @click="calculateFoodCalories">
                    Calculate
                  </button>
                  <button type="button" @click="showFoodCalories = false">
                    Close
                  </button>
                </div>
              </form>
            </div>
          </div>
        </transition>
        <!-- <div class="dietplan" v-if="recom.dietplan">
          <h2>DIET PLAN</h2>
          <p>{{ recom.dietplan }}</p>
        </div>
        <div class="workoutplan" v-if="recom.workoutplan">
          <h2>WORKOUT PLAN</h2>
          <p>{{ recom.workoutplan }}</p>
        </div>
        <div class="additionalnotes" v-if="recom.additionalnotes">
          <h2>ADDITIONAL NOTES</h2>
          <p>{{ recom.additionalnotes }}</p>
        </div>
        <button @click="getRecom" class="recom-button">Get Recommendations</button> -->
        <div class="calorie-box">
          <h2>Daily Caloric Needs</h2>
          <form @submit.prevent="computeDailyCalories">
            <select v-model="goal">
              <option value="lose weight">Lose weight</option>
              <option value="gain weight">Gain weight</option>
              <option value="null">Maintenance</option>
            </select>
            <select v-model="activityLevel">
              <option value="sedentary">
                Sedentary (little or no exercise)
              </option>
              <option value="lightly active">
                Lightly Active (light exercise/sports 1-3 days/week)
              </option>
              <option value="moderately active">
                Moderately Active (moderate exercise/sports 3-5 days/week)
              </option>
              <option value="very active">
                Very Active (hard exercise/sports 6-7 days a week)
              </option>
              <option value="extra active">
                Extra Active (very hard exercise/sports & physical job or 2x
                training)
              </option>
            </select>
            <p>Calories per day: {{ CalorieReq.dailyCalories }}</p>
            <button type="submit">Compute Calorie Requirements</button>
          </form>
        </div>
        <div class="food-calories" @click="showFoodCalories = true">
          <h2>Food Calories Calculator</h2>
          <p class="food-info">Click to compute your meal's total calories</p>
        </div>

        <div class="recommendations">
          <div class="col-4 button">
            <h2>Recommendations</h2>
            <label for="fitness-level">Fitness Level:</label>
            <select id="fitness-level" v-model="fitnessLevel">
              <option value="" disabled selected>Select a fitness level</option>
              <option value="beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="expert">Expert</option>
            </select>
            <label for="goal">Goal:</label>
            <select id="goal" v-model="goal">
              <option value="" disabled selected>Select a goal</option>
              <option value="weight loss">Weight Loss</option>
              <option value="muscle gain">Muscle Gain</option>
              <option value="general fitness">General Fitness</option>
              <option value="flexibility">Flexibility</option>
              <option value="endurance">Endurance</option>
            </select>
            <button @click="fetchRecommendations">Get Recommendations</button>
          </div>
        </div>

        <div class="col-4 dietplan">
          <h2>DIET PLAN</h2>
          <p>{{ recom.dietPlan }}</p>
        </div>

        <div class="col-4 workoutplan">
          <h2>WORKOUT PLAN</h2>
          <p>{{ recom.workoutPlan }}</p>
        </div>

        <div class="col-4 additionalnotes">
          <h2>ADDITIONAL NOTES</h2>
          <p>{{ recom.additionalNotes }}</p>
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
      showSidebar: true,
      showLogoutConfirm: false,
      showFoodCalories: false,
      foodDetails: {
        food: "",
        protein: 0,
        carbs: 0,
        fats: 0,
        total_Calories: 0,
      },
      recom: {
        dietplan: "",
        workoutplan: "",
        foodplan: "",
      },
      CalorieReq: {
        goal: "",
        activityLevel: "",
        dailyCalories: 0,
      },
      BMI: 0,
      username: "",
    };
  },

  created() {
    this.getData();  
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

    async getData() {
      try{
        const response = await apiClient.get("/Member/ViewInfo", {withCredentials: true});
        if(response.data.status.remarks == "success"){
          this.BMI = response.data.payload[0].BMI;
          this.username = response.data.payload[0].Username;
        }
      }catch(error){
        console.error("Error:", error);
        this.error = "An error occurred while calculating BMI. Please try again.";
      }
    },

    async computeDailyCalories() {
      const data = {
        activityLevel: this.CalorieReq.activityLevel,
        goal: this.CalorieReq.goal,
      };
      try {
        const response = await apiClient.post("/Member/Daily-Calories", data, {
          withCredentials: true,
        });
        console.log(response.data);
        if (response.data.status.remarks == "success") {
          this.CalorieReq.dailyCalories = response.data.payload;
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },

    async fetchRecommendations() {
      const recomData = {
        goal: this.goal.toLowerCase(),
        fitnessLevel: this.fitnessLevel.toLowerCase(),
      };
      try {
        const response = await apiClient.post(
          "/Member/Get-Recommendation",
          recomData,
          {
            withCredentials: true,
          }
        );
        console.log("API Response:", response.data);

        if (response.data.status.remarks == "success") {
          const recommendation = response.data.payload[0];
          this.recom.dietPlan =
            recommendation.diet_plan || "No diet plan available.";
          this.recom.workoutPlan =
            recommendation.workout_plan || "No workout plan available.";
          this.recom.additionalNotes =
            recommendation.additional_notes || "No additional notes.";

          console.log("Updated recom:", this.recom);
        }
      } catch (error) {
        console.error("Error fetching recommendations:", error);
        this.error =
          "An error occurred while fetching recommendations. Please try again.";
      }
    },
    async calculateFoodCalories() {
      const data = {
        food: this.foodDetails.food,
        protein: this.foodDetails.protein,
        carbs: this.foodDetails.carbs,
        fats: this.foodDetails.fats,
      };
      try {
        const response = await apiClient.post("/Member/Food-Calories ", data);
        console.log(response.data);

        if (
          response.data &&
          response.data.status &&
          response.data.status.remarks === "success"
        ) {
          this.foodDetails.total_Calories = response.data.payload;
        }
      } catch (error) {
        console.error("Error calculating food calories:", error);
        this.error =
          "An error occurred while calculating food calories. Please try again.";
      }
    },
    async saveFoodDetails() {
      await this.calculateFoodCalories();
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

.member-text {
  font-size: 0.8rem;
}

.content {
  margin-left: 20%;
  padding: 10vh !important;
  flex: 1;
}

.content h1 {
  color: black;
}

.dashboard-content {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 20px;
  margin-top: 20px;
}

.bmi-box,
.schedule-section {
  background-color: #ac0700;
  color: #fff;
  padding: 20px;
  text-align: center;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.bmi-box h2,
.schedule-section h2 {
  margin-bottom: 10px;
}

.bmi-box p {
  font-size: 2rem;
  font-weight: bold;
}

.col-4 {
  align-items: center;
  background-color: #f9f9f9;
  color: #000000;
  padding: 20px;
  text-align: center;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.col-4 h2 {
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.col-4 select {
  width: 87%;
  margin: 10px 0;
  border-radius: 5px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.col-4 select:focus {
  border-color: #ac0700;
}

.col-4 button {
  background-color: #ac0700;
  color: #fff;
  padding: 10px 20px;
  font-size: 1rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.3s;
  margin-top: 10px;
}

.col-4 button:hover {
  background-color: #ffffff;
  color: #ac0700;
  transform: scale(1.05);
}

.dietplan,
.workoutplan,
.additionalnotes {
  background-color: #ac0700;
  color: #ffffff;
  padding: 20px;
  text-align: center;
  border-radius: 10px;
  border-color: #000;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
  width: 100%;
  height: auto;
}

.dietplan h2,
.workoutplan h2,
.additionalnotes h2 {
  margin-bottom: 10px;
}

.dietplan p,
.workoutplan p,
.additionalnotes p {
  font-size: 2rem;
  font-weight: bold;
}

.schedule-section {
  background-color: #e0f7fa;
  color: #000;
  padding: 20px;
  text-align: left;
  border-radius: 20px;
}

.schedule-item {
  margin-bottom: 10px;
  padding: 10px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 1);
}

.calorie-box,
.food-calories {
  align-items: center;
  background-color: #f9f9f9;
  color: #000000;
  padding: 20px;
  text-align: center;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.calorie-box h2 {
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.calorie-box select {
  width: 87%;
  margin: 10px 0;
  border-radius: 5px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.calorie-box select:focus {
  border-color: #ac0700;
}

.calorie-box button {
  background-color: #ac0700;
  color: #fff;
  padding: 10px 20px;
  font-size: 1rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.3s;
  margin-top: 10px;
}

.calorie-box button:hover {
  background-color: #ffffff;
  color: #ac0700;
  transform: scale(1.05);
}
.food-calories {
  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s ease;
}

.food-calories:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.7);
}

.food-calories h2 {
  font-size: 1.5rem;
  margin-bottom: 1vh;
  margin-top: 10vh;
}

.food-info {
  font-size: 0.9rem;
  color: #000000;
  margin-top: 10px;
}
.food-calories-modal {
  position: fixed;
  top: 50%;
  left: 60%;
  transform: translate(-50%, -50%);
  background-color: rgba(255, 255, 255, 1);
  color: black;
  padding: 20px;
  border-radius: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.9);
  text-align: center;
  width: 300px;
}

.food-calories-modal h2 {
  margin-bottom: 20px;
}

.food-calories-modal form label {
  display: block;
  margin-bottom: 15px;
  font-weight: bold;
}

.food-calories-modal input {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.food-calories-modal .button-group {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.food-calories-modal button {
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.food-calories-modal button:hover {
  background-color: #ac0700;
  color: white;
}
</style>
