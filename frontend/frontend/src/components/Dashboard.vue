<template>
  <div class="dashboard-container">
    <h1>Dashboard</h1>
    <div v-if="role === 'admin'" class="admin-section">
      <h2>All Bookings</h2>
      <table class="bookings-table">
        <thead>
          <tr>
            <th>Student</th>
            <th>Coach</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in bookings" :key="booking.id">
            <td>{{ booking.student_name }}</td>
            <td>{{ booking.coach_name }}</td>
            <td>{{ booking.date }}</td>
            <td>{{ booking.time }}</td>
            <td><button @click="cancelBooking(booking.id)">Cancel</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else-if="role === 'coach'" class="coach-section">
      <h2>My Bookings</h2>
      <table class="bookings-table">
        <thead>
          <tr>
            <th>Student</th>
            <th>Date</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in myBookings" :key="booking.id">
            <td>{{ booking.student_name }}</td>
            <td>{{ booking.date }}</td>
            <td>{{ booking.time }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else-if="role === 'student'" class="student-section">
      <h2>My Bookings</h2>
      <table class="bookings-table">
        <thead>
          <tr>
            <th>Coach</th>
            <th>Date</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in myBookings" :key="booking.id">
            <td>{{ booking.coach_name }}</td>
            <td>{{ booking.date }}</td>
            <td>{{ booking.time }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      bookings: [],
      myBookings: [],
      role: '', // 'admin', 'coach', or 'student'
    };
  },
  created() {
    this.fetchUserRole();
    this.fetchBookings();
  },
  methods: {
    fetchUserRole() {
      // Fetch the user role from the API or use a prop
      axios
        .get('/api/user_role')
        .then((response) => {
          this.role = response.data.role;
          this.fetchMyBookings();
        })
        .catch((error) => {
          console.error('Error fetching user role:', error);
        });
    },
    fetchBookings() {
      if (this.role === 'admin') {
        axios
          .get('/api/bookings')
          .then((response) => {
            this.bookings = response.data;
          })
          .catch((error) => {
            console.error('Error fetching bookings:', error);
          });
      }
    },
    fetchMyBookings() {
      if (this.role === 'coach' || this.role === 'student') {
        axios
          .get(`/api/my_bookings`)
          .then((response) => {
            this.myBookings = response.data;
          })
          .catch((error) => {
            console.error('Error fetching my bookings:', error);
          });
      }
    },
    cancelBooking(bookingId) {
      axios
        .delete(`/api/bookings/${bookingId}`)
        .then(() => {
          this.fetchBookings();
        })
        .catch((error) => {
          console.error('Error canceling booking:', error);
        });
    },
  },
};
</script>

<style scoped>
.dashboard-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.bookings-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.bookings-table th,
.bookings-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

.bookings-table th {
  background-color: #e9e9e9;
}

button {
  padding: 5px 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
</style>
