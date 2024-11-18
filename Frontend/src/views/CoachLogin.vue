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
          <h2><b>COACH LOGIN</b></h2>
          <input type="text" placeholder="Username" />
          <input type="password" placeholder="Password" />
          <button><h3>LOGIN</h3></button>
          <div class="return-button">
            <router-link to="/MainLogin"> < RETURN </router-link>
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
}
</style>
