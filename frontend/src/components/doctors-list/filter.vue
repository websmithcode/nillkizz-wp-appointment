<template lang="pug">
.doctors-filter
  .search
    q-input(
      square,
      outlined,
      dense,
      bg-color="white",
      v-model="search",
      label="Поиск: Врач, Специальность"
    )
      template(v-slot:append)
        q-icon.cursor-pointer(
          size="xs",
          name="clear",
          v-if="search !== ''",
          @click.stop="gender = ''"
        )
  .filters
    q-select(
      square,
      outlined,
      dense,
      v-model="spec",
      :options="specOptions",
      label="Специальность",
      :style="{ minWidth: '170px' }"
    )
      template(v-slot:append)
        q-icon.cursor-pointer(
          size="xs",
          name="clear",
          v-if="spec !== null",
          @click.stop="spec = null"
        )
    q-select(
      square,
      outlined,
      dense,
      v-model="exp",
      :options="expOptions",
      label="Стаж",
      :style="{ minWidth: '140px' }"
    )
      template(v-slot:append)
        q-icon.cursor-pointer(
          size="xs",
          name="clear",
          v-if="exp !== null",
          @click.stop="exp = null"
        )
    q-select(
      square,
      outlined,
      dense,
      v-model="gender",
      :options="genderOptions",
      label="Пол",
      :style="{ minWidth: '100px' }"
    )
      template(v-slot:append)
        q-icon.cursor-pointer(
          size="xs",
          name="clear",
          v-if="gender !== null",
          @click.stop="gender = null"
        )
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    modelValue: Object,
  },
  data() {
    return {
      search: "",
      spec: null,
      exp: null,
      gender: null,
      expOptions: [
        { label: "От 5 лет", value: "5" },
        { label: "От 15 лет", value: "15" },
        { label: "От 30 лет", value: "30" },
      ],
      genderOptions: [
        { label: "М", value: "male" },
        { label: "Ж", value: "female" },
      ],
    };
  },
  computed: {
    ...mapGetters(["specs"]),
    filters() {
      return Object.assign(this.modelValue, {
        search: this.search,
        spec: this.spec?.value ?? "",
        experience: this.exp?.value ?? "",
        gender: this.gender?.value ?? "",
      });
    },
    specOptions() {
      return Array.from(this.specs.entries()).map((spec) => ({
        label: spec[1],
        value: spec[0],
      }));
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
  @apply mb-3 mx-1
  .search
    @apply mb-2
  .filters
    @apply flex gap-3 flex-wrap
</style>
