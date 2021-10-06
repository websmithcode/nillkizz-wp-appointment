import { createRouter, createWebHashHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "list",
    component: () => import("@/views/list.vue"),
  },
  {
    path: "/appointment",
    name: "appointment",
    component: () => import("@/views/appointment.vue"),
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
