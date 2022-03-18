<template>
    <p class="folder">{{this.folder.name}}</p>
</template>

<script>
export default {
  name: "FolderItem",

  props: {
    folder: {
      type: Object,
      required: true,
    }
  },
}
</script>

<style lang="scss" scoped>

.folder {
  word-wrap: break-word;
  margin-top: 8px;
  font-weight: 400;
  cursor: pointer;

  &:hover {
    opacity: .8;
  }
}

</style>
