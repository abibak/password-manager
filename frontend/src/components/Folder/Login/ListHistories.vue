<template>
<div class="password-histories" v-show="show">
  {{history}}
</div>
</template>

<script>
export default {
  name: "ListHistories",

  props: {
    history: {
      type: Array,
      required: true,
      default: [],
    },

    show: {
      type: Boolean,
      required: true,
      default: false,
    }
  },
}
</script>

<style lang="scss" scoped>

</style>
