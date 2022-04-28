import {createStore} from 'vuex';
import axios from "axios";
import auth from "@/store/auth";
import organizationFolder from '@/store/organizationFolder'
import folder from "@/store/folder";
import login from "@/store/login";
import settings from "@/store/settings";
import account from "@/store/account";

export const instance = axios.create();

export default createStore({
  state: () => ({
    errors: '',
    openGeneralSettings: false,
    showSectionSelectedFolder: false,
    showTopSettingsMenu: false,
    showModalConfirmDelete: false,
    showModalRenameFolder: false,
    showModalAddingPassword: false,
  }),

  getters: {},

  mutations: {
    setErrors(state, data) {
      state.errors = data;
    },

    setShowSectionSelectedFolder(state, val) {
      state.showSectionSelectedFolder = val;
    },

    setShowModalConfirmDelete(state, val) {
      state.showModalConfirmDelete = val;
    },

    setShowTopSettingsMenu(state, val) {
      state.showTopSettingsMenu = val;
    },

    setShowModalAddingPassword(state, val) {
      state.showModalAddingPassword = val;
    },

    setOpenGeneralSettings(state, val) {
      state.openGeneralSettings = val;
    },

    setShowModalRenameFolder(state, val) {
      state.showModalRenameFolder = val;
    },
  },

  actions: {},

  modules: {
    auth: auth,
    folder: folder,
    organizationFolder: organizationFolder,
    login: login,
    settings: settings,
    account: account,
  }
})
