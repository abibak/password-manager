<template>
  <div class="user-notifications" v-show="show">
    <div class="container-user-notifications">
      <p class="name-action">Уведомления</p>

      <div class="list-notifications">
        <div class="notification" v-for="(notification) of dataNotifications">
          <p class="notification-text">{{ notification.notification_text }}</p>
          <p class="notification-date">{{ notification.created_at }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {instance} from "@/store";

export default {
  name: "BasicUserNotifications",

  props: {
    show: {
      type: Boolean,
      required: true,
      default: false,
    },
  },

  data() {
    return {
      dataNotifications: null,
    }
  },

  created() {
    this.getNotifications();

    setInterval(() => {
      this.getNotifications();
      console.log('update notifications')
    }, 120000); // 300 000 ms = 5 minutes
  },

  methods: {
    async getNotifications() {
      instance.get(process.env.VUE_APP_API_URL + 'user/notifications').then(response => {
        this.dataNotifications = response.data.data;
      })
    },
  },
}
</script>

<style lang="scss" scoped>

.user-notifications {
  @include scrollbar(.30em, $color, #d5d5d5);

  width: 430px;
  max-height: 486px;
  background-color: #fff;
  color: #000;
  box-shadow: 0 0 6px 1px #a3a3a3;
  border-radius: 10px;
  z-index: 2;
  overflow-y: scroll;
  position: absolute;
  right: 0;

  .container-user-notifications {
    padding: 30px;
    user-select: none;

    .list-notifications {
      font-weight: 400;

      .notification {
        padding: 18px 0;
        border-bottom: 1px solid $color;
        position: relative;

        &:last-child {
          border-bottom: transparent;
          padding-bottom: 0;
        }

        .notification-text {
          padding-bottom: 8px;
        }

        .notification-date {
          font-weight: 500;
          font-size: 16px;
        }
      }
    }
  }
}

</style>
