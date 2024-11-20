<template>
  <div id="header">
    <div class="container">
      <div class="header-container">
        <router-link to="/LandingPage">
          <img src="../assets/logo.png" alt="Logo" class="logo" />
        </router-link>

        <div class="hamburger" @click="toggleMenu">
          <div class="line"></div>
          <div class="line"></div>
          <div class="line"></div>
        </div>

        <nav class="navbar" :class="{ active: isMenuOpen }">
          <ul id="sidemenu" :class="{ active: isMenuOpen }">
            <li><router-link to="/LandingPage">HOME</router-link></li>
            <li><router-link to="/AboutUs">ABOUT US</router-link></li>
            <li><router-link to="/Services">SERVICES</router-link></li>
            <li><router-link to="/OurTeam">OUR TEAM</router-link></li>
            <li><router-link to="/Contacts">CONTACTS</router-link></li>
          </ul>
        </nav>
      </div>

      <div class="container">
        <h1 class="sub-title" style="color: white">Our Services</h1>
        <div class="services-list">
          <div class="service-item">
            <font-awesome-icon icon="dumbbell" />
            <h2>General Fitness Facilities</h2>
            <p>Spaces designed to promote physical health and well-being.</p>
          </div>
          <div class="service-item">
            <font-awesome-icon icon="credit-card" />
            <h2>Membership Perks</h2>
            <p>
              Offering added value beyond basic access to workout equipment.
            </p>
          </div>
          <div class="service-item">
            <font-awesome-icon icon="chart-simple" />
            <h2>Fitness Tracking</h2>
            <p>
              Monitor and record various aspects of physical activity and
              health.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isMenuOpen: false, // Tracks whether the menu is open or not
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen; // Toggle the menu open/close state
    },
  },
};
</script>

<style scoped>
@font-face {
  font-family: "Grifter";
  src: url("grifterbold.otf");
}

* {
  margin: 0;
  padding: 0;
  font-family: "Figtree";
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
}

body {
  background: #080808;
  color: #fff;
}

#header {
  width: 100%;
  min-height: 100vh;
  background-color: #000;
}

.container {
  padding: 0vh 10%;
  display: flex;
  flex-direction: column;
}

.header-container {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  margin-top: 40px;
  margin-left: 10px;
}

.logo {
  height: 100px;
}

.hamburger {
  display: none;
  flex-direction: column;
  justify-content: space-between;
  width: 30px;
  height: 25px;
  cursor: pointer;
}

.hamburger .line {
  height: 4px;
  background-color: white;
  border-radius: 5px;
}

.navbar {
  display: flex;
}

.navbar ul {
  display: flex;
  list-style-type: none;
  gap: 20px;
}

.navbar li {
  margin: 20px;
}

.navbar a {
  color: white;
  text-decoration: none;
  font-size: 16px;
  transition: color 0.3s;
}

.navbar a:hover {
  color: #ac0700;
}

@media (max-width: 768px) {
  .container {
    padding-bottom: 50px; /* Adds extra space at the bottom */
  }

  .header-container {
    flex-direction: row; /* Align logo and hamburger side by side */
    justify-content: space-between; /* Space between logo and hamburger */
    align-items: center;
  }

  .logo {
    height: 70px;
    margin-right: 20px; /* Space between logo and hamburger */
  }

  .navbar ul {
    flex-direction: column;
    gap: 10px;
    align-items: center;
    margin-left: 43%;
    display: none; /* Hidden by default */
  }

  .navbar ul.active {
    display: flex; /* Show the navbar when active */
  }

  .hamburger {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 25px;
    cursor: pointer;
  }

  .navbar a {
    font-size: 14px;
  }
}

.services-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
  margin-top: 50px;
}

.service-item {
  background: #262626;
  padding: 40px;
  font-size: 13px;
  font-weight: 300;
  border-radius: 10px;
  transition: background 0.5s, transform 0.5s;
}

.service-item:hover {
  background: #ac0700;
  transform: translateY(-10px);
  color: white;
}

.service-item i {
  font-size: 50px;
  margin-bottom: 30px;
}

.service-item h2 {
  font-size: 30px;
  font-weight: 500;
  margin-bottom: 15px;
}

.service-item p {
  font-size: 15px;
}

@media (max-width: 425px) {
  .navbar ul {
    gap: 10px;
  }

  .navbar li {
    margin: 8px;
  }

  .service-item h2 {
    font-size: 18px;
  }

  .service-item p {
    font-size: 12px;
  }

  .services-list {
    gap: 15px;
  }

  .service-item {
    padding: 15px;
  }
}

@media (max-width: 375px) {
  .header-container {
    padding: 0 5%;
  }

  .logo {
    height: 60px;
  }

  .navbar ul {
    gap: 8px;
  }

  .service-item h2 {
    font-size: 16px;
  }

  .service-item p {
    font-size: 11px;
  }

  .services-list {
    gap: 10px;
  }

  .service-item {
    padding: 10px;
  }
}

@media (max-width: 320px) {
  .container {
    padding: 0 5%;
  }

  .logo {
    height: 50px;
  }

  .sub-title {
    font-size: 24px;
  }

  .service-item h2 {
    font-size: 14px;
  }

  .service-item p {
    font-size: 10px;
  }

  .services-list {
    gap: 8px;
  }

  .service-item {
    padding: 8px;
  }
}
</style>
