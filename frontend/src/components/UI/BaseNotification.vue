<template>
  <div class="notification" v-if="show">
    <div class="container-notification">
      <div class="list-messages">
        <div class="message" :class="defineMessageStyle" v-for="(error) in messages.messages">
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
      /*if (this.show === true) {
        setTimeout(() => {
          this.$emit('closeBaseNotification');
        }, 6000);
      }*/
    },
  },

  computed: {
    ...mapState(['messages']),

    defineMessageStyle() {
      switch (this.messages.typeMessage) {
        case 'error':
          return 'error-notification'
        case 'success':
          return 'success-notification'
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.error-notification {
  color: #842029;
  background-color: #f8d7da;
  border-color: #f5c2c7;
}

.success-notification {
  color: #0f5132;
  background-color: #d1e7dd;
  border-color: #badbcc;
}

.notification {
  width: 280px;
  z-index: 11;
  position: fixed;
  right: 10px;
  top: 10px;

  .container-notification {
    .list-messages {
      color: #fff;

      .message {
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
      }
    }
  }
}
</style>
