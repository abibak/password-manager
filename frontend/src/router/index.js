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
})

function checkAuth() {
  return localStorage.getItem('authToken');
}

router.beforeEach((to) => {
  if (to.name === 'login' && checkAuth()) {
    router.push('/');
  }

  if (to.name !== 'login' && !checkAuth()) {
    router.push('login');
  }
});

export default router
