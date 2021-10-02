<template lang="pug">
.select.field(:class="{ empty: modelValue == '' }")
  label {{ name }}
  select(v-model="value")
    slot
</template>

<script>
export default {
  props: {
    modelValue: String,
    name: String,
  },
  data() {
    return {
      value: "",
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
  select
    @apply p-1 pt-4 w-full bg-white
  label
    top: .5rem
    @apply text-gray-400 absolute pointer-events-none duration-200 text-base left-2
  input:focus ~ label, &:not(.empty) label
    @apply top-0 text-xs
  input:focus ~ label
    @apply text-gray-900
</style>
