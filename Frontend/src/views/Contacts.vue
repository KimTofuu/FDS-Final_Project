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
        <div class="contact">
          <div class="contact-left">
            <h1 class="sub-title" style="color: white">Contact Us</h1>
            <p style="color: white" class="contact-text">
              <font-awesome-icon icon="paper-plane" class="contact-icon" />
              olympusgymclub@gmail.com
            </p>
            <p style="color: white" class="contact-text">
              <font-awesome-icon icon="phone" class="contact-icon" />
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

.contact-icon {
  color: white;
  font-size: 18px;
  margin-right: 8px;
  vertical-align: middle;
}

.contact-text {
  color: white;
  font-size: 2.5vh;
  margin-left: 5px;
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
  flex-basis: 55%;
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
@media (max-width: 1024px) {
  .container {
    padding: 0 8%;
  }

  .header-container {
    flex-direction: column;
    align-items: center;
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
    top: 14vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 1vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .navbar a {
    font-size: 14px;
  }

  .social-icons a {
    font-size: 5vh;
  }

  .contact-left {
    text-align: left;
    padding: 0 8%;
  }

  .contact-left h1.sub-title {
    font-size: 3.5rem;
    margin-bottom: 20px;
    margin-right: 50vh;
  }

  .contact-left p i {
    font-size: 20px;
    padding-left: 2vh !important;
  }

  .contact-icon {
    font-size: 3vh;
  }

  .contact-text {
    font-size: 2.9vh; /* Slightly smaller for tablets */
  }
}

@media (max-width: 768px) {
  .container {
    padding: 0 5%;
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
    top: 14vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 1vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .contact-left {
    text-align: left;
    padding: 0 8%;
  }

  .contact-left h1.sub-title {
    font-size: 2.9rem;
    margin-bottom: 20px;
    margin-right: 45vh;
  }

  .contact-left p i {
    font-size: 15px !important;
  }

  .contact-icon {
    font-size: 2.5vh;
  }

  .contact-text {
    font-size: 1.7vh;
  }

  .copyright {
    padding: 8px 0;
    font-size: 12px;
    text-align: center;
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
    top: 14vh;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 1vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }
  .contact-left {
    text-align: left;
    padding: 0 5%;
  }

  .contact-left h1.sub-title {
    font-size: 3.3rem;
    margin-bottom: 20px;
  }

  .contact-left p {
    font-size: 12px;
    line-height: 1.5;
    margin-bottom: 8px;
  }

  .social-icons {
    text-align: center;
    margin-top: 10px;
  }

  .social-icons a {
    font-size: 20px;
    margin: 0 10px;
  }

  .btn {
    padding: 8px 20px;
    font-size: 14px;
  }

  .copyright {
    padding: 8px 0;
    font-size: 12px;
    text-align: center;
  }

  .contact-icon {
    font-size: 2.5vh;
  }
}

@media (max-width: 375px) {
  .header-container {
    flex-direction: column;
    align-items: center;
    margin-top: 10px;
    text-align: center;
  }

  .logo {
    height: 80px;
    margin-bottom: 90px;
  }

  .navbartoggle {
    width: 30px;
    height: 30px;
    margin: 0 auto;
    position: relative;
    top: 0;
  }

  .navbar ul {
    flex-direction: column;
    gap: 10px;
    padding: 20px;
    position: fixed;
    top: 50px;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.9);
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .navbar a {
    font-size: 14px;
    padding: 10px;
  }

  #contact {
    padding: 40px 20px;
    text-align: center;
  }

  .contact-left p {
    margin-top: 15px;
    font-size: 14px;
    line-height: 1.5;
  }

  .contact-icon {
    font-size: 2vh;
  }

  .contact-text {
    font-size: 1vh;
  }

  .social-icons a {
    font-size: 20px;
    margin: 5px;
  }

  .btn {
    padding: 10px 25px;
    font-size: 14px;
  }

  .copyright {
    padding: 8px 0;
    font-size: 12px;
    text-align: center;
  }
}

@media (max-width: 320px) {
  .logo {
    margin: 0;
    margin-top: 5vh;
    margin-bottom: 1vh !important;
    height: 10vh;
  }

  .navbartoggle {
    display: block;
    width: 6vh;
    height: 6vh;
    margin: 0vh;
    position: relative;
    margin-top: 10vh;
    top: -20vh;
    left: 18vh;
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
    gap: 1vh;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .navbar a {
    font-size: 12px;
  }

  .contact-text {
    font-size: 1.7vh !important;
  }

  .contact-left h1.sub-title {
    font-size: 2.8rem;
    margin-bottom: 20px;
  }

  .contact-left p {
    font-size: 11px;
    margin-top: 10px;
  }

  .social-icons a {
    font-size: 18px;
    margin: 5px;
  }

  .copyright {
    font-size: 10px;
    text-align: center;
    padding: 6px 0;
  }
}
</style>
