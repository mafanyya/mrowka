<template>
  <p class="header">Zmień hasło</p>
  <div class="security-section">
    <div class="form-wrapper">
      <form @submit.prevent=upgradePassword()>
        <p id="upgrade-error" class="error"></p>
        <label for="old-psw-input">Aktualne hasło</label>
        <input
            type="password"
            id="old-psw-input"
            v-model="oldPassword"
        />
        <label for="new-psw-input">Nowe hasło</label>
        <label id="psw-label-error" class="psw-label-error">Hasło musi zawierać co najmniej 8 znaków</label>
        <input
            type="password"
            id="new-psw-input"
            v-model="newPassword"
        />
        <ProgressBar
            :progress=progressBarValidate(newPassword)
        />
        <label for="repeat-psw">Potwierdź nowe hasło</label>
        <input
            type="password"
            id="repeat-psw"
            v-model="repeatPassword"
        />
        <button :disabled="upgradePending" type="submit" id="submit-btn">Odśwież hasło</button>
      </form>
    </div>
  </div>
</template>

<script setup lang="js">
import ProgressBar from "~/components/account/profile/ProgressBar.vue";
import {onMounted} from "vue";

let props = defineProps({
  uniqid: {
    type: String,
  },
  refreshUser: {
    type: Function
  },
  userPending: {
    type: Boolean
  }
})
let upgradePending
let oldPassword = ref('')
let newPassword = ref('')
let repeatPassword = ref('')
let uniqId = ref(props.uniqid)

if (props.userPending) {
  document.getElementById('submit-btn').disable = true
}

async function passwordCheck() {
  const {data: pswCheckData, error: pswCheckError} = await useFetch('http://localhost:8000/api/user/psw-check', {
        method: 'POST',
        body: {
          uniqid: uniqId.value,
          password: oldPassword.value
        },
      }
  )
  return pswCheckData.value.isPswValid
}

async function upgradePassword() {
  if (!await passwordCheck(oldPassword)) {
    createError(410)
  } else {
    if (!validatePassword(newPassword.value)) {
      createError(420)
    } else {
      if (!checkRepeatPassword(newPassword.value, repeatPassword.value)) {
        createError(430)
      } else {
        const {
          data: pswUpgradeData,
          error: pswUpgradeError,
          pending: pswUpgradePending
        } = await useFetch('http://localhost:8000/api/user/psw-upgrade', {
              method: 'POST',
              body: {
                uniqid: uniqId.value,
                password: newPassword.value
              },
            }
        )
        upgradePending = pswUpgradePending
        if (pswUpgradeData.value) {
          createError(100)
        }
        if (pswUpgradeError.value) {
          createError(500)
        }
      }
    }

  }
}

function checkRepeatPassword(newPassword, repeatPassword) {
  console.log('NEW PASSWORD IS ' + newPassword + 'REPEAT PASSWORD IS ' + repeatPassword)
  return newPassword === repeatPassword;

}

watch(() => newPassword.value, (newValue) => {
  progressBarValidate(newValue)
  passwordLengthCheck(newValue)
  console.log(newValue)
})

function passwordLengthCheck(password) {
  let passwordInput = document.getElementById('new-psw-input')
  let passwordLabel = document.getElementById('psw-label-error')
  if (password.length < 8) {
    passwordInput.style.border = '1px solid #DE7C7C'
    passwordLabel.style.display = 'block'
  } else {
    passwordInput.style.border = 'none'
    passwordLabel.style.display = 'none'
  }

}

function progressBarValidate(password) {
  let progress = 0

  if (/[A-Z]/.test(password)) {
    progress = progress + 25
  }
  if (/\d/.test(password)) {
    progress = progress + 25
  }
  if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
    progress = progress + 25
  }
  if (password.length >= 8) {
    progress = progress + 25
  }
  if (password.length < 8 && progress > 75) {
    progress = 75
  }
  return progress
}

function validatePassword(password) {
  let length = password.length
  let hasLetter = /[A-Z]/.test(password);
  let hasDigit = /\d/.test(password);
  let hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);

  return length >= 8 && length < 50 && hasLetter && hasDigit && hasSymbol;
}

function createError(errorCode) {
  const registerError = document.getElementById('upgrade-error')
  switch (errorCode) {
    case 100:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'green'
      registerError.innerText = 'Hasło odświeżone'
      break
    case 410:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Stare hasło jest nieprawidłowe'
      break
    case 420:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Nowe hasło nie spełnia wymagań'
      break
    case 430:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Potwierdzenie hasła nie zgadza się'
      break
    case 500:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Bląd servera'
      break
    default:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Nieznany bład ' + errorCode

  }
}

</script>

<style scoped>
.header {
//border: 1px solid red; margin-bottom: 1rem; font-size: 2rem;
  color: #727272;
}

.security-section {
//border: 1px solid red; height: 100%; width: 100%; display: flex;
}

.security-section .form-wrapper {
  display: flex;
  flex-direction: column;
  width: 50%;
}


.security-section .form-wrapper form {
//border: 1px solid orange; display: flex; flex-direction: column; width: 100%;
}

.security-section .form-wrapper form .error {
//border: 1px solid red; margin-bottom: 1rem; margin-left: 1rem; color: #DE7C7C;
}

.security-section .form-wrapper form label {
  color: #727272;
  font-size: 0.9rem;
  margin-left: 1rem;
  margin-bottom: 0.5rem;
}

.security-section .form-wrapper input[type = password] {
//border: 1px solid red; width: 100%; height: 3.5rem; background-color: #D6EDFF;
  margin-bottom: 2rem;
  border-radius: 1em;
  padding-left: 1rem;
  padding-right: 1rem;
  color: #6d7bbc;
}

.security-section .form-wrapper input[type = checkbox] {
  display: none;
}

.security-section .form-wrapper input:focus {
  border: 1px solid #6d7bbc;
}

.security-section .form-wrapper form button {
//border: 1px solid red; height: 5rem; margin-top: 4rem; border-radius: 1rem;
  background-color: #8B95C9;
  color: white;
  font-size: 1.1rem;
  transition: 0.25s ease;
}

.security-section .form-wrapper form .psw-label-error {
  color: #DE7C7C;
  display: none;
}

.security-section .form-wrapper form button:hover {
  background-color: #6D7BBC;
  transition: 0.25s ease;
}

.security-section .form-wrapper form button:disabled {
  background-color: #727272;
}
</style>