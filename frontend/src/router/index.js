import {createRouter, createWebHistory} from 'vue-router';
import store from '@/store';
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

function getToken() {
  return localStorage.getItem('authToken') || false;
}

router.beforeEach(async (to, from, next) => {
  if (to.name !== 'login' && !getToken()) {
    return next('/login');
  }

  if (to.name === 'login' && getToken()) {
    return next('/');
  }

  next();
});

export default router
