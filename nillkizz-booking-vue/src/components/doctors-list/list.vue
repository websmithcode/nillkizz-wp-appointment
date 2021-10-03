<template lang="pug">
.doctors-list
  doctors-filter(v-model="filters", :specs="specs")
  main.doctors {{ filters }}
    doctor(
      v-for="doc in paginated",
      :key="doc.id",
      :doctor="doc",
      :specs="specs"
    )
  ui-pagination(
    v-model:paginated="paginated",
    :perPage="perPage",
    :elems="doctors",
    :startSize="2",
    :endSize="2",
    :middleSize="2"
  )
</template>

<script>
import doctorsFilter from "./filter";
import doctor from "./doctor";
import uiPagination from "@/components/ui/pagination";
export default {
  components: { doctorsFilter, doctor, uiPagination },
  props: {
    doctors: Array,
    specs: Object,
  },
  data() {
    return {
      paginated: this.doctors,
      perPage: 3,
      filters: {
        search: "",
        spec: "",
        experience: "",
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

        const exp = this.filters.experience;
        if (/^\d+$/.test(exp)) founded &&= doc.experience > parseInt(exp);

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
    @apply flex flex-col items-center gap-3 mb-4
</style>
