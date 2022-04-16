import {createStore} from 'vuex';
import auth from "@/store/auth";
import userFolder from "@/store/userFolder";
import organizationFolder from '@/store/organizationFolder'
import axios from "axios";

export const instance = axios.create();

export default createStore({
  state: () => ({
    errors: '',
    showSectionSelectedFolder: false,
    typeFolder: null,
    showTopSettingsMenu: false,
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

    setShowTopSettingsMenu(state, val) {
      state.showTopSettingsMenu = val;
    }
  },

  actions: {

  },

  modules: {
    auth: auth,
    userFolder: userFolder,
    organizationFolder: organizationFolder,
  }
})
