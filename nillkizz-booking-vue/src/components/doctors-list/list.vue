<template lang="pug">
.doctors-list
  doctors-search(v-model="search")
  doctors-filter(v-model="filters")
  main.doctors
    doctor(
      v-for="doc in filteredDoctors",
      :key="doc.id",
      :doctor="doc",
      :specs="specs"
    )
</template>

<script>
import doctorsFilter from "./filter";
import doctorsSearch from "./search";
import doctor from "./doctor";
export default {
  components: { doctorsFilter, doctorsSearch, doctor },
  props: {
    doctors: Array,
    specs: Object,
  },
  data() {
    return {
      search: "",
      filters: {},
    };
  },
  methods: {
    getSpecs(specIds) {
      if (this.specs) return specIds.map((id) => this.specs[id]);
    },
  },
  computed: {
    searchedDoctors() {
      function search(doc) {
        const query = this.search.trim().split(" ");
        const byName = query.some((key) => {
          return doc.name.includes(key);
        });
        const bySpec = query.some((key) => {
          const specs = this.getSpecs(doc.specialty);
          return specs.some((spec) => (spec ? spec.includes(key) : false));
        });
        return byName || bySpec;
      }
      const searched = this.doctors.filter(search.bind(this));
      return searched;
    },
    filteredDoctors() {
      const searched = this.searchedDoctors;
      return searched;
    },
  },
};
</script>

<style lang="sass" scoped>
.doctors-list
  .content
    @apply w-full
    .doctors
      @apply flex flex-col gap-3
</style>
