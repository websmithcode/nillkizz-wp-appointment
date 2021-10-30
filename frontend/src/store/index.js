import { createStore } from "vuex";
import api from "@/api";

export default createStore({
  state: {
    loading: 0,
    specs: new Map(),
    doctors: [],
    mapDoctors: new Map(),
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
    mapDoctors(state) {
      return state.mapDoctors;
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
      const { mapDoctors, doctors, specs } = await context.dispatch(
        "loading",
        api.getDoctorsAndSpecs()
      );
      context.state.specs = specs;
      context.state.doctors = doctors;
      context.state.mapDoctors = mapDoctors;
    },
  },
  modules: {},
});
