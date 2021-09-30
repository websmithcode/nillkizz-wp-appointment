import { createStore } from "vuex";

export default createStore({
  state: {
    loading: 0,
  },
  getters: {
    IS_LOADING(state) {
      return state.loading > 0;
    },
  },
  mutations: {
    loading(state) {
      state.loading++;
    },
    loaded(state) {
      state.loading--;
    },
  },
  actions: {
    loading(context, promise) {
      context.commit("loading");
      return promise.then((data) => {
        context.commit("loaded");
        return data;
      });
    },
  },
  modules: {},
});
