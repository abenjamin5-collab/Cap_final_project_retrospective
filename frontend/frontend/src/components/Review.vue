<template>
  <div class="review-container">
    <h1>Leave a Review</h1>
    <form @submit.prevent="submitReview">
      <div class="form-group">
        <label for="lesson">Lesson</label>
        <select v-model="review.lesson" id="lesson" required>
          <option v-for="lesson in lessons" :key="lesson.id" :value="lesson.id">
            {{ lesson.name }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label for="rating">Rating</label>
        <input
          type="number"
          v-model="review.rating"
          id="rating"
          min="1"
          max="5"
          required
        />
      </div>
      <div class="form-group">
        <label for="comment">Comment</label>
        <textarea
          v-model="review.comment"
          id="comment"
          rows="4"
          required
        ></textarea>
      </div>
      <button type="submit">Submit Review</button>
    </form>

    <h2>Reviews</h2>
    <div v-if="reviews.length">
      <div v-for="review in reviews" :key="review.id" class="review">
        <p><strong>Lesson:</strong> {{ review.lesson_name }}</p>
        <p><strong>Rating:</strong> {{ review.rating }}</p>
        <p><strong>Comment:</strong> {{ review.comment }}</p>
      </div>
    </div>
    <div v-else>
      <p>No reviews yet.</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      lessons: [],
      reviews: [],
      review: {
        lesson: "",
        rating: "",
        comment: "",
      },
    };
  },
  created() {
    this.fetchLessons();
    this.fetchReviews();
  },
  methods: {
    fetchLessons() {
      axios
        .get("/api/lessons/")
        .then((response) => {
          this.lessons = response.data;
        })
        .catch((error) => {
          console.error("Error fetching lessons:", error);
        });
    },
    fetchReviews() {
      axios
        .get("/api/reviews/")
        .then((response) => {
          this.reviews = response.data;
        })
        .catch((error) => {
          console.error("Error fetching reviews:", error);
        });
    },
    submitReview() {
      axios
        .post("/api/reviews/", this.review)
        .then((response) => {
          this.reviews.push(response.data);
          this.review.lesson = "";
          this.review.rating = "";
          this.review.comment = "";
        })
        .catch((error) => {
          console.error("Error submitting review:", error);
        });
    },
  },
};
</script>

<style scoped>
.review-container {
  max-width: 600px;
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

input,
select,
textarea {
  width: 100%;
  padding: 8px;
  margin-top: 2px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  display: inline-block;
  padding: 10px 15px;
  background: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #0056b3;
}

.review {
  padding: 15px;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin-bottom: 10px;
}
</style>
