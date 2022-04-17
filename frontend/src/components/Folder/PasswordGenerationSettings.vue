<template>
  <div class="password-generation">
    <div class="container-generation">
      <BaseCloseModal @click="closeGeneration"></BaseCloseModal>

      <p class="name-action">Генератор пароля</p>

      <div class="generated-password">
        <BaseInput v-model="generatedPassword" @input="calculateBits" disabled></BaseInput>
        <i class="bi bi-clipboard"></i>
      </div>

      <div class="size-password">
        <div class="info-length">
          <label for="lengthPassword">Длина пароля:</label>
          <input type="text" id="lengthPassword" v-model="size" @input="change">
        </div>

        <input type="range" min="6" max="60" step="2" v-model="size" @change="change">
      </div>

      <div class="list-toggle">
        <div class="block-toggle">
          <BaseToggle @click="settingsGenerator.specialSymbols = !settingsGenerator.specialSymbols"
                      v-model:active="settingsGenerator.specialSymbols"></BaseToggle>
          <span>Специальные символы</span>
        </div>

        <div class="block-toggle">
          <BaseToggle @click="settingsGenerator.numbers = !settingsGenerator.numbers"
                      :active="settingsGenerator.numbers"></BaseToggle>
          <span>Числа</span>
        </div>

        <div class="block-toggle">
          <BaseToggle @click="settingsGenerator.upperCase = !settingsGenerator.upperCase"
                      :active="settingsGenerator.upperCase"></BaseToggle>
          <span>Прописные буквы</span>
        </div>

        <div class="block-toggle">
          <BaseToggle @click="settingsGenerator.lowerCase = !settingsGenerator.lowerCase"
                      :active="settingsGenerator.lowerCase"></BaseToggle>
          <span>Строчные буквы</span>
        </div>
      </div>

      <div class="actions">
        <span @click="generate">Сгенерировать</span>
        <BaseButton @click="sendPassword" v-model:disabled="activeBtn">Создать пароль</BaseButton>
      </div>
    </div>
  </div>
</template>

<script>
import BaseToggle from "@/components/UI/BaseToggle";

export default {
  name: "PasswordGenerationSettings",

  components: {
    BaseToggle,
  },

  data() {
    return {
      size: 16,
      generatedPassword: '',

      settingsGenerator: {
        specialSymbols: true,
        numbers: true,
        upperCase: true,
        lowerCase: true,
        characterSetLength: 0,
      },

      activeBtn: false,
    }
  },

  created() {
    this.generate();
  },

  watch: {
    specialSymbols() {
      this.generate();
    },

    numbers() {
      this.generate();
    },

    upperCase() {
      this.generate();
    },

    lowerCase() {
      this.generate();
    },
  },

  computed: {
    specialSymbols() {
      return this.settingsGenerator.specialSymbols;
    },

    numbers() {
      return this.settingsGenerator.numbers;
    },

    upperCase() {
      return this.settingsGenerator.upperCase;
    },

    lowerCase() {
      return this.settingsGenerator.lowerCase;
    },

    getParameterResult() {
      return [this.specialSymbols, this.numbers, this.upperCase, this.lowerCase];
    },
  },

  methods: {
    change() {
      if (this.size > 60) {
        this.size = 60;
      }

      this.generate();
    },

    generate() {
      let characterSet = '',
        password = '';

      let lengthSettings = this.getParameterResult.length,
        countFalse = 0;

      for (const value of this.getParameterResult) {
        if (value === false) {
          countFalse++;
        }
      }

      this.activeBtn = lengthSettings === countFalse;

      if (this.specialSymbols) {
        characterSet += '!,.[]{}()%?&*$#^<>~@|';
      }

      if (this.numbers) {
        characterSet += '0123456789';
      }

      if (this.upperCase) {
        characterSet += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      }

      if (this.lowerCase) {
        characterSet += 'abcdefghijklmnopqrstuvwxyz';
      }

      for (let i = 0; i < this.size; i++) {
        password += characterSet.charAt(Math.floor(Math.random() * characterSet.length));
      }

      this.generatedPassword = password;
      this.settingsGenerator.characterSetLength = characterSet.length;
    },

    sendPassword() {
      console.log('test');
      if (this.generatedPassword !== '') {
        this.$emit('getPassword', this.generatedPassword);
        this.closeGeneration();
      }
    },

    calculateBits() {
      //Math.log(this.characterSetLength) * (this.generatedPassword.length / Math.log(2));
    },

    closeGeneration() {
      this.$emit('closeGeneration');
    }
  },
}
</script>

<style lang="scss" scoped>
.password-generation {
  width: 370px;
  background-color: #fff;
  color: #000;
  border-radius: 10px;
  position: relative;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  .container-generation {
    width: 100%;
    padding: 20px;
    font-size: 16px;

    .name-action {
      font-size: 22px;
    }

    .generated-password {
      position: relative;

      .bi-clipboard {
        font-size: 18px;
        position: absolute;
        right: 5px;
        bottom: 7px;
        cursor: pointer;
      }
    }

    .base-input, .size-password {
      .info-length {
        display: flex;
        align-items: center;
        margin-bottom: 15px;

        input {
          display: inline-block;
          width: 24px;
          margin-left: 5px;
          border: none;
          text-align: center;
          border-bottom: 1px solid $baseColor;
          outline: none;
        }
      }
    }

    .base-input, .size-password input {
      width: 100%;
    }

    .base-input {
      height: 34px;
      margin: 15px 0;
      padding: 0 23px 0 10px;
      border-radius: 8px;
      border: 1px solid $baseColor;

      &:focus {
        box-shadow: 0 0 0 2px rgba(38, 131, 224, .7);
      }
    }

    .list-toggle {
      margin-top: 15px;

      .block-toggle {
        display: flex;
        margin-top: 10px;

        span {
          margin-left: 10px;
        }
      }
    }

    .actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 15px;

      span:first-child {
        color: $baseColor;
        font-weight: 400;
        cursor: pointer;
      }
    }
  }
}
</style>
