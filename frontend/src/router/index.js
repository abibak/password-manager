import { createRouter, createWebHistory } from 'vue-router';
import store from '@/store/index';
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
  return !store.state.auth.userData && !localStorage.getItem('authToken');
}

router.beforeEach(async (to) => {
  if (to.name !== 'login' && checkAuth()) {
    await router.push('login');
  }

  if (to.name === 'login' && !checkAuth()) {
    await router.push({name: 'main'});
  }
});

export default router
