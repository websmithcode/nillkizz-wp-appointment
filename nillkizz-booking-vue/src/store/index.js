import { createStore } from "vuex";
import api from "@/api";

export default createStore({
  state: {
    loading: 0,
    specs: {},
    doctors: [],
  },
  getters: {
    IS_LOADING(state) {
      return state.loading > 0;
    },
    specs(state) {
      return state.specs;
    },
    doctors(state) {
      return state.doctors;
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
    async fetchDoctorsAndSpecs(context) {
      const { doctors, specs } = await context.dispatch(
        "loading",
        api.getDoctorsAndSpecs()
      );
      context.state.specs = specs;
      context.state.doctors = doctors;
    },
  },
  modules: {},
});
