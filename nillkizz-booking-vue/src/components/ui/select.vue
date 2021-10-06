<template lang="pug">
.select.field(:class="{ empty: value == '' }")
  select(v-model="value")
    slot
  chevron-down-icon.chevron-down
  label {{ name }}
</template>

<script>
import { ChevronDownIcon } from "@heroicons/vue/solid";
export default {
  components: {
    ChevronDownIcon,
  },
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
  .chevron-down
    top: calc(50% - .5rem)
    @apply absolute right-1 text-gray-700 w-4 pointer-events-none
  select
    @apply p-1 pt-3 pr-4 w-full bg-white opacity-0 duration-300 appearance-none
  label
    top: .5rem
    @apply text-gray-400 absolute pointer-events-none duration-200 text-base left-2 select-none
  &:not(.empty)
    select
      @apply opacity-100
    label
      @apply top-0 text-xs
</style>
