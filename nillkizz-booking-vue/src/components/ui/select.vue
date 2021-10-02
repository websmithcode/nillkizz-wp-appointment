<template lang="pug">
.select.field(:class="{ empty: modelValue == '' }")
  select(v-model="value")
    slot
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
    @apply p-1 pt-4 w-full bg-white opacity-0 duration-300
  label
    top: .5rem
    @apply text-gray-400 absolute pointer-events-none duration-200 text-base left-2
  &:not(.empty)
    select
      @apply opacity-100
    label
      @apply top-0 text-xs
</style>
