<template>
  <p class="header">Konto</p>
  <div class="profile-section">
    <div class="form-wrapper">
      <div class="row-1">
        <div @click.prevent=test() class="avatar">
          <img :src="props.avatar" id="user-avatar" alt="">
        </div>
        <p @click.prevent="avatarWrapperOpen()" class="wrapper-toggle">Zmień awatar</p>
      </div>
      <div class="row-2">
        <form @submit.prevent=editUser()>
          <p id="register-error" class="error"></p>
          <label for="email-input">Email</label>
          <input
              type="text"
              id="email-input"
              v-model="email"
          />
          <label for="name-input">Imię</label>
          <input
              type="text"
              id="name-input"
              v-model="name"
          />
          <button type="submit" id="submit-btn">Odśwież dane</button>
        </form>
      </div>
    </div>
    <div id="avatar-wrapper" class="avatar-wrapper">
      <div class="row-1">
        <div class="avatar-icon">
          <img @click.prevent="avatarSelect('/_nuxt/assets/images/avatars/giraffe.png')"
               src="@/assets/images/avatars/giraffe.png" alt="">
        </div>
        <div class="avatar-icon">
          <img @click.prevent="avatarSelect('/_nuxt/assets/images/avatars/kitten.png')"
               src="@/assets/images/avatars/kitten.png" alt="">
        </div>
      </div>
      <div class="row-1">
        <div class="avatar-icon">
          <img @click.prevent="avatarSelect('/_nuxt/assets/images/avatars/lion.png')"
               src="@/assets/images/avatars/lion.png" alt="">
        </div>
        <div class="avatar-icon">
          <img @click.prevent="avatarSelect('/_nuxt/assets/images/avatars/mouse.png')"
               src="@/assets/images/avatars/mouse.png" alt="">
        </div>
      </div>
      <div class="row-2">
        <div class="avatar-icon">
          <img @click.prevent="avatarSelect('/_nuxt/assets/images/avatars/puppy.png')"
               src="@/assets/images/avatars/puppy.png" alt="">
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="js">
let props = defineProps({
  avatar: {
    type: String
  },
  email: {
    type: String
  },
  name: {
    type: String,
  },
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
let avatar = ref(props.avatar)
let email = ref(props.email)
let name = ref(props.name)
let uniqId = ref(props.uniqid)
if (props.userPending) {
  document.getElementById('submit-btn').disable = true
}

async function editUser() {
  if (!validateEmail(email.value)) {
    createError(410)
  } else {
    if (!validateName(name.value)) {
      createError(430)
    } else {
      name.value = capitalizeName(name.value)
      const {data: userEditData, error: userEditError} = await useFetch('http://localhost:8000/api/user/edit', {
            method: 'POST',
            body: {
              uniqid: uniqId.value,
              email: email.value,
              name: name.value,
              avatar: avatar.value,
            },
          }
      )
      if (userEditData.value) {
        createError(100)
        console.log('EDIT DATA IS ' + userEditData.value)
        console.log('refresh user')
        await props.refreshUser()
      }
      if (userEditError.value) {
        createError(500)
        console.log('EDIT ERROR IS ' + userEditError.value)
      }
    }
  }

}

function createError(errorCode) {
  const registerError = document.getElementById('register-error')
  switch (errorCode) {
    case 100:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'green'
      registerError.innerText = 'Dane odświeżone'
      break
    case 410:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Nieprawidłowy email'
      break
    case 430:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Nieprawidlowe imię'
      break
    case 500:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Bląd servera lub taki email jest już zarejestrowany'
      break
    default:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Nieznany bład ' + errorCode
      break

  }
}

function avatarSelect(img) {
  let avatarWrapper = document.getElementById('avatar-wrapper')
  let userAvatar = document.getElementById('user-avatar')
  avatarWrapper.style.display = 'none'
  avatar = ref(img)
  userAvatar.src = img
}

function avatarWrapperOpen() {
  let avatarWrapper = document.getElementById('avatar-wrapper')
  avatarWrapper.style.display = 'flex'
}

function capitalizeName(name) {
  return name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
}

function validateEmail(email) {
  let re = /\S+@\S+\.\S+/;
  return re.test(email);
}

function validateName(name) {
  let re = /^[a-zA-Z]+$/
  let length = name.length
  return length >= 3 && length <= 8 && re.test(name)
}

</script>


<style scoped>
.profile-section {
//border: 1px solid red; height: 100%; width: 100%; display: flex;

}

.header {
//border: 1px solid red; margin-bottom: 1rem; font-size: 2rem;
  color: #727272;
}

.profile-section .form-wrapper {
  display: flex;
  flex-direction: column;
  width: 50%;
}

.profile-section .avatar-wrapper {
  border: none;
  width: 50%;
  display: none;
  flex-direction: column;
  padding: 3rem;
}

.profile-section .avatar-wrapper .row-1 {
  display: flex;
  justify-content: space-between;
  margin-bottom: 2.5rem;
}

.profile-section .avatar-wrapper .row-2 {
  display: flex;
  justify-content: center;
  margin-bottom: 3rem;
}

.profile-section .avatar-wrapper .avatar-icon {
//border: 1px solid red; height: 8rem; width: 8rem; border-radius: 50%;
  cursor: pointer;
}

.profile-section .avatar-wrapper .avatar-icon:hover {
  border: 3px solid #6D7BBC;
}

.profile-section .form-wrapper .row-1 {
//border: 1px solid red; width: 100%; height: 8rem; margin-bottom: 3rem;
  display: flex;
  align-items: center;
  color: #727272;
  font-size: 1.3rem;
}

.profile-section .form-wrapper .row-1 .wrapper-toggle {
  cursor: pointer;
}

.profile-section .form-wrapper .row-1 .avatar {
//border: 1px solid red; height: 8rem; width: 8rem; border-radius: 50%;
  margin-right: 1.5rem;
}

.profile-section .form-wrapper .row-2 {
//border: 1px solid red; display: flex; flex: 1; width: 100%;
}

.profile-section .form-wrapper .row-2 form {
//border: 1px solid orange; display: flex; flex-direction: column; width: 100%;
}

.profile-section .form-wrapper .row-2 form .error {
//border: 1px solid red; margin-bottom: 1rem; margin-left: 1rem; color: red;
}

.profile-section .form-wrapper .row-2 form label {
  color: #727272;
  font-size: 0.9rem;
  margin-left: 1rem;
  margin-bottom: 0.5rem;
}

.profile-section .form-wrapper .row-2 input[type = text] {
//border: 1px solid red; width: 100%; height: 3.5rem; background-color: #D6EDFF;
  margin-bottom: 2rem;
  border-radius: 1em;
  padding-left: 1rem;
  padding-right: 1rem;
  color: #6d7bbc;
}

.profile-section .form-wrapper .row-2 input[type = checkbox] {
  display: none;
}

.profile-section .form-wrapper .row-2 input:focus {
  border: 1px solid #6d7bbc;
}

.profile-section .form-wrapper .row-2 form button {
//border: 1px solid red; height: 5rem; margin-top: 4rem; border-radius: 1rem;
  background-color: #8B95C9;
  color: white;
  font-size: 1.1rem;
  transition: 0.25s ease;
}

.profile-section .form-wrapper .row-2 form button:hover {
  background-color: #6D7BBC;
  transition: 0.25s ease;
}

.profile-section .form-wrapper .row-2 form button:disabled {
  background-color: #727272;
}
</style>