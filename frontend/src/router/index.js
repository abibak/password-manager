import { createRouter, createWebHistory } from 'vue-router'
import Login from "@/views/Login";

//  routes
const routes = [
  /*{
    path: '/',
    name: 'home',
    component: ''
  },*/

  {
    path: '/login',
    name: 'login',
    component: Login,
  },
]

//  register router
const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
