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
          <ul :class="{ visible: navbarVisible }">            <li><router-link to="/">HOME</router-link></li>
            <li><router-link to="/AboutUs">ABOUT US</router-link></li>
            <li><router-link to="/Services">SERVICES</router-link></li>
            <li><router-link to="/OurTeam">OUR TEAM</router-link></li>
            <li><router-link to="/Contacts">CONTACTS</router-link></li>
          </ul>
        </nav>
      </div>

      <div class="container">
        <h1 class="sub-title" style="color: white">Our Team</h1>
        <div class="work-list">
          <div class="work">
            <img src="../assets/coach1.png" />
            <div class="layer" style="color: white">
              <h3>Coach Bamboo</h3>
              <p>
                Strength Training Specialist – Focuses on building muscle and
                increasing overall strength
              </p>
            </div>
          </div>
          <div class="work" style="color: white">
            <img src="../assets/coach2.png" />
            <div class="layer">
              <h3>Coach Sarah</h3>
              <p>
                Flexibility and Mobility Specialist – Focuses on improving range
                of motion, reducing stiffness, and enhancing flexibility
              </p>
            </div>
          </div>
          <div class="work" style="color: white">
            <img src="../assets/coach3.jpg" />
            <div class="layer">
              <h3>Coach Apl</h3>
              <p>
                Powerlifting Coach - Trains individuals in the competitive lifts
                of squat, bench press, and deadlift
              </p>
            </div>
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
  background-image: url("./assets/background.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
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
  margin-bottom: -10vh;
  margin-top: 30px;
  margin-left: 10px;
}

.sub-title {
  font-size: 36px;
  text-align: center;
  margin: 20px 0 40px;
  color: white;
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

#ourteam {
  padding: 70px 0;
}

.work-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  grid-gap: 40px;
  margin-top: 50px;
}

.work {
  border-radius: 10px;
  position: relative;
  overflow: hidden;
}

.work img {
  width: 100%;
  border-radius: 10px;
  display: block;
  transition: transform 0.5s;
}

.layer {
  width: 100%;
  height: 0;
  background: linear-gradient(rgba(0, 0, 0, 0.6), #ac0700);
  border-radius: 10px;
  position: absolute;
  left: 0;
  bottom: 0;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 40px;
  text-align: center;
  font-size: 14px;
}

.layer h3 {
  font-weight: 500;
  margin-bottom: 20px;
}

.work:hover img {
  transform: scale(1.1);
}

.work:hover .layer {
  height: 100%;
}

@media (max-width: 1024px) {
  .container {
    padding: 0 8%;
  }

  .header-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-left: 0;
    margin-bottom: 20px;
  }

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
    top: 18vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 1.9);
    text-align: center;
    gap: 8vh;
    padding: 10px 0;
    display: none;
    z-index: 1000;
  }

  .navbar ul.visible {
    display: flex;
  }

  .navbar li {
    margin: 15px 0;
  }

  .navbar a {
    font-size: 15px;
  }

  .sub-title {
    font-size: 40px; 
    margin-bottom: 3vh;
    margin-top: -19vh;
    margin-left: 10vh;
  }

  .work-list {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
  }
}

@media (max-width: 768px) {
  .container {
    padding: 0 3%;
  }

  .header-container {
    flex-direction: column;
    text-align: center;
  }

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
    top: 18vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 1.9);
    text-align: center;
    gap: 8vh;
    padding: 10px 0;
    display: none;
    z-index: 1000;
  }

  .navbar ul.visible {
    display: flex;
  }

  .navbar li {
    margin: 10px 0;
  }

  .navbar a {
    font-size: 14px;
  }

  .sub-title {
    font-size: 24px; 
    margin-bottom: 28vh;
    margin-top: -19vh;
    margin-left: 5vh;
  }

  .work-list {
    grid-template-columns: repeat(2, 1fr) !important;
    margin-left: 8vh !important;
    margin-top: -23vh !important;
  }
}

@media (max-width: 425px) {
  .container {
    padding: 0 5%;
  }

  .logo {
    height: 50px !important;
  }

  .navbar ul {
    flex-direction: column;
    position: fixed;
    top: 18vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 1.9);
    text-align: center;
    gap: 8vh;
    padding: 10px 0;
    display: none;
    z-index: 1000;
  }

  .navbar ul.visible {
    display: flex;
  }
  .navbar a {
    font-size: 12px;
  }

  .work-list {
    grid-template-columns: 1fr !important;
    width: auto;
    margin: 0 auto;
    margin-top: -23vh;
    margin-left: 5vh;
    height: auto;
  }

  .sub-title {
    font-size: 20px; 
    margin-bottom: 28vh;
    margin-top: -19vh;
    margin-left: 5vh;
  }

  .layer {
    font-size: 12px;
    padding: 0 20px;
  }

  .layer h3 {
    font-size: 14px !important;
  }
}

@media (max-width: 375px) {
  .header-container {
    flex-direction: column;
    align-items: center;
    margin-top: 10px;
  }
  
  .logo {
    margin: 0;
    margin-top: 5vh !important;
    height: 10vh !important;
  }

  .navbartoggle {
    display: block;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    margin-top: 10vh;
    top: -19vh;
    left: 18vh;
  }

  .navbar ul {
    gap: 5px;
  }

  .navbar a {
    font-size: 12px;
    padding: 5px;
  }

  .sub-title {
    font-size: 20px; 
    margin-bottom: 28vh;
    margin-top: -15vh;
    margin-left: 7vh;
  }

  .work-list {
    grid-template-columns:1fr !important;
    width: 40vh;
    height: 60vh !important;
    gap: 10px;
    margin-top: -20vh;
    margin-left: 5vh!important;
  }


  .work img {
    border-radius: 5px;
  }

  .layer {
    font-size: 10px;
    padding: 0 10px;
  }

  .layer h3 {
    font-size: 14px;
  }
}

@media (max-width: 320px) {
  .container {
    padding: 0 2%;
  }

  .logo {
    height: 40px;
  }

  .navbar ul {
    gap: 5px;
  }

  .navbar a {
    font-size: 11px;
  }

  .work img {
    border-radius: 5px;
  }

  .layer {
    font-size: 9px;
    padding: 0 5px;
  }

  .layer h3 {
    font-size: 12px;
  }
}

</style>
