import {instance} from "@/store";
import store from '@/store';

export default {
  namespaced: true,

  state: () => ({
    dataCurrentSelectedLogin: null,
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

    // показать выбранный логин
    setShowSelectedLogin(state, val) {
      state.showSelectedLogin = val;
    },

    setShowHeadLines(state, val) {
      state.showHeadLines = val;
    },

    setShowEditLogin(state, val) {
      state.showEditLogin = val;
    },

    setDataCurrentSelectedLogin(state, data) {
      state.dataCurrentSelectedLogin = data;
    },

    setItemHistoryLogin(state, item) {
      if (state.dataCurrentSelectedLogin.histories) {
        state.dataCurrentSelectedLogin?.histories.push(item);
      }
    }
  },

  actions: {
    // запрос на добавление пароля
    async sendRequestCreatePassword({dispatch, commit}, data) {
      const link = await dispatch('folder/defineLink', null, {root: true});

      if (link === 'organization/') {
        data.organization_folder_id = store.state.folder.selectedOrgFolderId;
      } else if (link === 'user/') {
        data.user_folder_id = store.state.folder.selectedFolderId;
      }

      await instance.post(process.env.VUE_APP_API_URL + link + 'login', data).then(response => {
        //  добавить пароль
        commit('folder/setPasswordInDataFolder', response.data.data[0], {root: true});
      }).catch(error => {
        commit('setErrors', error.response.data, {root: true});
      });
    },

    // запрос на удаление логина
    async sendRequestDeleteLogin({dispatch, commit}) {
      const link = await dispatch('folder/defineLink', null, {root: true});
      const loginId = (link === 'organization/') ? store.state.folder.selectedOrgLoginId : store.state.folder.selectedLoginId;

      await instance.delete(process.env.VUE_APP_API_URL + link + 'login/' + loginId).then(() => {
        commit('setShowSelectedLogin', false);
        commit('setShowHeadLines', true);

        // обновить папки
        if (link === 'organization/') {
          return dispatch('folder/sendRequestGetOrganizationFolders', null, {root: true});
        }
        dispatch('folder/sendRequestGetUserFolders', null, {root: true});
      }).catch(error => {
        commit('setErrors', {
          error: [error.response.data.message],
        }, {root: true});
      });
    },

    // запрос на редактирование логина
    async sendRequestEditLogin({state, dispatch}, data) {
      const link = await dispatch('folder/defineLink', null, {root: true});
      const loginId = (link === 'organization/')
        ? store.state.folder.selectedOrgLoginId : store.state.folder.selectedLoginId;

      await instance.put(process.env.VUE_APP_API_URL + link + 'login/' + loginId, data).then(() => {
        dispatch('sendRequestPasswordEvent', {
          login_id: store.state.folder.selectedOrgLoginId,
          action: 'Изменил пароль',
        });
      });
    },

    // запрос на событие логина
    async sendRequestPasswordEvent({commit}, data) {
      await instance.post(process.env.VUE_APP_API_URL + 'login/action', data).then(response => {
        commit('setItemHistoryLogin', response.data.data);
      });
    },

    // запрос на добавление логина в избранное
    async sendRequestAddPasswordFavorite({dispatch, commit}, loginId) {
      const link = await dispatch('folder/defineLink', null, {root: true});

      // fix, создан отдельный proxy логин
      /*dispatch('folder/searchFolderById', null, {root: true}).then(index => {
        commit('folder/changeLoginFavoriteStatus', {
          index_folder: index,
        }, {root: true});
      });*/

      await instance.get(process.env.VUE_APP_API_URL + link + 'login/favorite/change/' + loginId);
    },

    // запрос на получение избранных паролей пользователя
    async sendRequestGetFavoritesPassword({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'login/favorites').then(response => {
        commit('setFavoritesPassword', response.data);
      })
    }
  },
}
