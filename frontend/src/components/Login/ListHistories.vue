<template>
<div class="password-histories" v-show="show">
  <div class="container-password-histories">

    <div class="attributes">
      <span>Дата</span>
      <span>Пользователь</span>
      <span>Действие</span>
    </div>

    <div class="list-history">
      <div class="item-history" v-for="item of history" :key="item">
        <span>{{ item.date }}</span>
        <span>{{ item.login }}</span>
        <span>{{ item.action_text }}</span>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: "ListHistories",

  props: {
    history: {
      type: Array,
      required: true,
      default: [],
    },

    show: {
      type: Boolean,
      required: true,
      default: false,
    }
  },
}
</script>

<style lang="scss" scoped>
.password-histories {
  width: 75%;

  .container-password-histories {
    @include scrollbar(.30em, $color, #d5d5d5);
    max-width: 100%;
    height: 560px;
    padding: 15px 10px 0 0;
    overflow-y: scroll;

    .attributes {
      display: flex;
      justify-content: space-between;
      color: #000;

      span {
        width: 75%;

        &:last-child {
          text-align: right;
        }
      }
    }

    .list-history {
      font-size: 16px;
      font-weight: 400;
      color: #000;

      .item-history {
        display: flex;
        justify-content: space-between;
        padding-top: 10px;

        span {
          width: 75%;

          &:last-child {
            text-align: right;
          }
        }
      }
    }
  }
}
</style>
