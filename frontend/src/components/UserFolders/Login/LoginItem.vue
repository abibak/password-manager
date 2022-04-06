<template>
  <div class="login-item" ref="loginItem" @click="selectLogin" :style="loginItemStyles">
    <p><span class="short-name">{{ login.name[0] }}</span>{{ login.name }}</p>
    <p class="attribute-login" v-if="showAttributes">{{ login.login }}</p>
    <p class="attribute-login" v-if="showAttributes">{{ login.url }}</p>
    <p class="attribute-login" v-if="showAttributes">{{ login.tag }}</p>
  </div>
</template>

<script>
import {mapMutations, mapState} from "vuex";

export default {
  name: "LoginItem",

  props: {
    login: {
      type: Object,
      required: true,
    },

    showAttributes: {
      type: Boolean,
      required: true,
    }
  },

  data() {
    return {
      loginItemStyles: {
        backgroundColor: '',
      }
    }
  },

  computed: {
    ...mapState('userFolder', ['selectedLoginId']),
    ...mapState(['typeFolder']),
  },

  methods: {
    ...mapMutations('userFolder', {
      setSelectedLoginId: 'setSelectedLoginId',
    }),
    ...mapMutations('organizationFolder', {
      setSelectedOrgLoginId: 'setSelectedOrgLoginId',
    }),

    selectLogin() {
      if (this.typeFolder === 'orgFolder') {
        return this.setSelectedOrgLoginId(this.login.id);
      } else {
        this.setSelectedLoginId(this.login.id);
      }

      this.loginItemStyles.backgroundColor = 'rgba(38, 131, 224, .080)';
    },
  },
}
</script>

<style lang="scss" scoped>
.login-item {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 5px 0;
  margin-top: 5px;
  border-radius: 6px;
  color: #a3a3a3;
  font-weight: 400;
  cursor: pointer;
  transition: background-color .18s;

  &:first-child {
    margin-top: 0;
  }

  &:hover {
    background-color: rgba(38, 131, 224, .080);
  }

  .attribute-login {
    transition: opacity $transTime;
  }

  p {
    width: 100%;
  }

  p:first-child {
    display: flex;
    align-items: center;

    .short-name {
      display: inline-block;
      width: 25px;
      height: 25px;
      line-height: 25px;
      padding: 0 5px;
      margin-right: 10px;
      text-transform: uppercase;
      text-align: center;
      color: #fff;
      border-radius: 6px;
      background-color: $backgroundColor;
    }
  }
}
</style>
