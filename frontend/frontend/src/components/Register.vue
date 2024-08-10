<template>
  <div>
    <navbar></navbar>
    <h1>Register</h1>
    <form @submit.prevent="register">
      <input type="text" v-model="firstName" placeholder="First name" required>
      <input type="text" v-model="lastName" placeholder="Last name" required>
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
import { base_url } from "../../config/config";

export default {
  components: { Navbar },
  data() {
    return {
      firstName: '',
      lastName: '',
      password: '',
      email: '',
      selectedRole:'',
    };
  },
  methods: {
    register() {
      axios.post(`${base_url}/api/register/`, {
        firstName: this.firstName,
        lastName: this.lastName,
        email: this.email,
        password: this.password,
        role: this.selectedRole
      })
      .then((response) => {
          let data = response?.data?.data;
          localStorage.setItem("access_token", data.token);
          localStorage.setItem('user', JSON.stringify(data.user));
          this.$toast.success("Register Successful", {
            position: 'bottom',
          });
          // Redirect to the dashboard or another page
          this.$router.push("/booking");
        })
        .catch((error) => {
          this.$toast.error("Register Failed!", {
            position: 'bottom',
          });
        });
    },
   
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