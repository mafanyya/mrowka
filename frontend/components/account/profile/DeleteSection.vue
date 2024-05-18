<template>
  <p class="header">Usuń konto</p>
  <div class="delete-section">
    <p class="header-2">Uwaga!</p>
    <p class="header-3">Jeśli usuniesz swoje konto, wszystkie Twoje postępy zostaną całkowicie usunięte,
      a użytkownik utraci dostęp do platformy na zawsze.</p>
    <p class="header-4">Nie można anulować tej akcji.</p>
    <form @submit.prevent=deleteUser()>
      <label for="psw-input">Wprowadź hasło</label>
      <p id="psw-error" class="error-label"></p>
      <input
          type="password"
          id="pws-input"
          v-model="password"
      >
      <button type="submit" id="delete-btn" class="delete-btn">Usuń konto</button>
    </form>
  </div>
</template>

<script setup lang="js">
let password = ref('')
let props = defineProps({
  uniqid: {
    type: String,
  }
})

async function passwordCheck() {
  const {data: pswCheckData, error: pswCheckError} = await useFetch('http://localhost:8000/api/user/psw-check', {
        method: 'POST',
        body: {
          uniqid: props.uniqid,
          password: password.value
        },
      }
  )
  return pswCheckData.value.isPswValid
}

async function deleteUser() {
  if (!await passwordCheck()) {
    createError(400)
  } else {
    const {data: deleteUserData, error: deleteUserError} = await useFetch('http://localhost:8000/api/user/delete', {
          method: 'POST',
          body: {
            uniqid: props.uniqid
          }
        }
    )
    if (deleteUserData.value) {
      console.log('User successfully deleted')
      console.log(deleteUserData)
      createError(100)

      function navigate() {
        navigateTo('/dashboard/users')
      }

      setTimeout(navigate, 3000)
    }
    if (deleteUserError.value) {
      console.log('User delete error is ')
      console.log(deleteUserError)
      createError(500)
    }
  }
}

function createError(errorCode) {
  const registerError = document.getElementById('psw-error')
  switch (errorCode) {
    case 100:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'green'
      registerError.innerText = 'Konto zostało pomyślnie usunięte'
      break
    case 400:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Hasło jest nieprawidłowe'
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
      break
  }
}
</script>

<style scoped>
.header {
//border: 1px solid red; margin-bottom: 1rem; font-size: 2rem;
  color: #727272;
}

.delete-section {
//border: 1px solid red; height: 100%; width: 90%;
  display: flex;
  flex-direction: column;
}

.delete-section .header-2 {
  font-size: 1.8rem;
  margin-top: 1rem;
  color: #DE7C7C;
}

.delete-section .header-3 {
  font-size: 1.1rem;
  margin-top: 1.5rem;
  line-height: 1.5rem;
  color: #727272;
}

.delete-section .header-4 {
  font-size: 1.1rem;
  margin-top: 1rem;
  margin-bottom: 1.5rem;
  color: #727272;
}

.delete-section form {
  width: 50%;
}

.delete-section form input {
  height: 3.5rem;
  background-color: #ffc3c3;
  margin-bottom: 3rem;
  border-radius: 1em;
  padding-left: 1rem;
  padding-right: 1rem;
  color: #DE7C7C;
  margin-top: 0.5rem;
}

.delete-section form label {
  color: #DE7C7C;
  font-size: 0.9rem;
  margin-left: 1rem;
}

.delete-section form .delete-btn {
//border: 1px solid red; width: 50%; height: 4.5rem;
  border-radius: 1rem;
  background-color: #DE7C7C;
  color: white;
  transition: 0.25s ease;
}

.delete-section form .delete-btn:hover {
  background-color: #d15656;
  transition: 0.25s ease;
}

.delete-section form .error-label {
  color: #d15656;
  font-size: 0.9rem;
  margin-left: 1rem;
}
</style>