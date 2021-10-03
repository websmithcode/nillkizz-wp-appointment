<template lang="pug">
.doctors-list
  doctors-filter(v-model="filters", :specs="specs")
  main
    .doctors(v-if="!!paginated.length") {{ filters }}
      doctor(
        v-for="doc in paginated",
        :key="doc.id",
        :doctor="doc",
        :specs="specs"
      )
    .empty(v-else) Ничего не найдено
  ui-pagination(
    v-model:paginated="paginated",
    :perPage="perPage",
    :elems="filteredDoctors",
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
      paginated: [],
      perPage: 3,
      filters: {
        search: "",
        spec: "",
        experience: "",
        sex: "",
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

        const sex = this.filters.sex;
        if (["male", "female"].includes(sex)) founded &&= doc.sex == sex;
        return founded;
      });
    },
  },
};
</script>

<style lang="sass" scoped>
.doctors-list
  @apply mx-2
  main
    .doctors
      @apply flex flex-col items-center gap-3 mb-4
    .empty
      @apply text-2xl text-center pt-24
</style>
