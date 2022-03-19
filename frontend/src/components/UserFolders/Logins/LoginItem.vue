<template>
  <div class="login-item">
    <p><span class="short-name">{{ login.name[0] }}</span>{{ login.name }}</p>
    <p>{{ login.login }}</p>
    <p>{{ login.url }}</p>
    <p>{{ login.tag }}</p>
  </div>
</template>

<script>
export default {
  name: "LoginItem",

  props: {
    login: {
      type: Object,
      required: true,
    }
  }
}
</script>

<style lang="scss" scoped>
.login-item {
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

  &:hover {
    background-color: rgba(163, 163, 163, .080);
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
      margin-right: 8px;
      text-align: center;
      color: #fff;
      border-radius: 6px;
      background-color: $backgroundColor;
    }
  }
}
</style>
