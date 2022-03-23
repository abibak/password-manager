<template>
  <div class="settings-folder" v-if="show">
    <div class="container-settings">
      <p>Настройки папки</p>

      <div class="list-settings">
        <div class="action">
          <i class="bi bi-pencil-square"></i>
          <span @click="setShowModalRenameFolder(true)">Переименовать</span>
        </div>

        <div class="action">
          <i class="bi bi-trash3"></i>
          <span class="delete-folder" @click="setShowModalConfirmDelete(true)">Удалить</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapMutations} from "vuex";

export default {
  name: "SettingsFolder",

  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },

  methods: {
    ...mapMutations('userFolderData', {
      setShowModalConfirmDelete: 'setShowModalConfirmDelete',
      setShowModalRenameFolder: 'setShowModalRenameFolder',
    }),
  }
}
</script>

<style lang="scss" scoped>
.settings-folder {
  background-color: #fff;
  color: #000;
  box-shadow: 0 0 6px 1px #a3a3a3;
  border-radius: 10px;
  position: absolute;
  top: 40px;
  right: 0;

  .container-settings {
    padding: 15px;

    p:first-child {
      white-space: nowrap;
      font-size: 20px;
    }

    .list-settings {
      margin-top: 8px;

      .action {
        display: flex;
        align-items: center;
        margin-top: 5px;
        font-size: 16px;

        &:first-child {
          margin-top: 0;
        }

        &:hover span {
          color: #a3a3a3;
        }

        &:hover:last-child span {
          color: #DB1F1F;
          opacity: .6;
        }

        .delete-folder {
          color: #DB1F1F;
        }

        i {
          padding-right: 10px;
          font-size: 24px;
        }
      }
    }
  }
}
</style>
