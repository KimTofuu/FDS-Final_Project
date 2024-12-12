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
          <li><a href="/MemberCoaches">Coaches</a></li>
          <li><a href="/MemberUpgrade" style="color: #ac0700">Upgrade</a></li>
        </ul>
      </nav>
      <button @click="showLogoutConfirm = true" class="logout-buttons">
        <img src="../assets/logout.png" alt="Logout" class="logout-img" />
        <span class="logout-text">Logout</span>
      </button>
    </aside>

    <div v-show="showLogoutConfirm">
      <div class="overlay" @click="showLogoutConfirm = false"></div>
      <transition
        name="fade"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
      >
        <div v-if="showLogoutConfirm" class="logout-confirm">
          <p>Are you sure you want to logout?</p>
          <div class="button-group">
            <button @click="logout">Yes</button>
            <button @click="showLogoutConfirm = false">No</button>
          </div>
        </div>
      </transition>
    </div>

    <main class="content">
      <div class="subscriptions">
        <div class="subscription-card">
          <h2>BASIC PLAN</h2>
          <ul>
            <li>Access to Gym Facilities</li>
            <li>Limited Hours Access</li>
            <li>Locker Access</li>
            <li>Fitness Orientation</li>
            <li>Self-Guided Workouts</li>
            <li>Priority Booking for Classes</li>
            <li>Exclusive Access to Online Resources</li>
          </ul>
          <div class="price">₱199</div>
          <button class="subscribe-btn">Subscribe</button>
        </div>

        <div class="subscription-card">
          <h2>ADVANCED PLAN</h2>
          <ul>
            <li>Full Access to Facilities</li>
            <li>Extended Hours Access</li>
            <li>Premium Locker Rooms</li>
            <li>Fitness Orientation</li>
            <li>Self-Guided Workouts</li>
            <li>Exclusive Perks</li>
            <li>Personal Training Discounts</li>
          </ul>
          <div class="price">₱349</div>
          <button class="subscribe-btn">Subscribe</button>
        </div>

        <div class="subscription-card">
          <h2>MASTER PLAN</h2>
          <ul>
            <li>Full Access to Facilities</li>
            <li>Extended Hours Access</li>
            <li>Premium Locker Rooms</li>
            <li>Fitness Orientation</li>
            <li>Self-Guided Workouts</li>
            <li>Exclusive Perks</li>
            <li>Personal Training Discounts</li>
          </ul>
          <div class="price">₱549</div>
          <button class="subscribe-btn">Subscribe</button>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showSidebar: true,
      showLogoutConfirm: false,
    };
  },
  methods: {
    // Toggle the sidebar
    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
    },

    // Logout functionality
    async logout() {
      this.showLogoutConfirm = false;
      try {
        const response = await apiClient.post("/Logout");
        console.log(response.data);
        if (response.data?.status?.remarks === "success") {
          this.$router.push("/MainLogin");
        } else {
          this.error = response.data.message || "Logout failed";
        }
      } catch (error) {
        console.error("Logout Error:", error);
        this.error = "An error occurred while logging out. Please try again.";
      }
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
  overflow: hidden;
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
  margin-left: 20%;
  padding: 15vh;
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

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
}

.logout-buttons {
  background-color: #ac0700;
  border: none;
  cursor: pointer;
  margin-top: 10vh !important;
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

.logout-buttons:hover {
  width: 15vh;
  padding: 5px 10px;
}

.logout-buttons:hover .logout-text {
  opacity: 1;
}

.logout-confirm {
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

.logout-confirm p {
  font-size: 1.5rem;
  margin-bottom: 5%;
}

.logout-confirm button {
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

.logout-confirm button:hover {
  background-color: #ac0700;
  color: #fff;
  transform: scale(1.05);
}

.subscriptions {
  display: flex;
  justify-content: space-around;
  gap: 5%;
  margin-top: 4%;
}

.subscription-card {
  background-color: #f8f8f8;
  border: 2px solid #ddd;
  border-radius: 20px;
  padding: 20px;
  text-align: center;
  width: 350px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
}

.subscription-card h2 {
  font-size: 1.5rem;
  color: #ac0700;
  margin-bottom: 15px;
}

.subscription-card ul {
  list-style: none;
  padding: 0;
  margin: 0;
  text-align: left;
}

.subscription-card ul li {
  list-style-type: disc;
  margin-bottom: 4%;
  margin-left: 10%;
  font-size: 1rem;
  color: #000000;
}

.price {
  font-size: 2rem;
  font-weight: bold;
  color: #000;
  margin: 10px;
}

.subscribe-btn {
  background-color: #ac0700;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}

.subscribe-btn:hover {
  background-color: #ffffff;
  color: #ac0700;
}

@media (max-width: 1024px) {
  :root {
    --content-max-width: 900px;
    --content-padding: 25px;
  }

  .content {
    display: block;
  }

  .subscription-card {
    width: 400px; 
    margin: 0 auto;
  }
}

@media (max-width: 768px) {
  :root {
    --content-max-width: 700px;
    --content-padding: 20px;
  }
  .content > * {
    margin-bottom: 5rem; 
    width: 100%; 
  }

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

  .sidebar .logo img {
    width: 60px;
    height: 70px;
    margin-bottom: 10px;
    position: relative;
    top: 40px;
    right: 30px;
    left: 0;
  }

  .subscription-card {
    width: 200px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
  }
}

@media (max-width: 425px) {
  :root {
    --content-max-width: 100%;
    --content-padding: 20px;
  }

  .content > * {
    display: block; 
    margin-bottom: 15px; 
    width: 100%; 
  }

  .sidebar {
    width: 100%; 
  }

  .sidebar .logo img {
    width: 50px;
    height: 55px;
    margin-bottom: 15px;
  }

  .content h1 {
    font-size: 1.8rem;
  }

  .subscription-card {
    width: 250px!important; /* Adjust card size */
    margin-left: -2vh;
  }
}

/* Styles for 375px and below */
@media (max-width: 375px) {
  :root {
    --content-padding: 15px;
  }

  .content > * {
    display: block;
    margin-bottom: 12px;
    width: 100%;
  }

  .sidebar .logo img {
    width: 45px;
    height: 50px;
    margin-bottom: 10px;
  }

  .content h1 {
    font-size: 1.6rem;
  }

  .subscription-card {
    width: 20 0px!important; /* Adjust card size */
    margin-left: -2vh;
  }
}

/* Styles for 320px and below */
@media (max-width: 320px) {
  :root {
    --content-padding: 10px;
  }

  .content > * {
    display: block;
    margin-bottom: 10px;
    width: 100%;
  }

  .sidebar .logo img {
    width: 40px;
    height: 45px;
    margin-bottom: 10px;
  }

  .content h1 {
    font-size: 1.4rem;
    margin-right: 0;
  }
}
</style>
