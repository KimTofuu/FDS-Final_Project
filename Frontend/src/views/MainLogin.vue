<template>
  <div id="bg">
    <header>
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
          <li><router-link to="/" @click="closeNavbar">HOME</router-link></li>
          <li><router-link to="/AboutUs" @click="closeNavbar">ABOUT US</router-link></li>
          <li><router-link to="/Services" @click="closeNavbar">SERVICES</router-link></li>
          <li><router-link to="/OurTeam" @click="closeNavbar">OUR TEAM</router-link></li>
          <li><router-link to="/Contacts" @click="closeNavbar">CONTACTS</router-link></li>
        </ul>
      </nav>
    </header>

    <div class="main">
      <div class="content">
        <div class="form">
          <h2><b>GET YOUR ACCESS!</b></h2>
          <router-link to="/memberlogin">
            <button><h3>MEMBER</h3></button>
          </router-link>
          <router-link to="/adminlogin">
            <button><h3>ADMIN</h3></button>
          </router-link>
          <router-link to="/coachlogin">
            <button><h3>COACH</h3></button>
          </router-link>

          <div class="return-button">
            <router-link to="/"> < RETURN </router-link>
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
      this.navbarVisible = !this.navbarVisible; ed
    },
    closeNavbar() {
      this.navbarVisible = false; 
    },
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
}

header {
  display: flex;
  align-items: center;
  padding: 30px;
  position: fixed;
  width: 100%;
  z-index: 1000;
}

#bg {
  background-image: url("./background.png");
  background-size: cover;
  height: 100vh;
  background-repeat: no-repeat;
  background-position: center;
}

.logo {
  height: 100px;
  margin-right: 300px;
  margin-left: 134px;
}

.navbar {
  display: flex;
  flex-grow: 2;
}

.navbar ul {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: 10px;
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
  margin-bottom: 12vh;
}

.navbar a {
  text-decoration: none;
  color: #ffffff;
  font-size: 16px;
  transition: color 0.3s;
}

.navbar a:hover {
  color: #ac0700;
}

.main {
  width: 100%;
  background-position: center;
  background-size: cover;
  height: calc(100vh - 10px);
  display: flex;
  justify-content: left;
  padding-left: 23%;
  align-items: center;
  position: relative;
}

.form {
  width: 350px;
  padding: 10px;
  border-radius: 30px;
  border: 3px solid #fff;
  text-align: center;
}

.form h2 {
  color: #ffffff;
  font-size: 30px;
  margin: 2px;
  padding: 8px;
}

.form button {
  width: 70%;
  height: 50px;
  background-color: #ac0700;
  border: none;
  border-radius: 40px;
  color: #ffffff;
  cursor: pointer;
  font-size: 22px;
  padding: 10px 20px;
  transition: 0.4s ease;
  margin-bottom: 20px;
}

.form button:hover {
  background-color: #fff;
  color: #313c1c;
}

.return-button {
  position: absolute;
  top: 80%;
  left: 18%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.return-button a {
  text-decoration: none;
  color: #fff;
  font-size: 18px;
}

.return-button a:hover {
  color: #ac0700;
  transition: color 0.3s;
}

@media (max-width: 1024px) {
  .logo {
    height: 60px;
  }

  .navbar ul {
    gap: 10px;
  }

  .navbar a {
    font-size: 14px;
    padding: 0vh;
  }

  .form h2 {
    font-size: 20px;
  }

  .form button {
    font-size: 16px;
    height: 45px;
  }
}

@media (max-width: 768px) {
  header {
    flex-direction: row;
    justify-content: space-between;
    padding: 10px;
    text-align: center;
  }

  .logo {
    margin: 0;
    height: 60px;
  }

  .navbartoggle {
    display: block;
    max-width: 6vh;
    max-height: 6vh;
    margin-left: 20px;
  }

  .navbar ul {
    flex-direction: column;
    position: absolute;
    top: 60px;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    gap: 15px;
    padding: 10px 0;
    display: none;
  }

  .navbar ul.visible {
    display: flex;
  }

  .main {
    padding: 10px;
    padding-left: 5%;
  }

  .form {
    width: 75%; 
    padding: 25px;
    margin-left: 5vh!important; 
  }

  .form h2 {
    font-size: 18px; 
  }

  .form button {
    font-size: 14px; 
    height: 40px; 
  }

  .return-button a {
    font-size: 14px; 
  }
}


@media (max-width: 425px) {
  .form {
    width: 100%; 
    padding: 20px; 
    border-radius: 15px; 
  }

  .form h2 {
    font-size: 16px; 
    margin-bottom: 10px; 
  }

  .form button {
    font-size: 12px; 
    height: 35px; 
    width: 100%; 
    margin-bottom: 10px;
  }

  .return-button a {
    font-size: 12px; 
  }
}

@media (max-width: 375px) {
  .form {
    width: 60%; 
    padding: 8px; 
  }

  .form h2 {
    font-size: 14px; 
  }

  .form button {
    font-size: 11px; 
    height: 30px; 
    width: 85%; 
  }

  .return-button a {
    font-size: 11px; 
  }
}

@media (max-width: 320px) {
  .form {
    width: 100%; 
    padding: 60px;
  }

  .form h2 {
    font-size: 12px; 
  }

  .form button {
    font-size: 10px; 
    height: 30px;
    width: 110%; 
  }

  .return-button a {
    font-size: 10px; 
  }
}
</style>
