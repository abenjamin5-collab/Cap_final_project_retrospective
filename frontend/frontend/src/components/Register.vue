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
        email: this.email,
        password: this.password,
        role: this.role
      })
      .then(response => {
        // Optionally log in the user after registration
        this.loginAfterRegister();
      })
      .catch(error => {
        console.error('Error registering:', error);
      });
    },
    loginAfterRegister() {
      axios.post('/api/auth/login/', {
        username: this.username,
        password: this.password
      })
      .then(response => {
        localStorage.setItem('access_token', response.data.access);
        localStorage.setItem('refresh_token', response.data.refresh);
        // Redirect to the dashboard or another page
        this.$router.push('/dashboard');
      })
      .catch(error => {
        console.error('Error logging in:', error);
      });
    }
  }
};
</script>

<style scoped>
.register {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input, select {
  width: 100%;
  padding: 8px;
  margin-top: 2px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  display: inline-block;
  padding: 10px 15px;
  background: #009900;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #009900;
}
</style>