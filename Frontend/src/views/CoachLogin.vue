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
          <li><router-link to="/">HOME</router-link></li>
          <li><router-link to="/AboutUs">ABOUT US</router-link></li>
          <li><router-link to="/Services">SERVICES</router-link></li>
          <li><router-link to="/OurTeam">OUR TEAM</router-link></li>
          <li><router-link to="/Contacts">CONTACTS</router-link></li>
        </ul>
      </nav>
    </header>

    <div class="main">
      <div class="content">
        <div class="form">
          <h2><b>COACH LOGIN</b></h2>
          <form @submit.prevent="login">
            <input
              type="text"
              placeholder="Username"
              id="username"
              v-model="Username"
            />
            <input
              type="password"
              placeholder="Password"
              id="password"
              v-model="Password"
            />
            <button type="submit"><h3>LOGIN</h3></button>
            <div v-if="error" style="color: red">{{ error }}</div>
            <div class="return-button">
              <router-link to="/MainLogin"> < RETURN </router-link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "@/api/axios";

export default {
  data() {
    return {
      navbarVisible: false,
      Username: "",
      Password: "",
      error: "",
    };
  },
  methods: {
    toggleNavbar() {
      this.navbarVisible = !this.navbarVisible;
    },
    closeNavbar() {
      this.navbarVisible = false;
    },
    async login() {
      const loginData = {
        Username: this.Username,
        Password: this.Password,
      };

      try {
        const response = await apiClient.post("/Login/Coach", loginData);
        if (response.data?.status?.remarks === "success") {
          this.$router.push("/CoachClient");
        } else {
          console.log(response.data);
          this.error = response.data.message || "Login failed";
        }
      } catch (error) {
        console.error("Login Error:", error);
        this.error = "An error occurred while logging in. Please try again.";
      }
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

.form input {
  width: 100%;
  height: 45px;
  background: transparent;
  border-bottom: 1px solid #ac0700;
  font-size: 15px;
  color: #ffffff;
  letter-spacing: 1px;
  margin-top: 20px;
}

::placeholder {
  opacity: 0.5;
  padding-left: 5%;
  color: #fff;
}

.form button {
  width: 40%;
  height: 50px;
  background-color: #ac0700;
  border: none;
  border-radius: 40px;
  color: #fff;
  cursor: pointer;
  font-size: 22px;
  padding: 10px 30px;
  transition: 0.4s ease;
  margin-top: 20px;
  margin-bottom: 10px;
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
