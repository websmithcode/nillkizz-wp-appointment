<template lang="pug">
.doctors-filter
  .filters 
    .filter(:class="{ empty: spec == '' }")
      label Специальность
      select(v-model="spec")
        option(value="")
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
.filters
  @apply flex
  .filter
    @apply border-gray-500 border relative pt-1
    select
      @apply p-2
    label
      @apply text-gray-400 absolute pointer-events-none top-0 left-2 text-xs duration-200
    &.empty
      label
        top: .5rem
        @apply text-base
</style>
