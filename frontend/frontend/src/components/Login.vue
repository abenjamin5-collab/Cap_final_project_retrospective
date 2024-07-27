<template>
  <div>
    <navbar></navbar>
    <h1>Login</h1>
    <form @submit.prevent="login">
      <input type="text" v-model="username" placeholder="Username" required>
      <input type="password" v-model="password" placeholder="Password" required>
      <button type="submit">Login</button>
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
      password: ''
    };
  },
  methods: {
    login() {
      axios.post('/api/auth/login/', {
        username: this.username,
        password: this.password
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
