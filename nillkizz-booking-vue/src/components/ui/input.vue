<template lang="pug">
.select.field(:class="{ empty: value == '' }")
  input(v-model="value")
  label {{ name }}
</template>

<script>
export default {
  props: {
    modelValue: String,
    name: String,
  },
  data() {
    return {
      value: this.modelValue ?? "",
    };
  },
  watch: {
    value(newVal) {
      this.$emit("update:modelValue", newVal);
    },
  },
};
</script>

<style scoped lang="sass">
.field
  @apply border-gray-500 border relative
  input
    @apply p-1 pl-2 pt-3 w-full
  label
    top: .5rem
    @apply text-gray-400 absolute pointer-events-none duration-200 text-base left-2 select-none
  input:focus ~ label, &:not(.empty) label
    @apply top-0 text-xs
</style>
