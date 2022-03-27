<template>
  <p class="folder" @click="openFolder(this.folder.id)">{{ this.folder.name }}</p>
</template>

<script>
import {mapMutations} from "vuex";

export default {
  name: "FolderItem",

  props: {
    folder: {
      type: Object,
      required: true,
    }
  },

  methods: {
    ...mapMutations('userFolderData', {
      setShowSectionSelectedFolder: 'setShowSectionSelectedFolder',
      setSelectedFolderId: 'setSelectedFolderId',
    }),

    openFolder(id) {
      this.setSelectedFolderId(id);
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
