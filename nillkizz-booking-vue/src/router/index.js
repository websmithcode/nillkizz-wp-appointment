import { createRouter, createWebHashHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "list",
    component: () => import("@/views/list.vue"),
  },
  {
    path: "/appointment/doctor_:doctor_id/day_:day/slot_:time",
    name: "appointment",
    component: () => import("@/views/appointment.vue"),
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
