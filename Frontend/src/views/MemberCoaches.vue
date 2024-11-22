<template>
  <div class="sidebar-layout">
    <button @click="toggleSidebar" class="sidebar-toggle">☰</button>

    <aside :class="['sidebar', { show: showSidebar }]">
      <div class="logo">
        <router-link to="/MemberDashboard">
          <img src="@/assets/logononame.png" alt="Logo" class="logo-img" />
        </router-link>
      </div>
      <nav>
        <ul>
          <li><a href="/MemberDashboard">Overview</a></li>
          <li><a href="/MemberProfile">Profile</a></li>
          <li><a href="/MemberCoaches" style="color: #ac0700">Coaches</a></li>
          <li><a href="/MemberUpgrade">Upgrade</a></li>
        </ul>
      </nav>
      <button @click="showLogoutConfirm = true" class="logout-button">
        <img src="../assets/logout.png" alt="Logout" class="logout-img" />
        <span class="logout-text">Logout</span>
      </button>
    </aside>

    <transition
      name="fade"
      @before-enter="beforeEnter"
      @enter="enter"
      @leave="leave"
    >
      <div v-if="showLogoutConfirm" class="logout-confirmation">
        <p>Are you sure you want to logout?</p>
        <div class="button-group">
          <button @click="logout">Yes</button>
          <button @click="showLogoutConfirm = false">No</button>
        </div>
      </div>
    </transition>

    <div class="coach-container">
      <div class="coach-card">
        <img
          src="../assets/coach1.png"
          alt="Coach Bamboo"
          class="coach-photo"
        />
        <h3>Coach Bamboo</h3>
        <p>
          Strength Training Specialist<br />
          Focuses on building muscle and increasing overall strength
        </p>
        <br />
        <button class="enroll-btn">ENROLL</button>
      </div>

      <div class="coach-card">
        <img src="../assets/coach2.png" alt="Coach Sarah" class="coach-photo" />
        <h3>Coach Sarah</h3>
        <p>
          Flexibility and Mobility Specialist<br />
          Focuses on improving range of motion, reducing stiffness, and
          enhancing flexibility
        </p>
        <button class="enroll-btn">ENROLL</button>
      </div>

      <div class="coach-card">
        <img src="../assets/coach3.jpg" alt="Coach APL" class="coach-photo" />
        <h3>Coach APL</h3>
        <p>
          Powerlifting Coach<br />
          Trains individuals in the competitive lifts of squat, bench press, and
          deadlift
        </p>
        <button class="enroll-btn">ENROLL</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showSidebar: false,
      showLogoutConfirm: false,
    };
  },
  methods: {
    // Toggle the sidebar
    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
    },

    // Logout functionality
    logout() {
      this.showLogoutConfirm = false;
      console.log("Logging out...");
    },

    // Transition effects for animations
    beforeEnter(el) {
      el.style.opacity = 0; // Initial opacity before the element enters
    },
    enter(el, done) {
      el.offsetHeight; // Trigger reflow to ensure transition works
      el.style.transition = "opacity 0.3s ease-in-out";
      el.style.opacity = 1;
      done(); // Call the done function when transition is finished
    },
    leave(el, done) {
      el.style.transition = "opacity 0.3s ease-in-out";
      el.style.opacity = 0;
      done(); // Call the done function when transition is finished
    },
  },
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
}
html,
body {
  height: 100%;
  font-family: "Figtree", sans-serif;
  background-color: #fff;
}

.sidebar-layout {
  display: flex;
  height: 100vh;
}

.sidebar {
  width: 250px;
  height: 100vh;
  background-color: #000;
  color: #fff;
  position: fixed;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 8%;
  transition: transform 0.3s ease;
}

.sidebar .logo img {
  width: 50px;
  height: 60px;
  margin-bottom: 20px;
}

.sidebar nav ul {
  list-style: none;
  width: 100%;
  padding: 0;
  text-align: center;
}

.sidebar nav ul li {
  margin: 30px 0;
}

.sidebar nav ul li a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s;
}

.sidebar a:hover {
  color: #ac0700;
}

.user-info {
  margin-top: auto;
  padding-bottom: 20px;
  text-align: center;
}

.user-info-box {
  background-color: #ac0700;
  color: #fff;
  padding: 10px 20px;
  border-radius: 20px;
  text-align: center;
}

.member-text {
  font-size: 0.8rem;
}

