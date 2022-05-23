import Vue from "vue";
import Vuex from "vuex";
import router from "../router";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    isLoggedIn: !!localStorage.getItem('token')
  },
  getters: {
    getAuthenticated(state) {
      return state.isLoggedIn;
    },
  },
  mutations: {
    loginUser (state) {
      state.isLoggedIn = true
    },
    logoutUser (state) {
      state.isLoggedIn = false
    },
  },
  actions: {

  },
});

export default store;
