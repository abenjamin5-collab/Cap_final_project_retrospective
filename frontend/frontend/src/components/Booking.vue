<template>
  <div class="booking-container">
    <h1>Book a Tennis Lesson</h1>
    <form @submit.prevent="submitBooking">
      <div class="form-group">
        <label for="coach">Select Coach:</label>
        <select v-model="booking.coach" id="coach" required>
          <option v-for="coach in coaches" :key="coach.id" :value="coach.id">
            {{ coach.name }}
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
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      booking: {
        coach: '',
        date: '',
        time: '',
      },
      coaches: [],
      message: '',
    };
  },
  created() {
    this.fetchCoaches();
  },
  methods: {
    fetchCoaches() {
      axios
        .get('/api/coaches')
        .then((response) => {
          this.coaches = response.data;
        })
        .catch((error) => {
          console.error('There was an error fetching the coaches:', error);
        });
    },
    submitBooking() {
      axios
        .post('/api/bookings', this.booking)
        .then((response) => {
          this.message = 'Booking successful!';
          this.booking = { coach: '', date: '', time: '' }; // Reset form
        })
        .catch((error) => {
          console.error('There was an error submitting the booking:', error);
          this.message = 'Failed to book lesson. Please try again.';
        });
    },
  },
};
</script>

<style scoped>
.booking-container {
  max-width: 500px;
  margin: 0 auto;
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
