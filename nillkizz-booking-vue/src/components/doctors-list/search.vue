<template lang="pug">
.search
  input(v-model="search", @input="onInput", placeholder="Врач, Специальность")
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
  methods: {
    onInput() {
      this.$emit("update:modelValue", this.search);
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
