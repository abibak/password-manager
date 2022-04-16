<template>
  <transition name="animationForm">
    <div class="modal-shadow" v-if="show">
      <div class="modal">
        <slot></slot>
      </div>
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
.modal {
  width: 100%;
  height: 100%;
  position: fixed;
}

.modal-shadow {
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
  background: rgba(0, 0, 0, .39);
}

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
