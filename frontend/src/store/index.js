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
    errors: null,
    users: null,
    roles: [],
    openGeneralSettings: false, // основное левое боковое меню настроек
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

    setUsers(state, data) {
      state.users = data;
    },

    setRoles(state, data) {
      state.roles = data;
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

    setUserStatusDeactivate(state, data) {
      for (const user of state.users) {
        if (user.id === data.data.id) {
          user.is_deactivate = data.data.is_deactivate;
          break;
        }
      }
    },

    setCreatedUser(state, data) {
      state.users.push(data)
    },
  },

  actions: {
    async sendRequestGetAllUsers({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/account').then(response => {
        commit('setUsers', response.data);
      });
    },

    // Создать пользователя
    async sendRequestCreateUser({dispatch, commit}, data) {
      const obj = {
        'role_id': data.roleId,
        login: data.login,
        email: data.email,
        'is_admin': false,
      }

      await instance.post(process.env.VUE_APP_API_URL + 'user/account', obj).then(response => {
        commit('setCreatedUser', response.data.data);
      }).catch(error => {
        commit('setErrors', error.response.data.errors);
      });
    },

    // maybe account store
    async sendRequestDeleteUser({dispatch}, id) {
      await instance.delete(process.env.VUE_APP_API_URL + 'user/account/' + id).then(response => {
        console.log(response);
        dispatch('sendRequestGetAllUsers');
      })
    },

    async sendRequestGetRoles({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'role').then(response => {
        commit('setRoles', response.data);
      });
    },
  },

  modules: {
    auth: auth,
    folder: folder,
    organizationFolder: organizationFolder,
    login: login,
    settings: settings,
    account: account,
  }
})
