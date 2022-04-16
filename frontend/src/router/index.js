import {createRouter, createWebHistory} from 'vue-router';
import {instance} from "@/store";
import {store} from '@/store/index';
import Login from "@/views/Login";
import Main from "@/views/Main";

//  routes
const routes = [
  {
    path: '/',
    name: 'main',
    component: Main
  },

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
});

export default router
