<template>
  <div>
    <navbar></navbar>
    <h1>Register</h1>
    <form @submit.prevent="register">
      <input type="text" v-model="username" placeholder="Username" required>
      <input type="password" v-model="password" placeholder="Password" required>
      <input type="email" v-model="email" placeholder="Email" required>
        <select v-model="selectedRole" id="role" required>
    <option disabled value="">Select a role</option>
    <option value="student">Student</option>
    <option value="coach">Coach</option>
</select>
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Navbar from './Navbar.vue';

export default {
  components: { Navbar },
  data() {
    return {
      username: '',
      password: '',
      email: '',
      selectedRole:'',
    };
  },
  methods: {
    register() {
      axios.post('/api/auth/register/', {
        username: this.username,
        password: this.password,
        email: this.email
      })
      .then(response => {
        // Handle success
      })
      .catch(error => {
        // Handle error
      });
    }
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>
