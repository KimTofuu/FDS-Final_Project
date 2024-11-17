<template>
  <div id="header">
    <div class="container">
      <div class="header-container">
        <router-link to="/LandingPage">
          <img src="../assets/logo.png" alt="Logo" class="logo" />
        </router-link>
        <nav class="navbar">
          <ul id="sidemenu">
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
  overflow: hidden;
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
  margin: 30px;
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

</style>