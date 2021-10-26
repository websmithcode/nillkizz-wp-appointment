<template lang="pug">
.doctors-filter
  .search
    ui-input(v-model="search", :name="'Поиск: Врач, Специальность'")
  .filters
    ui-select(
      v-model="spec",
      :name="'Специальность'",
      style="min-width: 150px"
    )
      option(value="") ----
      option(v-for="spec in specs", :key="spec[0]", :value="spec[0]") {{ spec[1] }}
    ui-select(v-model="exp", :name="'Стаж'")
      option(value="") Любой
      option(value="5") От 5 лет
      option(value="15") От 15 лет
      option(value="30") От 30 лет
    ui-select(v-model="gender", :name="'Пол'")
      option(value="") Любой
      option(value="male") М
      option(value="female") Ж
</template>

<script>
import { mapGetters } from "vuex";

import uiSelect from "@/components/ui/select";
import uiInput from "@/components/ui/input";

export default {
  components: {
    uiSelect,
    uiInput,
  },
  props: {
    modelValue: Object,
  },
  data() {
    return {
      search: "",
      spec: "",
      exp: "",
      gender: "",
    };
  },
  computed: {
    ...mapGetters(["specs"]),
    filters() {
      return Object.assign(this.modelValue, {
        spec: this.spec,
        search: this.search,
        experience: this.exp,
        gender: this.gender,
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
