<template lang="pug">
nav.pagination(v-if="enabled")
  ul
    li.prev(@click="value--", :disabled="value < 2") Назад
    li.page(
      v-for="page in pages",
      :class="{ active: page.active }",
      :disabled="page.disabled",
      @click="setPage(page.value)"
    ) {{ page.value }}
    li.next(@click="value++", :disabled="value > pages.slice(-1)[0].value - 1") Дальше
</template>

<script>
export default {
  props: {
    modelValue: Number,
    perPage: Number,
    elemsCount: Number,
    elems: Array,
    paginated: Array,
    startSize: Number,
    middleSize: Number,
    endSize: Number,
  },
  emits: ["update:modelValue", "update:paginated", "pageChanged"],
  data() {
    return {
      value: this.modelValue ?? 1,
    };
  },
  methods: {
    setPage(page) {
      this.value = page;
      this.$emit("pageChanged", this.value);
    },
    emitUpdates() {
      this.$emit("update:modelValue", this.value);

      if (this.perPage < 1) return this.paginated;
      this.$emit(
        "update:paginated",
        this.elems.slice(
          (this.value - 1) * this.perPage,
          (this.value - 1) * this.perPage + this.perPage
        )
      );
    },
  },
  computed: {
    enabled() {
      return (
        this.elCount > 0 && this.perPage > 0 && this.elCount > this.perPage
      );
    },
    elCount() {
      if (this.elemsCount) return this.elemsCount;
      return this.elems.length;
    },
    sizes() {
      const wwidth = window.innerWidth;
      const start = wwidth > 480 ? this.startSize ?? 1 : 1;
      const middle =
        wwidth > 380 ? (wwidth > 640 ? this.middleSize ?? 1 : 1) : 0;
      const end = wwidth > 480 ? this.endSize ?? 1 : 1;

      return { start, middle, end };
    },
    pages() {
      if (!this.enabled) return [];
      const pcount = Math.ceil(this.elCount / this.perPage);
      const fullpages = Array.from({ length: pcount }, (_, i) => i + 1).map(
        (page) => ({ value: page, active: page == this.value, disabled: false })
      );
      const cIndex = this.value - 1;
      const first = fullpages.slice(
        0,
        Math.min(
          Math.max(fullpages.length - this.sizes.end, 1),
          this.sizes.start
        )
      );
      const last = fullpages.slice(
        -Math.min(
          Math.max(fullpages.length - this.sizes.start, 1),
          this.sizes.end
        )
      );

      const current = fullpages
        .slice(
          Math.max(0, cIndex - this.sizes.middle),
          cIndex + 1 + this.sizes.middle
        )
        .filter((page) => {
          const inStart = first.some((i) => i.value == page.value);
          const inEnd = last.some((i) => i.value == page.value);
          return !(inStart || inEnd);
        });
      const pages = [...first, ...current, ...last];
      if (current.length > 0) {
        if (current[0].value > first.slice(-1)[0].value + 1)
          pages.splice(this.sizes.start, 0, { value: "...", disabled: true });
        if (current.slice(-1)[0].value < last[0].value - 1)
          pages.splice(-this.sizes.end, 0, { value: "...", disabled: true });
      } else if (
        fullpages.length >
        current.length + first.length + last.length
      ) {
        pages.splice(-this.sizes.end, 0, { value: "...", disabled: true });
      }

      return pages;
    },
  },
  watch: {
    elems() {
      this.value = 1;
      this.$nextTick(this.emitUpdates);
    },
    pages() {
      this.$nextTick(this.emitUpdates);
    },
  },
};
</script>

<style scoped lang="sass">
.pagination
  @apply flex justify-center select-none
  ul
    border: 0 solid silver
    border-width: 0 0 1px 1px
    @apply flex
    li
      border: 0 solid silver
      border-width: 1px 1px 0 0
      @apply text-sm px-2 min-w-8 h-8 flex justify-center items-center cursor-pointer
      &.active
        @apply bg-gray-700 text-white pointer-events-none
      &[disabled="true"]
        @apply text-gray-400 pointer-events-none
</style>
