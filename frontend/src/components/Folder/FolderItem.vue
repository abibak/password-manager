<template>
  <p class="folder" @click="openFolder(this.folder.id)">{{ this.folder.name }}</p>
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
    ...mapMutations({
      setShowSectionSelectedFolder: 'setShowSectionSelectedFolder',
    }),
    ...mapMutations('folder', {
      setSelectedFolderId: 'setSelectedFolderId',
      setSelectedOrgFolderId: 'setSelectedOrgFolderId',
      setTypeFolder: 'setTypeFolder',
    }),

    openFolder(id) {
      if (this.typeFolder === 'orgFolder') {
        this.setSelectedOrgFolderId(id);
        this.setSelectedFolderId(null);
        this.setTypeFolder(this.typeFolder);
      } else {
        this.setSelectedFolderId(id);
        this.setSelectedOrgFolderId(null);
        this.setTypeFolder(this.typeFolder);
      }

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
