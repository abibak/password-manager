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

<style scoped>

.base-button {
  width: 160px;
  height: 45px;
  border: none;
  text-transform: uppercase;
  border-radius: 10px;
  background-color: #2683E0;
  color: #fff;
  cursor: pointer;
}

</style>
