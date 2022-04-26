<template>
  <p class="folder" ref="folder-item" @click="openFolder(this.folder.id)">{{ this.folder.name }}</p>
</template>

<script>
import {mapMutations, mapState} from "vuex";

export default {
  name: "FolderItem",

  props: {
    folder: {
      type: Object,
      required: true,
    },

    typeFolder: {
      type: String,
      required: true,
    }
  },

  computed: {
    ...mapState('folder', ['selectedFolderId', 'selectedOrgFolderId']),
  },

  methods: {
    ...mapMutations(['setShowSectionSelectedFolder']),
    // login namespace
    ...mapMutations('login', ['setShowSelectedLogin', 'setShowHeadLines']),
    // organization namespace
    ...mapMutations('folder', [
      'setSelectedFolderId',
      'setSelectedOrgFolderId',
      'setSelectedOrgLoginId',
      'setSelectedLoginId',
      'setTypeFolder',
    ]),

    openFolder(id) {
      // открыть папку и обновить значения
      if (this.typeFolder === 'orgFolder') {
        this.setSelectedOrgFolderId(id);
        this.setSelectedOrgLoginId(null);
        this.setSelectedFolderId(null);
        this.setTypeFolder(this.typeFolder);
      } else {
        this.setSelectedFolderId(id);
        this.setSelectedLoginId(null);
        this.setSelectedOrgFolderId(null);
        this.setTypeFolder(this.typeFolder);
      }

      this.setShowHeadLines(true);
      this.setShowSelectedLogin(false);
      this.setShowSectionSelectedFolder(true);
    },
  },
}
</script>

<style lang="scss" scoped>
.folder {
  word-wrap: break-word;
  color: #a3a3a3;
  font-weight: 400;
  cursor: pointer;

  &:hover {
    opacity: .8;
  }
}
</style>
