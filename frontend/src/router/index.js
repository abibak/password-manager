import {createRouter, createWebHistory} from 'vue-router';
import Login from "@/views/Login";
import Main from "@/views/Main";
import store from "@/store";

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
  return localStorage.getItem('authToken');
}

router.beforeEach(async (to, from, next) => {
  console.log(store.getters["auth/getIsAuth"]);

  if (to.name !== 'login' && !getToken() && store.getters["auth/getIsAuth"] === false) {
    return next('/login');
  }

  if (to.name === 'login' && getToken()) {
    return next('/');
  }

  next();
});

export default router
