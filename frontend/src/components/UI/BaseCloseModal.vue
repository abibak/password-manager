<template>
  <i class="bi bi-x" @click="closeModal"></i>
</template>

<script>
export default {
  name: "BaseCloseModal",

  methods: {
    closeModal() {
      this.$emit('closeModal');
    },
  }
}
</script>

<style lang="scss" scoped>
.bi-x {
  font-size: 34px;
  cursor: pointer;
  position: absolute;
  top: 0;
  right: 0;
  -o-transition: color $transTime;
  -webkit-transition: color $transTime;
  -moz-transition: color $transTime;
  transition: color $transTime;

  &:hover {
    color: #a3a3a3;
  }
}
</style>
