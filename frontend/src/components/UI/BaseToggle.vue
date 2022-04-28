<template>
  <div class="toggle" @click="onClick" :style="{backgroundColor: backgroundColor}">
    <div class="specialSymbols btn-toggle" :style="{right: right + 'px'}"></div>
  </div>
</template>

<script>
export default {
  name: "BaseToggle",

  props: {
    active: {
      type: Boolean,
      default: true,
    }
  },

  data() {
    return {
      right: '0',
      backgroundColor: '',
      position: '',
    }
  },

  created() {
    this.move();

    if (this.active) {
      this.right = 18;
    } else {
      this.right = 0;
    }
  },

  methods: {
    onClick() {
      this.move();
    },

    move() {
      let intervalMove = setInterval(() => {
        if (this.active) {
          this.backgroundColor = 'rgba(38, 131, 224, 1)';
          this.right--;
        } else {
          this.backgroundColor = '#db1f1f'
          this.right++;
        }

        if (this.right === 0 || this.right === 18) {
          clearInterval(intervalMove);
        }
      }, 5);
    }
  }
}
</script>

<style lang="scss" scoped>
.toggle {
  width: 38px;
  height: 22px;
  border-radius: 10px;
  cursor: pointer;
  position: relative;
  background-color: $baseColor;
  transition: all .3s;

  .btn-toggle {
    width: 16px;
    height: 16px;
    margin: 0 2px;
    border-radius: 50%;
    background-color: #fff;
    position: absolute;
    top: 3px;
  }
}
</style>
