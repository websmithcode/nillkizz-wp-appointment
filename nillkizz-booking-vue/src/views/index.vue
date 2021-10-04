<template lang="pug">
.app_wrapper(v-cloak, :class="{ loading: IS_LOADING }")
  doctors-list(:doctors="doctors", :specs="specs")
</template>

<script>
import doctorsList from "@/components/doctors-list/list";
import { mapState, mapGetters } from "vuex";
import api from "@/api";

export default {
  components: {
    doctorsList,
  },
  async mounted() {
    const { doctors, specs } = await this.$store.dispatch(
      "loading",
      api.getData()
    );
    this.doctors = doctors;
    this.specs = specs;
  },
  data() {
    return {
      loading: true,
      doctors: [],
      specs: {},
    };
  },
  computed: {
    ...mapState(["config"]),
    ...mapGetters(["IS_LOADING"]),
  },
};
</script>

<style lang="sass">
.app_wrapper > .doctors-list
  @apply opacity-100 duration-500
[v-cloack], .app_wrapper.loading
  max-height: 300px
  height: 300px
  > .doctors-list
    @apply opacity-0 pointer-events-none
</style>