.content {
  margin-left: 250px;
  padding: 75px;
  flex: 1;
  transition: margin-left 0.3s ease;
}

.content h1 {
  color: black;
}

.sidebar-toggle {
  display: none;
  position: absolute;
  top: 20px;
  left: 20px;
  background-color: #333;
  color: #fff;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  z-index: 20;
}

.logout-button {
  background-color: #ac0700;
  border: none;
  cursor: pointer;
  margin-top: 25vh;
  padding: 5px 10px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  gap: 5px;
  width: 50px;
  overflow: hidden;
  transition: width 0.3s ease, padding 0.3s ease;
}

.logout-img {
  width: 30px;
  height: 30px;
  transition: transform 0.3s ease;
}

.logout-img:hover {
  transform: scale(1.1);
}

.logout-text {
  font-size: 1rem;
  font-weight: bold;
  color: #ffffff;
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
  white-space: nowrap;
}

.logout-button:hover {
  width: 15vh;
  padding: 5px 10px;
}

.logout-button:hover .logout-text {
  opacity: 1;
}

.logout-confirmation {
  position: fixed;
  top: 50%;
  left: 60%;
  transform: translate(-50%, -50%);
  background-color: rgba(0, 0, 0, 0.9);
  color: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  width: 27%;
  height: 20%;
  opacity: 0;
  pointer-events: auto;
  transition: opacity 0.3s ease-in-out;
}

.logout-confirmation p {
  font-size: 1.5rem;
  margin-bottom: 5%;
}

.logout-confirmation button {
  padding: 0px 10px;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  font-size: 1.2rem;
  width: 10vh;
  height: 5vh;
  background-color: #fff;
  color: #ffffff(255, 255, 255);
  transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
}

.logout-confirmation button:hover {
  background-color: #ac0700;
  color: #fff;
  transform: scale(1.05);
}

.coach-container {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  margin-left: 25%;
}

.coach-card {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 20px;
  width: 300px;
  height: 60%;
  text-align: center;
  padding: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
  margin: 20px;
  margin-top: 12%;
}

.coach-card h3 {
  font-size: 1.5rem;
  color: #000000;
  margin-bottom: 10px;
}

.coach-card p {
  font-size: 1rem;
  line-height: 1.5;
  color: #000000;
  margin-bottom: 15px;
  text-align: center;
}

.coach-photo {
  width: 100%;
  height: auto;
  border-radius: 10px;
  margin-bottom: 15px;
}

.enroll-btn {
  background-color: #ac0700;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.enroll-btn:hover {
  background-color: #fff;
  color: #ac0700;
  border: 1px solid #ac0700;
}

@media (max-width: 768px) {
  .sidebar-toggle {
    display: block;
  }

  .sidebar {
    transform: translateX(-100%);
    min-height: 100vh;
    width: 250px;
  }

  .sidebar.show {
    transform: translateX(0);
  }

  .content {
    margin-left: 0;
    padding: 20px;
  }

  .sidebar .logo img {
    width: 60px;
    height: 70px;
    margin-bottom: 10px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }
}

@media (max-width: 425px) {
  .sidebar {
    width: 100%;
  }

  .sidebar .logo img {
    width: 50px;
    height: 55px;
    margin-bottom: 15px;
  }

  .user-info-box {
    padding: 8px 15px;
    font-size: 0.9rem;
  }

  .sidebar nav ul li {
    margin: 25px 0;
  }

  .content {
    padding: 20px;
  }

  .content h1 {
    font-size: 1.8rem;
  }
}

@media (max-width: 375px) {
  .sidebar {
    width: 100%;
  }

  .sidebar .logo img {
    width: 45px;
    height: 50px;
    margin-bottom: 10px;
  }

  .user-info-box {
    padding: 6px 12px;
    font-size: 0.85rem;
  }

  .sidebar nav ul li {
    margin: 20px 0;
  }

  .content {
    padding: 15px;
  }

  .content h1 {
    font-size: 1.6rem;
  }
}

@media (max-width: 320px) {
  .sidebar {
    width: 100%;
  }

  .sidebar .logo img {
    width: 40px;
    height: 45px;
    margin-bottom: 10px;
  }

  .user-info-box {
    padding: 5px 10px;
    font-size: 0.8rem;
  }

  .sidebar nav ul li {
    margin: 18px 0;
  }

  .content {
    padding: 10px;
  }

  .content h1 {
    font-size: 1.4rem;
    margin-right: 0%;
  }
}
</style>
