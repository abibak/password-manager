import {instance} from "@/store";
import store from '@/store';

export default {
  namespaced: true,

  state: () => ({
    favoritesPassword: [],
    confirmDeleteLogin: false,
    showEditLogin: false,
    showSelectedLogin: false,
    showHeadLines: true,
  }),

  getters: {},

  mutations: {
    setFavoritesPassword(state, data) {
      state.favoritesPassword = data;
    },

    // показать/скрыть подтверждение удаления пароля
    setConfirmDeleteLogin(state, val) {
      state.confirmDeleteLogin = val;
    },

    setShowSelectedLogin(state, val) {
      state.showSelectedLogin = val;
    },

    setShowHeadLines(state, val) {
      state.showHeadLines = val;
    },

    setShowEditLogin(state, val) {
      state.showEditLogin = val;
    }
  },

  actions: {
    async sendRequestCreatePassword({state, dispatch, commit, getters}, data) {
      const link = await dispatch('folder/defineLink', null, {root: true});

      if (link === 'organization/') {
        data.organization_folder_id = store.state.folder.selectedOrgFolderId;
      } else if (link === 'user/') {
        data.user_folder_id = store.state.folder.selectedFolderId;
      }

      await instance.post(process.env.VUE_APP_API_URL + link + 'login', data).then(response => {
        if (response.status === 201) {
          //  поиск папки для установки пароля
          dispatch('folder/searchFolderById', null, {root: true}).then(data => {
            console.log(response.data);
            return commit('folder/setPasswordInDataFolder', {
              id: data,
              login: response.data.data[0],
            }, {root: true});
          });
        }
      });
    },

    async sendRequestDeleteLogin({dispatch, commit}) {
      const link = await dispatch('folder/defineLink', null, {root: true});
      const loginId = (link === 'organization/') ? store.state.folder.selectedOrgLoginId : store.state.folder.selectedLoginId;

      await instance.delete(process.env.VUE_APP_API_URL + link + 'login/' + loginId).then(response => {
        if (response.status === 200) {
          commit('setShowSelectedLogin', false);
          commit('setShowHeadLines', true);

          // обновить папки
          if (link === 'organization/') {
            return dispatch('folder/sendRequestGetOrganizationFolders', null, {root: true});
          }
          dispatch('folder/sendRequestGetFolders', null, {root: true});
        }
      }).catch(error => {
        // error deleting login
        if (error.response.status === 400) {
          console.log(error.response.data.message);
        }
      });
    },

    async sendRequestEditLogin({state, dispatch}, data) {
      const link = await dispatch('folder/defineLink', null, {root: true});
      const loginId = (link === 'organization/')
        ? store.state.folder.selectedOrgLoginId : store.state.folder.selectedLoginId;

      let dataUpdatePassword = {
        name: data.name,
        login: data.login,
        password: data.password,
        url: data.url,
        note: data.note,
        tag: data.tags,
      };

      await instance.put(process.env.VUE_APP_API_URL + link + 'login/' + loginId, dataUpdatePassword).then(response => {
        if (response.status === 200) {
          // обновить папки
          if (link === 'organization/') {
            return dispatch('folder/sendRequestGetOrganizationFolders', null, {root: true});
          }
          dispatch('folder/sendRequestGetFolders', null, {root: true});
        }
      });
    },

    async sendRequestPasswordEvent({}, data) {
      await instance.post(process.env.VUE_APP_API_URL + 'login/action', data);
    },

    async sendRequestAddPasswordFavorite({dispatch, commit}, loginId) {
      const link = await dispatch('folder/defineLink', null, {root: true});

      dispatch('folder/searchFolderById', null, {root: true}).then(index => {
        commit('folder/changeLoginFavoriteStatus', {
          index_folder: index,
        }, {root: true});
      });

      await instance.get(process.env.VUE_APP_API_URL + link + 'login/favorite/change/' + loginId);
    },

    async sendRequestGetFavoritesPassword({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'login/favorites').then(response => {
        commit('setFavoritesPassword', response.data);
      })
    }
  },
}
