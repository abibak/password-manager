<template>
  <i class="bi bi-x base-close-modal"></i>
</template>

<script>
export default {
  name: "BaseCloseModal",
}
</script>

<style lang="scss" scoped>
.base-close-modal {
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
