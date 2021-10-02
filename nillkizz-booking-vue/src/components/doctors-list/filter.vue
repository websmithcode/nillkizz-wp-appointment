<template lang="pug">
.doctors-filter
  .search 
    ui-input(v-model="search", :name="'Поиск: Врач, Специальность'")
  .filters 
    ui-select(v-model="spec", :name="'Специальность'")
      option(value="")
      option(v-for="spec in specs", :key="spec.id", :value="spec.id") {{ spec.name }}
</template>

<script>
import uiSelect from "@/components/ui/select";
import uiInput from "@/components/ui/input";
export default {
  components: {
    uiSelect,
    uiInput,
  },
  props: {
    modelValue: Object,
    specs: {},
  },
  data() {
    return {
      search: "",
      spec: "",
    };
  },
  computed: {
    filters() {
      return {
        spec: this.spec,
        search: this.search,
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
.doctors-filter
  @apply mb-3
  .search
    @apply mb-2
  .filters
    @apply flex
</style>
