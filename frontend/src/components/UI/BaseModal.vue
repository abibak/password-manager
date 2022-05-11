<template>
  <transition name="animationForm">
    <div class="modal-shadow" v-if="show" @click.stop="this.$emit('closeModal')">
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

  created() {
    window.addEventListener('keydown', (e) => {
      if (e.key == 'Escape') {
        this.$emit('closeModal');
      }
    });
  },
}
</script>

<style lang="scss" scoped>
.modal-shadow {
  width: 100%;
  height: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 11;
  background: rgba(0, 0, 0, .39);

  .modal {
    width: 100%;
    height: 100%;
    position: fixed;
  }
}

.animationForm-enter-active,
.animationForm-leave-active {
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
