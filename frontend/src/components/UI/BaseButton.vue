<template>
  <button class="base-button">
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "BaseButton"
}
</script>

<style lang="scss" scoped>
.base-button {
  width: 170px;
  height: 40px;
  border: none;
  font-size: 16px;
  border-radius: 14px;
  background-color: #2683E0;
  color: #fff;
  cursor: pointer;
  transition: background-color $transTime;

    &:hover {
      background-color: rgba(38, 131, 224, .85);
    }
}
</style>
