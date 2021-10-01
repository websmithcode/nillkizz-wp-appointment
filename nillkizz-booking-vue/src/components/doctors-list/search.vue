<template lang="pug">
.search
  input(v-model="search", placeholder="Врач, Специальность")
</template>

<script>
export default {
  props: {
    modelValue: String,
  },
  data() {
    return {
      search: "",
    };
  },
  watch: {
    search(newVal) {
      this.$emit("update:modelValue", newVal);
    },
  },
};
</script>

<style scoped lang="sass">
.search
  @apply border-gray-500 border mb-4
  input
    @apply p-2 w-full
  button.find
    @apply bg-gray-500 text-white py-2 px-4
</style>
