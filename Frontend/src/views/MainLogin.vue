<template>
  <div id="bg">
    <header>
      <router-link to="/LandingPage">
        <img src="../assets/logo.png" alt="Logo" class="logo" />
      </router-link>
      <nav class="navbar">
        <ul>
          <li><router-link to="/LandingPage">HOME</router-link></li>
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

<style scoped>
* {
  margin: 0;
  padding: 0;
}

header {
  display: flex;
  align-items: center;
  padding: 40px;
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
  margin-left: 124px;
}
.navbar {
  display: flex;
  flex-grow: 2;
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
  padding-left: 15%;
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
    padding: 6px 10px;
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
    flex-direction: column;
    padding: 10px;
    text-align: center;
  }

  .logo {
    margin: 10px 0;
  }

  .navbar ul {
    flex-direction: column;
    align-items: center;
    gap: 5px;
  }

  .main {
    padding: 10px;
  }

  .form {
    padding: 15px;
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

@media (max-width: 480px) {
  .navbar a {
    font-size: 12px;
    padding: 5px 8px;
  }

  .form h2 {
    font-size: 16px;
  }

  .form button {
    font-size: 12px;
    height: 35px;
    width: 85%;
  }

  .return-button a {
    font-size: 12px;
  }
}
</style>
