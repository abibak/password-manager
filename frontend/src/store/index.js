import {createStore} from 'vuex'
import auth from "@/store/auth";

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
  }
})
