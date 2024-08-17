<template>
  <div>
    <navbar></navbar>
    <div class="coach-list">
      <h2>Our Coaches</h2>
      <div class="card-container">
        <div v-for="coach in coaches" :key="coach.id" class="card">
          <img
            src="https://via.placeholder.com/150"
            alt="Profile"
            class="profile-image"
          />
          <h3>{{ coach.first_name }} {{ coach.last_name }}</h3>
          <p>{{ coach.email }}</p>

          <router-link :to="`/booking?coachId=${coach.id}`">
            <button class="book-button">View Details</button>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { base_url } from "../../config/config";
import Navbar from "../components/Navbar.vue";

export default {
  components: { Navbar },
  data() {
    return {
      coaches: [],
    };
  },
  mounted() {
    this.fetchCoaches();
  },
  methods: {
    async fetchCoaches() {
      try {
        const response = await axios.get(`${base_url}/api/coaches`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        this.coaches = response.data.coaches;
      } catch (error) {
        console.error("Error fetching coaches:", error);
      }
    },
  },
};
</script>

<style scoped>
.coach-list {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 20px;
  width: calc(33.333% - 20px);
  box-sizing: border-box;
}

.card h3 {
  margin: 0 0 10px;
  font-size: 18px;
}

.card p {
  margin: 0;
  color: #666;
}
.book-button {
  margin-top: 10px;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.book-button:hover {
  background-color: #0056b3;
}
</style>
