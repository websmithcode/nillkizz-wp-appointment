<template lang="pug">
.doctors-list 
  doctors-filter(v-model="filters")
  .doctors(v-if="!!paginated.length")
    doctor(v-for="doc in filteredDoctors", :key="doc.id", :doctor="doc")
  .empty(v-else) Ничего не найдено
  q-pagination(
    v-if="maxPage > 1",
    v-model="currentPage",
    :max="maxPage",
    :max-pages="6",
    direction-links,
    boundary-numbers,
    unelevated
  )
</template>

<script>
import { mapGetters } from "vuex";

import doctorsFilter from "@/components/doctors-list/filter";
import doctor from "@/components/doctors-list/doctor";

export default {
  components: { doctorsFilter, doctor },
  data() {
    return {
      currentPage: 1,
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

      let searched = this.doctors;

      if (this.filters.search.length) {
        searched = searched.filter(search.bind(this));
      }

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
    paginated() {
      const pageIndex = this.currentPage - 1;
      return this.filteredDoctors.slice(
        pageIndex * this.perPage,
        pageIndex + 1 * this.perPage
      );
    },
    maxPage() {
      return Math.ceil(this.filteredDoctors.length / this.perPage);
    },
  },
};
</script>

<style lang="sass">
.doctors-list
  @apply flex flex-col
  .doctors
    @apply flex flex-col items-center gap-3 py-4
  .empty
    @apply text-2xl text-center pt-24
  .q-pagination
    @apply flex justify-center
    .q-btn--rectangle
      @apply rounded-none
</style>
