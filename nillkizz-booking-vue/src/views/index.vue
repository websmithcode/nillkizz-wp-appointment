<template lang="pug">
doctors-list(:doctors="doctors", :specs="specs")
</template>

<script>
import doctorsList from "@/components/doctors-list/list";
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
      doctors: [],
      specs: {},
    };
  },
};
</script>
