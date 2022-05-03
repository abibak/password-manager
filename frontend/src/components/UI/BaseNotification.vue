<template>
  <div class="notification" v-if="show">
    <div class="container-notification">

      <div class="list-errors">
        <div class="error" v-for="(error) in errors">
          <span>{{error[0]}}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapState} from "vuex";

export default {
  name: "BaseNotification",

  props: {
    show: {
      type: Boolean,
      required: true,
      default: false,
    },
  },

  watch: {
    show() {
      if (this.show === true) {
        setTimeout(() => {
          this.$emit('closeBaseNotification');
        }, 6000);
      }
    },
  },

  computed: {
    ...mapState(['errors']),
  },
}
</script>

<style lang="scss" scoped>
.notification {
  width: 280px;
  z-index: 11;
  position: fixed;
  right: 10px;
  top: 10px;

  .container-notification {
    .list-errors {
      color: #fff;

      .error {
        border-radius: 12px;
        padding: 20px;
        background-color: $colorRemove;
        margin-bottom: 20px;
        opacity: .98;
      }
    }
  }
}
</style>
