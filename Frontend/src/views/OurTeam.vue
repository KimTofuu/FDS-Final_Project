<template>
  <div id="header">
    <div class="container">
      <div class="header-container">
        <router-link to="/LandingPage">
          <img src="../assets/logo.png" alt="Logo" class="logo" />
        </router-link>
        <nav class="navbar">
          <ul id="sidemenu">
            <li><router-link to="/">HOME</router-link></li>
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
  margin-bottom: 10px;
  margin-top: 40px;
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
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
</style>
