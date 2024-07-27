<template>
  <div class="lesson-management-container">
    <h1>Lesson Management</h1>
    <div class="add-lesson-form">
      <h2>Add New Lesson</h2>
      <form @submit.prevent="addLesson">
        <div class="form-group">
          <label for="coach">Coach:</label>
          <select v-model="newLesson.coach_id" id="coach" required>
            <option v-for="coach in coaches" :key="coach.id" :value="coach.id">
              {{ coach.name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="date">Date:</label>
          <input type="date" v-model="newLesson.date" id="date" required />
        </div>
        <div class="form-group">
          <label for="time">Time:</label>
          <input type="time" v-model="newLesson.time" id="time" required />
        </div>
        <button type="submit" class="btn btn-primary">Add Lesson</button>
      </form>
    </div>

    <div class="lesson-list">
      <h2>Lesson List</h2>
      <table class="lessons-table">
        <thead>
          <tr>
            <th>Coach</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="lesson in lessons" :key="lesson.id">
            <td>{{ lesson.coach_name }}</td>
            <td>{{ lesson.date }}</td>
            <td>{{ lesson.time }}</td>
            <td>
              <button @click="editLesson(lesson)" class="btn btn-secondary">Edit</button>
              <button @click="deleteLesson(lesson.id)" class="btn btn-danger">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="editingLesson" class="edit-lesson-form">
      <h2>Edit Lesson</h2>
      <form @submit.prevent="updateLesson">
        <div class="form-group">
          <label for="edit-coach">Coach:</label>
          <select v-model="editingLesson.coach_id" id="edit-coach" required>
            <option v-for="coach in coaches" :key="coach.id" :value="coach.id">
              {{ coach.name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="edit-date">Date:</label>
          <input type="date" v-model="editingLesson.date" id="edit-date" required />
        </div>
        <div class="form-group">
          <label for="edit-time">Time:</label>
          <input type="time" v-model="editingLesson.time" id="edit-time" required />
        </div>
        <button type="submit" class="btn btn-primary">Update Lesson</button>
        <button @click="cancelEdit" class="btn btn-secondary">Cancel</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      lessons: [],
      coaches: [],
      newLesson: {
        coach_id: '',
        date: '',
        time: '',
      },
      editingLesson: null,
    };
  },
  created() {
    this.fetchLessons();
    this.fetchCoaches();
  },
  methods: {
    fetchLessons() {
      axios
        .get('/api/lessons')
        .then((response) => {
          this.lessons = response.data;
        })
        .catch((error) => {
          console.error('Error fetching lessons:', error);
        });
    },
    fetchCoaches() {
      axios
        .get('/api/coaches')
        .then((response) => {
          this.coaches = response.data;
        })
        .catch((error) => {
          console.error('Error fetching coaches:', error);
        });
    },
    addLesson() {
      axios
        .post('/api/lessons', this.newLesson)
        .then((response) => {
          this.lessons.push(response.data);
          this.newLesson = { coach_id: '', date: '', time: '' }; // Reset form
        })
        .catch((error) => {
          console.error('Error adding lesson:', error);
        });
    },
    editLesson(lesson) {
      this.editingLesson = { ...lesson };
    },
    updateLesson() {
      axios
        .put(`/api/lessons/${this.editingLesson.id}`, this.editingLesson)
        .then((response) => {
          const index = this.lessons.findIndex((lesson) => lesson.id === response.data.id);
          this.$set(this.lessons, index, response.data);
          this.editingLesson = null;
        })
        .catch((error) => {
          console.error('Error updating lesson:', error);
        });
    },
    deleteLesson(lessonId) {
      axios
        .delete(`/api/lessons/${lessonId}`)
        .then(() => {
          this.lessons = this.lessons.filter((lesson) => lesson.id !== lessonId);
        })
        .catch((error) => {
          console.error('Error deleting lesson:', error);
        });
    },
    cancelEdit() {
      this.editingLesson = null;
    },
  },
};
</script>

<style scoped>
.lesson-management-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.add-lesson-form,
.edit-lesson-form {
  margin-bottom: 20px;
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

.btn-secondary {
  background-color: #6c757d;
}

.btn-danger {
  background-color: #dc3545;
}

.lessons-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.lessons-table th,
.lessons-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

.lessons-table th {
  background-color: #e9e9e9;
}

button {
  padding: 5px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 5px;
}
</style>
