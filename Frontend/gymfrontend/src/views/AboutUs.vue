<template>
  <div id="header">
    <div class="container">
      <div class="header-container">
        <router-link to="/LandingPage">
          <img src="../assets/logo.png" alt="Logo" class="logo" />
        </router-link>
        <nav class="navbar">
          <ul id="sidemenu">
            <li><router-link to="/LandingPage">HOME</router-link></li>
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
            <p>
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
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

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
  padding: 10px 10%;
  display: flex;
  flex-direction: column;
}

.header-container {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  margin-top: 50px;
}

.logo {
  height: 100px;
  margin-right: 450px;
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
  width: 80%;
  border-radius: 15px;
}

.about-col-2 {
  flex-basis: 60%;
}

.about-col-2 p {
  font-size: 20px;
  font-weight: 50;
  color: #fff;
  margin-top: 15px;
}

.sub-title {
  padding-top: 50px;
  font-size: 60px;
  font-weight: 600;
  color: #fff;
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
</style>
