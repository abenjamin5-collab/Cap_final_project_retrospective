<template>
  <div>
    <navbar></navbar>
    <div class="background-image">
      <picture>
        <img
          class="image-class"
          src="https://d1di2lzuh97fh2.cloudfront.net/files/0z/0zl/0zlzu1.jpg?ph=0e5dbff36c"
          width="1920"
          height="1281"
          alt=""
          loading="lazy"
        />
      </picture>
      <div class="image-text">
        <div class="image-main-text">Tennis Center</div>
        <div class="image-sub-text">
          Programs for kids and adults. We give individual lessons.
        </div>
      </div>
    </div>
    <div class="home-page-text-container">
      <div class="teach-you-text">What we can teach you</div>
      <div class="tennis-lesson-code">TENNIS LESSONS</div>
      <hr class="tennis-lesson-code-line" />
      <div class="tennis-lesson-description">
        "Game, set, match! Welcome to our home of all things tennis. Whether
        you're a seasoned pro or just picking up a racket, we've got everything
        you need to ace your game. Explore tips, gear, and news to keep you at
        the top of your game."
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
export default {
  components: { Navbar },
};
</script>

<style scoped>
@import "../css/home.css";
</style>
