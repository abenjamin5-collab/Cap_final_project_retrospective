<template>
  <div>
    <navbar></navbar>
    <h1>Login</h1>
    <form @submit.prevent="login">
      <input type="text" v-model="username" placeholder="Username" required />
      <input
        type="password"
        v-model="password"
        placeholder="Password"
        required
      />
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "./Navbar.vue";
import { base_url } from "../../config/config";
export default {
  components: { Navbar },
  data() {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    login() {
      axios
        .post(`${base_url}/api/auth/login/`, {
          username: this.username,
          password: this.password,
        })
        .then((response) => {
          localStorage.setItem("access_token", response.data.access);
          localStorage.setItem("refresh_token", response.data.refresh);
          this.$toast.success("Login Successful", {
            position: 'bottom',
          });
          // Redirect to the dashboard or another page
          this.$router.push("/booking");
        })
        .catch((error) => {
          this.$toast.error("Login Failed! Check Credentials", {
            position: 'bottom',
          });
        });
    },
  },
};
</script>

<style scoped>
.login {
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

input {
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
