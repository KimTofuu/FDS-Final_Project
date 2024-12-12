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
            <li><router-link to="/AboutUs">ABOUT US</router-link></li>
            <li><router-link to="/Services">SERVICES</router-link></li>
            <li><router-link to="/OurTeam">OUR TEAM</router-link></li>
            <li><router-link to="/Contacts">CONTACTS</router-link></li>
          </ul>
        </nav>
      </div>

      <div class="header-text">
        <div class="left-side">
          <h1>UNLEASH YOUR</h1>
          <h2>INNER GOD</h2>
          <p>
            Olympus Gym Club is a modern fitness center with top-notch
            equipment, diverse classes, and personalized training to help you
            achieve your health goals in a supportive environment.
          </p>
          <a href="/MainLogin"> <button>LOG IN</button> </a>
        </div>

        <div class="right"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      navbarVisible: false, // State for the navbar
    };
  },
  methods: {
    toggleNavbar() {
      this.navbarVisible = !this.navbarVisible; // Toggle navbar visibility
    },
    closeNavbarOnOutsideClick(event) {
      // Check if the click is outside the navbar or toggle
      const navbar = this.$el.querySelector(".navbar");
      const toggle = this.$el.querySelector(".navbartoggle");
      if (!navbar.contains(event.target) && !toggle.contains(event.target)) {
        this.navbarVisible = false; // Close the navbar
      }
    },
  },
  mounted() {
    // Add an event listener for clicks on the document
    document.addEventListener("click", this.closeNavbarOnOutsideClick);
  },
  beforeDestroy() {
    // Remove the event listener to prevent memory leaks
    document.removeEventListener("click", this.closeNavbarOnOutsideClick);
  },
};
</script>

<style scoped>
@font-face {
  font-family: Grifter;
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
  background-image: url(../assets/background.png);
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
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.navbar ul.hidden {
  transform: translateY(-100%);
  opacity: 0;
  pointer-events: none;
}

.navbar ul.visible {
  transform: translateY(0);
  opacity: 1;
  pointer-events: auto;
}

.navbartoggle {
  display: none;
  margin-top: 2vh;
  max-width: 6vh;
  max-height: 6vh;
  cursor: pointer;
}

.navbar li {
  margin: 30px;
  margin-bottom:12vh;
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

.header-text {
  margin-top: 10%;
  margin-bottom: 10%;
  transition: transform 0.3s;
  animation: float 1s;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.left-side {
  flex-basis: 56%;
}

.right {
  flex-basis: 40%;
}

.header-text h1 {
  color: white;
  font-family: "Grifter";
  font-size: 80px;
  margin-bottom: -30px;
}

.header-text h2 {
  color: #ac0700;
  font-size: 15px;
  font-family: "Grifter";
  font-size: 100px;
}

.header-text p {
  margin-top: 1%;
  color: #ded9d9;
  font-family: "Figtree";
  font-size: 20px;
  text-align: justify;
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

button {
  margin-top: 5%;
  color: white;
  font-size: 22px;
  font-family: "Figtree";
  background-color: #ac0700;
  padding: 10px 50px;
  text-align: center;
  font-weight: bold;
  border: 2px solid #ac0700;
  border-radius: 40px;
  transition: 0.4s ease;
}
button:hover {
  background-color: #fff;
  border-color: #fff;
  color: #313c1c;
}

@media screen and (max-width: 1024px) {
  .container {
    padding: 0 8%;
  }

  .logo {
    height: 90px;
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


  .header-text h1 {
    font-size: 70px;
  }

  .header-text h2 {
    font-size: 80px;
  }

  .header-text p {
    font-size: 18px;
  }
}

@media screen and (max-width: 768px) {
  .header-container {
    flex-direction: flex;
    justify-content: space-between;
    align-items: center;
    margin-left: 0;
  }

  .logo {
    margin: 0;
    margin-bottom: 13vh!important;
    height: 10vh;
  }

  .navbartoggle {
    display: none;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    top: -18vh;
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

  .header-text {
    flex-direction: column;
    text-align: center;
  }

  .header-text h1 {
    font-size: 60px;
    margin-bottom: 10px;
  }

  .header-text h2 {
    font-size: 59px;
  }

  .header-text p {
    font-size: 20px;
    margin-top: 15px;
    text-align: center;
  }

  button {
    font-size: 18px;
    padding: 10px 30px;
  }
}

@media screen and (max-width: 425px) {
  .logo {
    height: 50px;
  }

  .header-text h1 {
    font-size: 50px;
  }

  .header-text h2 {
    font-size: 40px;
  }

  .header-text p {
    font-size: 20px;
  }

  button {
    font-size: 16px;
    padding: 8px 20px;
  }
}

@media screen and (max-width: 375px) {
  .header-container {
    flex-direction: column;
  }

  .logo {
    height: 60px;
  }

  .header-text h1 {
    font-size: 40px;
  }

  .header-text h2 {
    font-size: 30px;
  }

  .header-text p {
    font-size: 10px;
  }

  button {
    font-size: 14px;
    padding: 6px 15px;
  }
}

@media screen and (max-width: 320px) {
  .header-container {
    padding: 0 2%;
  }

  .logo {
    height: 60px;
  }

  .header-text h1 {
    font-size: 30px;
  }

  .header-text h2 {
    font-size: 45px;
  }

  .header-text p {
    font-size: 15px;
  }

  button {
    margin-top: 6vh;
    font-size: 12px;
    padding: 10px 20px;
  }
}
</style>
