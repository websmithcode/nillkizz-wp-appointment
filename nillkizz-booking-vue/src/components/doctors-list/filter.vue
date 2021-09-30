<template lang="pug">
.doctors-filter
  .filters 
    select
      option(
        v-for="(spec, index) in getSpecialities()",
        :key="index",
        :value="spec"
      ) {{ spec }}
</template>

<script>
export default {
  props: {
    modelValue: Object,
    doctors: Array,
  },
  data() {
    return {
      search: "",
    };
  },
  methods: {
    doFilter() {
      const filters = {
        search: this.search,
      };
      this.$emit("update:modelValue", filters);
    },
    getSpecialities() {
      let specs = [];
      return specs;
    },
  },
};
</script>

<style scoped lang="sass">
.filters_wrapper
  .search
    @apply border-gray-500 border
    input
      @apply p-2 w-full
  button.find
    @apply bg-gray-500 text-white py-2 px-4
</style>
