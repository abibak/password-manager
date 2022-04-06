import {createStore} from 'vuex';
import axios from "axios";
import auth from "@/store/auth";
import userFolder from "@/store/userFolder";
import organizationFolder from '@/store/organizationFolder'

export const instance = axios.create();
instance.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('authToken');

export default createStore({
  state: () => ({
    errors: '',
    showSectionSelectedFolder: false,
    typeFolder: null,
  }),

  getters: {},

  mutations: {
    setErrors(state, data) {
      state.errors = data;
    },

    setShowSectionSelectedFolder(state, val) {
      state.showSectionSelectedFolder = val;
    },

    setTypeFolder(state, type) {
      state.typeFolder = type;
    },
  },

  actions: {

  },

  modules: {
    auth: auth,
    userFolder: userFolder,
    organizationFolder: organizationFolder,
  }
})
