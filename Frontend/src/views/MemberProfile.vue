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
          <li><a href="/MemberProfile" style="color: #ac0700">Profile</a></li>
          <li><a href="/MemberCoaches">Coaches</a></li>
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

    <main class="profile-container">
      <div class="profile-content">
        <div class="profile-avatar">
          <img
            src="@/assets/coach1.png"
            alt="Profile Avatar"
            class="avatar-img"
          />
        </div>
        <div class="profile-details">
          <div class="detail-item">
            <label>Name:</label>
            <p>{{ profile.name }}</p>
          </div>
          <div class="detail-item">
            <label>Age:</label>
            <p>{{ profile.age }}</p>
          </div>
          <div class="detail-item">
            <label>Sex:</label>
            <p>{{ profile.sex }}</p>
          </div>
          <div class="detail-item">
            <label>Gender:</label>
            <p>{{ profile.gender }}</p>
          </div>
          <div class="detail-item">
            <label>Weight (kg):</label>
            <p>{{ profile.weight }}</p>
          </div>
          <div class="detail-item">
            <label>Height (cm):</label>
            <p>{{ profile.height }}</p>
          </div>
        </div>
      </div>
    </main>
    <main class="session-container">
      <div class="session-box set-session">
        <h2>Set Session</h2>
        <p>Configure your session details here.</p>
        <button>Set Session</button>
      </div>

      <div class="session-box set-alarm">
        <h2>Set Alarm</h2>
        <p>Set the time for your alarm.</p>
        <button>Set Alarm</button>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showSidebar: false,
      showLogoutConfirm: false,
      profile: {
        name: "John Doe",
        age: 25,
        sex: "Male",
        gender: "Male",
        weight: 70,
        height: 175,
      },
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

.session-container {
  margin-left: 10vh;
  margin-top: 19vh;
  padding: 20px;
  width: calc(100% - 110px); 
  box-sizing: border-box;
}

.session-box {
  width: 60%;
  margin: 20px auto;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  padding: 20px;
  margin: 20px 0;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.set-session {
  background-color: #e0f7fa;
}
.set-alarm {
  background-color: #e0f7fa;
}

.session-box h2 {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.session-box p {
  font-size: 1rem;
  color: #000000;
  margin-bottom: 15px;
}

.session-box button {
  background-color: #ac0700;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
  transition: background-color 0.3s ease;
  margin-left: 7vh;
  display: block;
}

.session-box button:hover {
  background-color: #ffffff;
  color: #ac0700;
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

.profile-container {
  margin-left: 20%; /* Adjust this to match sidebar width + some margin */
  margin-top: 5%;
  padding: 20px;
  width: calc(90% - 200px); /* Fill the remaining space */
  box-sizing: border-box; /* Ensure padding doesn't affect width */
}

.profile-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.profile-avatar .avatar-img {
  width: 100px;
  height: 100px;
  border-radius: 30px;
}

.profile-details {
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 60vh;
  height: 60vh;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.detail-item {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #ddd;
  padding: 10px 0;
}

.detail-item label {
  font-weight: bold;
  color: #333;
}

.detail-item p {
  margin: 0;
  color: #666;
  text-align: right;
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
    margin-left: 10% !important;
    padding-left: 20px;
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
