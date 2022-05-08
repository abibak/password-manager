<template>
  <transition name="animation-settings-folder">
    <div class="settings-folder" v-if="show">
      <div class="container-settings">
        <p>Настройки папки</p>

        <div class="list-settings">
          <div class="action" @click.stop="setShowModalRenameFolder(true)">
            <i class="bi bi-pencil-square"></i>
            <span>Переименовать</span>
          </div>

          <div class="action" @click.stop="setShowModalConfirmDelete(true)">
            <i class="bi bi-trash3"></i>
            <span class="delete-folder">Удалить</span>
          </div>
        </div>
      </div>
    </div>
  </transition>
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
    ...mapMutations({
      setShowModalConfirmDelete: 'setShowModalConfirmDelete',
      setShowModalRenameFolder: 'setShowModalRenameFolder',
    }),
  }
}
</script>

<style lang="scss" scoped>
.animation-settings-folder-enter-active, .animation-settings-folder-leave-active {
  opacity: 0;
  transition: all $transTime;
}

.animation-settings-folder-enter-from {
  transform: scale(.95);
}

.animation-settings-folder-enter-to {
  opacity: 1;
  transform: scale(1);
}

.animation-settings-folder-leave-to {
  opacity: 0;
  transform: scale(.95);
}

.settings-folder {
  background-color: #fff;
  color: #000;
  z-index: 2;
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
