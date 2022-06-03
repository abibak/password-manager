<template>
  <i :class="clipboardIcon" @click="eventClick"></i>
</template>

<script>
export default {
  name: "BaseClipboard",

  props: {
    value: {
      type: String,
      required: true,
      default: '',
    }
  },

  data() {
    return {
      clipboardIcon: 'bi bi-clipboard',
    }
  },

  methods: {
    eventClick() {
      navigator.clipboard.writeText(this.value).then(() => {
        this.clipboardIcon = 'bi bi-check-lg';

        const timeoutChangeIcon = setTimeout(() => {
          this.clipboardIcon = 'bi bi-clipboard';
          clearTimeout(timeoutChangeIcon);
        }, 1500);
      })
    },
  }
}
</script>

<style scoped>

</style>
