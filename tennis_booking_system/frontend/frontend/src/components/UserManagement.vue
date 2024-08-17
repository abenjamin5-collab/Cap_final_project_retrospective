<template>
  <div class="user-management-container">
    <h1>User Management</h1>
    <div class="add-user-form">
      <h2>Add New User</h2>
      <form @submit.prevent="addUser">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" v-model="newUser.name" id="name" required />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" v-model="newUser.email" id="email" required />
        </div>
        <div class="form-group">
          <label for="role">Role:</label>
          <select v-model="newUser.role" id="role" required>
            <option value="student">Student</option>
            <option value="coach">Coach</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
      </form>
    </div>

    <div class="user-list">
      <h2>User List</h2>
      <table class="users-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.role }}</td>
            <td>
              <button @click="editUser(user)" class="btn btn-secondary">Edit</button>
              <button @click="deleteUser(user.id)" class="btn btn-danger">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="editingUser" class="edit-user-form">
      <h2>Edit User</h2>
      <form @submit.prevent="updateUser">
        <div class="form-group">
          <label for="edit-name">Name:</label>
          <input type="text" v-model="editingUser.name" id="edit-name" required />
        </div>
        <div class="form-group">
          <label for="edit-email">Email:</label>
          <input type="email" v-model="editingUser.email" id="edit-email" required />
        </div>
        <div class="form-group">
          <label for="edit-role">Role:</label>
          <select v-model="editingUser.role" id="edit-role" required>
            <option value="student">Student</option>
            <option value="coach">Coach</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
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
      users: [],
      newUser: {
        name: '',
        email: '',
        role: 'student',
      },
      editingUser: null,
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios
        .get('/api/users')
        .then((response) => {
          this.users = response.data;
        })
        .catch((error) => {
          console.error('Error fetching users:', error);
        });
    },
    addUser() {
      axios
        .post('/api/users', this.newUser)
        .then((response) => {
          this.users.push(response.data);
          this.newUser = { name: '', email: '', role: 'student' }; // Reset form
        })
        .catch((error) => {
          console.error('Error adding user:', error);
        });
    },
    editUser(user) {
      this.editingUser = { ...user };
    },
    updateUser() {
      axios
        .put(`/api/users/${this.editingUser.id}`, this.editingUser)
        .then((response) => {
          const index = this.users.findIndex((user) => user.id === response.data.id);
          this.$set(this.users, index, response.data);
          this.editingUser = null;
        })
        .catch((error) => {
          console.error('Error updating user:', error);
        });
    },
    deleteUser(userId) {
      axios
        .delete(`/api/users/${userId}`)
        .then(() => {
          this.users = this.users.filter((user) => user.id !== userId);
        })
        .catch((error) => {
          console.error('Error deleting user:', error);
        });
    },
    cancelEdit() {
      this.editingUser = null;
    },
  },
};
</script>

<style scoped>
.user-management-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.add-user-form,
.edit-user-form {
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

.users-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.users-table th,
.users-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

.users-table th {
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
