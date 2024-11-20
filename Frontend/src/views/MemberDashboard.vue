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
      <div class="user-info">
        <div class="user-info-box">
          <p>Francis Emil Rosete</p>
          <p class="member-text">Member</p>
        </div>
      </div>
    </aside>

    <main class="content">
      <h1>Welcome, Francis!</h1>
      <div class="dashboard-content">
        <div class="bmi-box">
          <h2>BMI</h2>
          <p>29.8</p>
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
        <div class="calorie-box">
          <h2>Calorie Recommendation</h2>
          <p>1200 - 1500 kcal/day</p>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showSidebar: false,
    };
  },
  methods: {
    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
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
}

.sidebar .logo img {
  width: 50px;
  height: 60px;
  margin-bottom: 20px;
  margin-left: 0%;
  margin-top: -160%;
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

.content {
  margin-left: 250px;
  padding: 20px;
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

.schedule-section {
  background-color: #fff;
  color: #000;
  padding: 20px;
  text-align: left;
  border-radius: 20px;
}

.schedule-item {
  margin-bottom: 10px;
  padding: 10px;
  background-color: #f5f5f5;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
}

.calorie-box {
  background-color: #f5f5f5;
  color: #000000;
  padding: 20px;
  text-align: center;
  border-radius: 10px;
  border-color: #000;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5); 
  width: 205%;
  height: 300%;
}

.calorie-box h2{
margin-bottom: 10px;
}

</style>
