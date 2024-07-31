import { createRouter, createWebHistory } from "vue-router";
import Login from "../components/Login.vue";
import Review from "../components/Review.vue";
import Booking from "../components/Booking.vue";
import ScheduleManagement from "../components/ScheduleManagement.vue";
import UserManagement from "../components/UserManagement.vue";
import LessonManagement from "../components/LessonManagement.vue";
import Home from "../pages/Home.vue";
import Register from "../components/Register.vue";

const routes = [
  { path: "/login", component: Login },
  { path: "/review", component: Review },
  { path: "/booking", component: Booking },
  { path: "/schedule-management", component: ScheduleManagement },
  { path: "/user-management", component: UserManagement },
  { path: "/lesson-management", component: LessonManagement },
  { path: "/", component: Home },
  { path: "/register", component: Register },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
