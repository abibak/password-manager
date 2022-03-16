import {createStore} from 'vuex';
import auth from "@/store/auth";
import userData from "@/store/userData";
import axios from "axios";

export const instance = axios.create();
instance.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('authToken');

export default createStore({
  state: () => ({
    errors: '',
  }),

  getters: {},

  mutations: {
    setErrors(state, data) {
      state.errors = data;
    },
  },

  actions: {

  },

  modules: {
    auth: auth,
    userData: userData,
  }
})
