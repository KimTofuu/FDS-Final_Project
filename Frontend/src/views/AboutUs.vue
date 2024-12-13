<template>
  <div id="header">
    <div class="container">
      <div class="header-container">
        <router-link to="/">
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
        <div class="row">
          <div class="about-col-1">
            <img src="@/assets/aboutus-pic.png" alt="About Us" />
          </div>
          <div class="about-col-2">
            <h1 class="sub-title">About Us</h1>
            <div class="justified-text">
              Olympus Gym Club is a premium fitness center that aims to offer a
              holistic approach to health and wellness. Inspired by the strength
              and endurance of the gods from ancient mythology, Olympus is
              designed to help members reach their peak physical and mental
              fitness. The gym features state-of-the-art equipment, a wide range
              of group classes, and personal training sessions tailored to
              individual goals.
              <br />
              <br />
              Olympus Gym Club promotes a community-driven environment where
              individuals of all fitness levels are welcome, fostering
              camaraderie and support among its members. Whether you're a
              seasoned athlete or new to fitness, Olympus provides the tools and
              inspiration to push your limits and achieve your personal best.
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

<style>
@font-face {
  font-family: "Grifter";
  src: url("grifterbold.otf");
}

* {
  margin: 0;
  padding: 0;
  font-family: "Figtree";
  box-sizing: border-box;
  overflow: hidden;
}

html {
  scroll-behavior: smooth;
}

body {
  background: #080808;
  color: #fff;
    overflow: hidden;
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
  justify-content: space-between;
  margin-bottom: -10vh;
  margin-top: 30px;
  margin-left: 10px;
}

.logo {
  height: 100px;
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

.row {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.about-col-1 {
  flex-basis: 35%;
  padding-top: 40px;
}

.about-col-1 img {
  width: 92%;
  border-radius: 15px;
}

.about-col-2 {
  flex-basis: 60%;
}

.justified-text {
  text-align: justify;
  font-size: 20px;
  color: #fff;
  margin-top: 15px;
}

.sub-title {
  padding-top: 50px;
  font-size: 60px;
  font-weight: 600;
  color: #fff;
}

@media (max-width: 1024px) {
  .header-container {
    flex-direction: column;
    align-items: center;
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

  .navbar li {
    margin: 10px;
  }

  .sub-title {
    font-size: 50px;
    text-align: center;
  }

  .about-col-1,
  .about-col-2 {
    flex-basis: 100%;
    text-align: center;
  }

  .about-col-1 img {
    width: 70%;
  }

  .justified-text {
    font-size: 20px;
  }
}

@media (max-width: 768px) {
  .header-container {
    flex-direction: column;
    align-items: center;
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

  .navbar li {
    margin: 10px;
  }

  .sub-title {
    font-size: 20px;
    text-align: center;
  }

  .about-col-1,
  .about-col-2 {
    flex-basis: 100%;
    text-align: center;
  }

  .about-col-1 img {
    width: 65%;
    margin-top: -10vh;
  }

  .justified-text {
    font-size: 10px;
  }
}

@media (max-width: 425px) {
  .logo {
    height: 70px;
  }

  .navbar ul {
    gap: 5px;
  }

  .navbar li {
    margin: 5px;
  }

  .sub-title {
    font-size: 32px;
  }

  .about-col-1 img {
    width: 80%;
  }

  .justified-text {
    font-size: 10px;
  }
}

@media (max-width: 375px) {
  .header-container {
    padding: 0 10px;
  }

  .logo {
    height: 60px;
  }

  .navbar ul {
    gap: 4px;
  }

  .sub-title {
    font-size: 28px;
  }

  .about-col-1 img {
    width: 90%;
  }

  .justified-text {
    font-size: 15px;
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
    font-size: 15px;
  }

  .navbar a {
    font-size: 14px;
  }

  .about-col-1 img {
    width: 70%;
  }

  .justified-text {
    font-size: 10px;
  }
}
</style>
