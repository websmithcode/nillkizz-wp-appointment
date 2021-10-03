<template lang="pug">
.doctors-filter
  .search 
    ui-input(v-model="search", :name="'Поиск: Врач, Специальность'")
  .filters 
    ui-select(v-model="spec", :name="'Специальность'")
      option(value="") ----
      option(v-for="spec in specs", :key="spec.id", :value="spec.id") {{ spec.name }}
    ui-select(v-model="exp", :name="'Стаж'")
      option(value="") Любой
      option(value="5") От 5 лет
      option(value="15") От 15 лет
      option(value="30") От 30 лет
    ui-select(v-model="sex", :name="'Пол'")
      option(value="") Любой
      option(value="male") М
      option(value="female") Ж
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
      exp: "",
      sex: "",
    };
  },
  computed: {
    filters() {
      return Object.assign(this.modelValue, {
        spec: this.spec,
        search: this.search,
        experience: this.exp,
        sex: this.sex,
      });
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
    @apply flex gap-3
</style>
