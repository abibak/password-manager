import {instance} from '@/store/index';

export default {
  namespaced: true,

  state: () => ({
    dataFolders: ['cyeta', 'cye1'],
  }),

  getters: {},

  mutations: {
    setDataFolders(state, data) {
      state.dataFolders = data;
    }
  },

  actions: {
    async sendRequestGetFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/folders', {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken')}
      }).then(response => {
          commit('setDataFolders', response.data);
        })
    },
  },
}
