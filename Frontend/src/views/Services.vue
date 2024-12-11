<template>
  <div id="header">
    <div class="container">
      <div class="header-container">
        <router-link to="/LandingPage">
          <img src="../assets/logo.png" alt="Logo" class="logo" />
        </router-link>
        <nav class="navbar">
          <img
            @click="toggleNavbar"
            class="navbartoggle"
            src="../assets/navbartoggle.png"
            alt="Menu"
          />
          <ul :class="{ visible: navbarVisible }">
            <li><router-link to="/">HOME</router-link></li>
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
      navbarVisible: false,
    };
  },
  methods: {
    toggleNavbar() {
      this.navbarVisible = !this.navbarVisible;
    },
    closeNavbarOnOutsideClick(event) {
      const navbar = this.$el.querySelector(".navbar");
      const toggle = this.$el.querySelector(".navbartoggle");
      if (!navbar.contains(event.target) && !toggle.contains(event.target)) {
        this.navbarVisible = false;
      }
    },
  },
  mounted() {
    document.addEventListener("click", this.closeNavbarOnOutsideClick);
  },
  beforeDestroy() {
    document.removeEventListener("click", this.closeNavbarOnOutsideClick);
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
  height: 100vh;
  background-image: url(./assets/background.png);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.container {
  padding: 0vh 10%;
  display: flex;
  flex-direction: column;
}

.header-container {
  display: flex;
  align-items: center;
  margin-bottom: -10vh;
  margin-top: 30px;
  margin-left: 10px;
}

.logo {
  height: 100px;
  margin-right: 300px;
}

.navbar {
  display: flex;
  align-items: center;
}

.navbar ul {
  display: flex;
  list-style-type: none;
  margin: 0;
  padding: 0;
  gap: 20px;
}

.navbar li {
  margin: 20px;
  margin-bottom: 12vh;
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

@keyframes float {
  from {
    transform: translateY(30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.services {
  padding: 60px 0;
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

@media (max-width: 1024px) {
  .header-container {
    flex-direction: column;
    align-items: center;
    margin-top: 30px;
  }

  .logo {
    margin: 0;
    margin-bottom: 10vh !important;
    height: 10vh;
  }

  .navbartoggle {
    display: block;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    top: -18vh;
    left: 18vh;
  }

  .navbar ul {
    flex-direction: column;
    position: fixed;
    top: 13vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 15vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .navbar li {
    margin: 10px;
  }

  .navbar a {
    font-size: 18px;
  }

  .services-list {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
  }

  .service-item {
    padding: 20px;
  }

  .service-item h2 {
    font-size: 20px;
  }

  .service-item p {
    font-size: 14px;
  }
}

@media (max-width: 768px) {
  .header-container {
    flex-direction: column;
    align-items: center;
  }

  .logo {
    height: 80px;
    margin: 0;
    margin-bottom: 5vh;
  }

  .navbartoggle {
    display: block;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    top: -19vh;
    left: 21vh;
  }

  .navbar ul {
    flex-direction: column;
    position: fixed;
    top: 15vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 15vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .services-list {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin-top: 10px;
  }

  .service-item h2 {
    font-size: 18px;
  }

  .service-item p {
    font-size: 12px;
  }
}

@media (max-width: 425px) {
  .logo {
    margin: 0;
    margin-bottom: 0vh !important;
    height: 10vh;
  }

  .navbartoggle {
    display: block;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    margin-top: 10vh;
    top: -18vh;
    left: 18vh;
  }

  .navbar ul {
    flex-direction: column;
    position: fixed;
    top: 12vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 15vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .services-list {
    gap: 15px;
  }

  .service-item {
    padding: 15px;
  }

  .service-item h2 {
    font-size: 16px;
  }

  .service-item p {
    font-size: 10px;
  }
}

@media (max-width: 375px) {
  .logo {
    height: 80px;
    margin: 0;
    margin-bottom: 5vh;
  }

  .navbartoggle {
    display: block;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    top: -19vh;
    left: 21vh;
  }

  .navbar ul {
    flex-direction: column;
    position: fixed;
    top: 15vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 15vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }
  .navbar a {
    font-size: 14px;
  }

  .services-list {
    gap: 10px;
  }

  .service-item h2 {
    font-size: 14px;
  }

  .service-item p {
    font-size: 10px;
  }
}

@media (max-width: 320px) {
  .logo {
    height:80px;
    margin: 0;
    margin-bottom: 10vh!important;
  }

  .navbartoggle {
    display: block;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    top: -19vh;
    left: 21vh;
  }

  .navbar ul {
    flex-direction: column;
    position: fixed;
    top: 15vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 15vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }
  .navbar a {
    font-size: 14px;
  }

  .services-list {
    gap: 10px;
  }

  .service-item h2 {
    font-size: 14px;
  }

  .service-item p {
    font-size: 10px;
  }
}
</style>
