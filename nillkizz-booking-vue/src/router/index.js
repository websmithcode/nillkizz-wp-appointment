import { createRouter, createWebHashHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "list",
    component: () => import("@/views/list.vue"),
  },
  {
    path: "/appointment/doctor_:doctorId/day_:dayISO/slot_:slotTime",
    name: "appointment",
    component: () => import("@/views/appointment.vue"),
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
