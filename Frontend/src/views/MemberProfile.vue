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
      <div class="user-info">
        <div class="user-info-box">
          <p>Francis Emil Rosete</p>
          <p class="member-text">Member</p>
        </div>
      </div>
    </aside>

    <main class="content">
      <h1>Your Goals For Today</h1>
      <div class="bmi-calculator">
        <h2>BMI Calculator</h2>
        <form>
          <div class="bmi-form">
            <p>Weight (kg):</p>
            <input type="number" id="weight" placeholder="Enter your weight" />
          </div>
          <div class="bmi-form">
            <p>Height (cm):</p>
            <input type="number" id="height" placeholder="Enter your height" />
          </div>
          <div class="bmi-form">
            <p>Calculated BMI:</p>
            <div class="bmi-result">Your BMI will appear here</div>
          </div>
          <button type="button" class="calculate-btn">Calculate BMI</button>
        </form>
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

.content {
  margin-left: 250px;
  padding: 75px;
  flex: 1;
  transition: margin-left 0.3s ease;
}

.content h1 {
  color: black;
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

.bmi-calculator {
  margin-top: 5%;
  margin-left: 70%;
  background: #eae9e9;
  padding: 20px;
  border-radius: 20px;
  max-width: 350px;
}

.bmi-calculator h2 {
  font-size: 1.5rem;
  color: #000;
  margin-bottom: 3vh;
}

.bmi-form {
  margin-bottom: 5%;
  color: #000;
  
}

.bmi-form input,
.bmi-result {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  font-size: 1rem;
  color: #000;
}

.bmi-result {
  background-color: #f9f9f9;
  text-align: center;
}

.calculate-btn {
  width: 100%;
  padding: 10px 0;
  background-color: #ac0700;
  color: #fff;
  border: none;
  border-radius: 10px;
  font-size: 1rem;
  cursor: pointer;
  transition: 0.3s;
}

.calculate-btn:hover {
  background: #000;
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
