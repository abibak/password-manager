<template>
  <transition name="animationForm">
    <div class="modal" v-if="show">
      <slot></slot>
    </div>
  </transition>
</template>

<script>
export default {
  name: "BaseModal",

  props: {
    show: {
      type: Boolean,
    }
  },
}
</script>

<style lang="scss" scoped>
.animationForm-enter-active, .animationForm-leave-active {
  transition: all $transTime;
}

.animationForm-enter-from {
  opacity: 0;
}

.animationForm-leave-from {
  opacity: 1;
}

.animationForm-leave-to {
  opacity: 0;
}
</style>
