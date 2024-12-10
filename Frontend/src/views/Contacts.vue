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
        <div class="row">
          <div class="contact-left">
            <h1 class="sub-title" style="color: white">Contact Us</h1>
            <p style="color: white">
              <font-awesome-icon icon="paper-plane" style="color: white" />
              olympusgymclub@gmail.com
            </p>
            <p style="color: white">
              <font-awesome-icon icon="phone" style="color: white" />
              09123456789
            </p>
            <div class="social-icons">
              <a
                href="https://web.facebook.com"
                target="_blank"
                rel="noopener noreferrer"
              >
                <font-awesome-icon
                  :icon="['fab', 'square-facebook']"
                  style="color: white"
                />
              </a>
              <a href="https://x.com" target="_blank" rel="noopener noreferrer">
                <font-awesome-icon
                  :icon="['fab', 'square-twitter']"
                  style="color: white"
                />
              </a>
              <a
                href="https://www.instagram.com"
                target="_blank"
                rel="noopener noreferrer"
              >
                <font-awesome-icon
                  :icon="['fab', 'square-instagram']"
                  style="color: white"
                />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright" style="color: white">
      <p>Copyright © 2024; Designed by <span> TeamBa+ </span></p>
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

#contact {
  padding: 60px 0 0px;
}

.contact-left {
  flex-basis: 35%;
}

.contact-left p {
  margin-top: 35px;
}

.contact-left p i {
  color: #ac0700;
  margin-right: 65px;
  font-size: 25px;
}

.social-icons {
  margin-top: 30px;
}

.social-icons a {
  text-decoration: none;
  font-size: 35px;
  margin-right: 15px;
  color: #ababab;
  display: inline-block;
  transition: transform(0.5s);
}

.social-icons a:hover {
  color: #ac0700;
  transform: translateY(-5px);
}

.btn {
  display: block;
  margin: 50px;
  width: fit-content;
  border: 1px solid #ac0700;
  padding: 14px 50px;
  border-radius: 6px;
  text-decoration: none;
  color: white;
  transition: background 0.5s;
}

.btn:hover {
  background: #ac0700;
}

.btn.btn2 {
  display: inline-block;
  background: #ac0700;
}

.copyright {
  width: 100%;
  text-align: center;
  padding: 25px 0;
  background: #262626;
  font-weight: 300;
  position: fixed;
  bottom: 0;
  left: 0;
}
</style>
