<template>
  <div class="selected-folder-section">
    <div class="container-folder-section">
      <div class="header-info-folder">
        <p class="name-folder">{{this.getLogins[0].name}}</p>

        <div class="unit-folder-control">
          <div class="icon-control">
            <i class="bi bi-three-dots"></i>
          </div>

          <BaseButton>Добавить пароль</BaseButton>
        </div>
      </div>

      <LoginList :folder-data="this.getLogins"></LoginList>
    </div>
  </div>
</template>

<script>
import BaseButton from "@/components/UI/BaseButton";
import LoginList from "@/components/UserFolders/Logins/LoginList";
import {mapActions, mapGetters, mapState} from "vuex";

export default {
  name: "SelectedFolderSection",
  components: {BaseButton, LoginList},

  created() {
    this.sendRequestGetLogins(this.selectedFolderId);
  },

  computed: {
    ...mapState('userFolderData', ['logins', 'selectedFolderId']),
    ...mapGetters('userFolderData', ['getLogins']),
  },

  data() {
    return {
      ...mapActions({
        sendRequestGetLogins: 'userFolderData/sendRequestGetLogins',
      })
    }
  },
}
</script>

<style lang="scss" scoped>
.selected-folder-section {
  .name-folder {
    font-size: 24px;
    color: #000;
  }

  .header-info-folder {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px 20px;
    border-bottom: 1px solid $color;

    .unit-folder-control {
      display: flex;
      justify-content: center;
      align-items: center;

      .icon-control {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 36px;
        height: 36px;
        margin-right: 10px;
        border-radius: 50%;
        border: 1px solid #2683e0;
        cursor: pointer;
      }

      .bi-three-dots {
        font-size: 23px;
        color: #2683e0;
      }
    }
  }
}
</style>
