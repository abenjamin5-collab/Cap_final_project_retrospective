<template>
  <header>
    <div class="container">
      <h1>Tennis Lesson Website</h1>
      <nav>
        <ul>
          <li><RouterLink to="/">Home</RouterLink></li>
          <li v-if="!isLoggedIn"><RouterLink to="/login">Login</RouterLink></li>
          <li v-if="!isLoggedIn"><RouterLink to="/register">Register</RouterLink></li>
          <li v-if="isStudent"><RouterLink to="/view/coaches">Dashboard</RouterLink></li>
          <li v-if="isStudent"><RouterLink to="/booking">Booking</RouterLink></li>
          <li v-if="isCoach"><RouterLink to="/coach/dashboard">Dashboard</RouterLink></li>
          <li v-if="isCoach"><RouterLink to="/lesson-management">Lesson Management</RouterLink></li>
          <li v-if="isLoggedIn"><RouterLink @click="logout" to="#">Logout</RouterLink></li>
        </ul>
      </nav>
      <div class="hamburger-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
          <path
            d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"
          />
        </svg>
      </div>
    </div>
    <ul class="hidden" id="vert-menu">
      <li><RouterLink to="/">Home</RouterLink></li>
      <li><RouterLink to="/login">Login</RouterLink></li>
      <li><RouterLink to="/register">Register</RouterLink></li>
    </ul>
  </header>
</template>

<script>
export default {
  computed: {
    isLoggedIn() {
      const user = JSON.parse(localStorage.getItem('user'));
      return !!user;
    },
    isStudent() {
      const user = JSON.parse(localStorage.getItem('user'));
      return user && user.role === 'student';
    },
    isCoach() {
      const user = JSON.parse(localStorage.getItem('user'));
      return user && user.role === 'coach';
    },
  },
  methods: {
    logout() {
      localStorage.removeItem('user');
      localStorage.removeItem('access_token');
      localStorage.clear();
      this.$router.push("/login");
      
    },
  },
};
</script>

<style scoped>
</style>
