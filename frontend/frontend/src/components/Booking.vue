<template>
  <div>
    <navbar></navbar>
    <div class="booking-container">
      <h1>Book a Tennis Lesson</h1>
      <form @submit.prevent="submitBooking">
        <div class="form-group">
          <label for="coach">Select Coach:</label>
          <select v-model="booking.coach" id="coach" required>
            <option v-for="coach in coaches" :key="coach.id" :value="coach.id">
              {{ coach.first_name }} {{ coach.last_name }}
            </option>
          </select>
        </div>

        <div class="form-group">
          <label for="date">Select Date:</label>
          <input type="date" v-model="booking.date" id="date" required />
        </div>

        <div class="form-group">
          <label for="time">Select Time:</label>
          <input type="time" v-model="booking.time" id="time" required />
        </div>

        <button type="submit" class="btn btn-primary">Book Lesson</button>
      </form>

      <div v-if="message" class="message">{{ message }}</div>
    </div>
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
      booking: {
        coach: "",
        date: "",
        time: "",
      },
      coaches: [],
      message: "",
    };
  },
  mounted() {
    this.fetchCoaches();
    const coachId = this.$route.query.coachId;
    if (coachId) {
      this.booking.coach = coachId;
    }
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
        console.log(this.coaches);
      } catch (error) {
        console.error("Error fetching coaches:", error);
      }
    },
    submitBooking() {
      axios
        .post("/api/bookings", this.booking)
        .then((response) => {
          this.message = "Booking successful!";
          this.booking = { coach: "", date: "", time: "" }; // Reset form
        })
        .catch((error) => {
          console.error("There was an error submitting the booking:", error);
          this.message = "Failed to book lesson. Please try again.";
        });
    },
  },
};
</script>

<style scoped>
.booking-container {
  max-width: 500px;
  margin: 0 auto;
  margin-top:20px !important;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}

.btn {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background-color: #0056b3;
}

.message {
  margin-top: 20px;
  padding: 10px;
  border-radius: 5px;
  background-color: #dff0d8;
  color: #3c763d;
}
</style>
