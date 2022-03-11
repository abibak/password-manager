<template>
  <input :type="typeInput" class="input-login" :value="modelValue" @input="updateValue">
</template>

<script>

export default {
  name: "LoginInput",

  props: {
    modelValue: [String, Number],
    typeInput: {
      type: String,
      required: true,
    }
  },

  methods: {
    updateValue(event) {
      this.$emit('update:modelValue', event.target.value);
    }
  }
}

</script>

<style scoped>

/*.input-login {
  width: auto;
  padding: 10px 0 10px;
  border: none;
  color: #fff;
  border-bottom: 1px solid #fff;
  outline: none;
  line-height: normal;
  background-color: transparent;
}*/

.input-login {
  width: auto;
  padding: 8px 5px;
  color: #000;
  border: 1px solid #fff;
  border-radius: 10px;
  outline: none;
  line-height: normal;
  background-color: #fff;
}

</style>
