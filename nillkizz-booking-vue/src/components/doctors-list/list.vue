<template lang="pug">
.doctors-list
  doctors-filter(v-model="filters", :specs="specs")
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
import doctor from "./doctor";
export default {
  components: { doctorsFilter, doctor },
  props: {
    doctors: Array,
    specs: Object,
  },
  data() {
    return {
      filters: {
        search: "",
        spec: "",
      },
    };
  },
  methods: {},
  computed: {
    searchedDoctors() {
      function search(doc) {
        const query = this.filters.search.trim().split(" ");
        const byName = query.some((key) => {
          return doc.name.includes(key);
        });
        const bySpec = query.some((key) => {
          return doc.spec.some((spec) =>
            spec ? spec.name.includes(key) : false
          );
        });
        return byName || bySpec;
      }
      const searched = this.doctors.filter(search.bind(this));
      return searched;
    },
    filteredDoctors() {
      return this.searchedDoctors.filter((doc) => {
        let founded = true;

        const spec = this.filters.spec;
        if (/^\d+$/.test(spec))
          founded &&= doc.specialty.includes(parseInt(spec));
        return founded;
      });
    },
  },
};
</script>

<style lang="sass" scoped>
.doctors-list
  @apply mx-2
  .doctors
    @apply flex flex-col items-center gap-3
</style>
