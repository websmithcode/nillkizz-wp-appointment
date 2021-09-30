<template lang="pug">
.app_wrapper(v-cloak, :class="{ loading: IS_LOADING }")
  doctors-list(:doctors="doctors")
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
    let doctors = await this.$store.dispatch("loading", api.getDoctors());
    const specs = await this.$store.dispatch("loading", api.getSpecialties());
    const timeslots = await this.$store.dispatch("loading", api.getTimeslots());

    doctors = doctors.map((doc) => {
      doc.specialty = doc.specialty.map((specId) => ({
        id: specId,
        name: specs[specId],
      }));
      doc.timeslots = timeslots.filter((ts) => ts.doctor_id == doc.id);
      return doc;
    });
    this.doctors = doctors;
  },
  data() {
    return {
      doctors: [],
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
