<template>
  <div class="favorites-password" v-if="show">
    <div class="container-favorites-password">
      <div class="head">
        <p class="name-action">Избранные пароли</p>
      </div>

      <LoginList :logins="favoritesPassword"></LoginList>
    </div>
  </div>
</template>

<script>
import {mapMutations, mapState} from "vuex";
import LoginList from "@/components/Login/LoginList";

export default {
  name: "FavoritesPassword",
  components: {LoginList},

  props: {
    show: {
      type: Boolean,
      required: true,
      default: false,
    }
  },

  computed: {
    ...mapState('login', ['favoritesPassword']),
  },

  methods: {
    ...mapMutations('folder', ['showSectionSelectedFolder']),
  }
}
</script>

<style lang="scss" scoped>
  .favorites-password {
    .container-favorites-password {
      .head {
        padding: 25px 20px;
        border-bottom: 1px solid $color;

        p {
          font-size: 24px;
        }
      }
    }
  }
</style>
