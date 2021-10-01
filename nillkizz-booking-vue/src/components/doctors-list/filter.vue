<template lang="pug">
.doctors-filter
  .filters
    select(v-model="spec")
      option(value="") Специальность
      option(v-for="spec in specs", :key="spec.id", :value="spec.id") {{ spec.name }}
</template>

<script>
export default {
  props: {
    modelValue: Object,
    specs: {},
  },
  data() {
    return {
      spec: "",
    };
  },
  computed: {
    filters() {
      return {
        spec: this.spec,
      };
    },
  },
  watch: {
    filters(newVal) {
      this.$emit("update:modelValue", newVal);
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
