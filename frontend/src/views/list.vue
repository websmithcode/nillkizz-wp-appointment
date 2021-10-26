<template lang="pug">
.doctors-list 
  teleport(to="#debug-area") {{ filters }}
  doctors-filter(v-model="filters")
  main
    .doctors(v-if="!!paginated.length")
      doctor(v-for="doc in paginated", :key="doc.id", :doctor="doc")
    .empty(v-else) Ничего не найдено
  ui-pagination(
    v-model:paginated="paginated",
    :perPage="perPage",
    :elems="filteredDoctors",
    :startSize="2",
    :endSize="2",
    :middleSize="2",
    @pageChanged="pageChanged = true"
  )
</template>

<script>
import { mapGetters } from "vuex";

import doctorsFilter from "@/components/doctors-list/filter";
import doctor from "@/components/doctors-list/doctor";
import uiPagination from "@/components/ui/pagination";

export default {
  components: { doctorsFilter, doctor, uiPagination },
  data() {
    return {
      pageChanged: false,
      paginated: [],
      perPage: 3,
      filters: {
        search: "",
        spec: "",
        experience: "",
        gender: "",
      },
    };
  },
  methods: {
    scrollToTop() {
      this.$nextTick(() => {
        debugger;
        document.getElementById("top-of-doctors-list").scrollIntoView();
      });
    },
  },
  computed: {
    ...mapGetters(["doctors"]),
    searchedDoctors() {
      function search(doc) {
        const query = this.filters.search.trim().split(" ");
        const byName = query.some((key) => {
          return doc.name.includes(key);
        });
        const bySpec = query.some((key) => {
          return doc.specialty.some((spec) =>
            spec ? spec.val.includes(key) : false
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
          founded &&= doc.specialty
            .map((spec) => spec.id)
            .includes(parseInt(spec));

        const exp = this.filters.experience;
        if (/^\d+$/.test(exp)) founded &&= doc.experience > parseInt(exp);

        const gender = this.filters.gender;
        if (["male", "female"].includes(gender))
          founded &&= doc.gender.value == gender;
        return founded;
      });
    },
  },
  watch: {
    paginated() {
      this.$nextTick(() => {
        if (this.pageChanged) {
          this.$el.scrollIntoView();
          this.pageChanged = false;
        }
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
