<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="clm-1">
          <div id="form-header" class="row-1">
            <p>Dodaj użytkownika</p>
          </div>
          <div id="form-wrapper" class="form-wrapper">
            <p class="header">Informacja ogólna</p>
            <p id="register-error" class="register-error"></p>
            <form id="add-form" @submit.prevent="addUser()">
              <input
                  v-model="email"
                  type="text"
                  placeholder="Email"
              />
              <div class="psw-input">
                <input
                    v-model="password"
                    type="password"
                    placeholder="Hasło"
                    id="psw-input"
                />
                <div class="input-2">
                  <input type="checkbox" id="psw-visibility">
                  <label for="psw-visibility" id="psw-visible" @click.prevent="changePswVisibility()"><img
                      src="~/assets/images/icons/visibility-off.svg" alt=""></label>
                  <label for="psw-visibility" id="psw-hidden" @click.prevent="changePswVisibility()"><img
                      src="~/assets/images/icons/visibility-on.svg" alt=""></label>
                </div>
              </div>
              <input
                  v-model="name"
                  type="text"
                  placeholder="Imię"
              />
              <div class="is-admin-check">
                <p>Czy administrator?</p>
                <label for="isAdmin" id="check-box" class="check-box">
                  <span id="check-box-btn" class=check-box-btn @click.prevent="checkBoxMove">
                  </span>
                </label>
                <input
                    v-model="isAdmin"
                    type="checkbox"
                    id="isAdmin"
                />
              </div>
              <button type="submit" class="submit-btn">Dodaj użytkownika</button>
            </form>
          </div>
          <div id="success-wrapper" class="success-wrapper">
            <p>Użytkownik {{ name.value }} pomyślnie zarejestrowany</p>
            <div class="row">
              <button @click.prevent="toForm()">Dodaj jeszcze</button>
              <NuxtLink to="/dashboard/users">
                <p class="btn-2">Wróc do listy</p>
              </NuxtLink>
            </div>
          </div>
        </div>
        <div class="clm-2">
          <div class="section-1" id="avatar-1">
            <div class="inner">
              <img id="avatar-img" :src="avatar" alt="">
            </div>
          </div>
          <p @click.prevent="sectionVisibilityChange()" id="avatar-btn" class="section-1-2">Zmień awatar</p>
          <div id="avatar-2" class="section-2-1">
            <div @click.prevent="selectAvatar(avatar.img)" class="avatar-section" v-for="avatar in avatars">
              <img :src="avatar.img" alt="">
            </div>
          </div>
          <p id="avatar-2-2" class="section-2-2">Wybierz awatar</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (!data.value) {
        return navigateTo('/')
      }
      if (data.value.user.isAdmin !== true){
        return navigateTo('/')
      }
    }
  ]
})

const email = ref('')
const password = ref('')
const name = ref('')
let avatar = ref('/_nuxt/assets/images/avatars/lion.png')
let roles = ref('')
let isAdmin = ref('')
const avatars = ref([
  {img: '/_nuxt/assets/images/avatars/giraffe.png'},
  {img: '/_nuxt/assets/images/avatars/kitten.png'},
  {img: '/_nuxt/assets/images/avatars/lion.png'},
  {img: '/_nuxt/assets/images/avatars/mouse.png'},
  {img: '/_nuxt/assets/images/avatars/puppy.png'}
])

function checkIsAdmin() {
  let isAdminCheckBox = document.getElementById('isAdmin')
  let status = isAdminCheckBox.checked
  if (status) {
    roles = ref(["ROLE_ADMIN", "ROLE_USER"])
    isAdmin = ref(true)
  } else {
    roles = ref(["ROLE_USER"])
    isAdmin = ref(false)
  }
}

async function addUser() {
  checkIsAdmin()
  if (!validateEmail(email.value)) {
    createError(410)
  } else {
    if (!validatePassword(password.value)) {
      createError(420)
    } else {
      if (!validateName(name.value)) {
        createError(430)
      } else {
        name.value = capitalizeName(name.value)
        console.log('Name is ' + name.value)
        const {data: userData, error: userError} = await useFetch('http://localhost:8000/api/register', {
              method: 'POST',
              body: {
                email: email.value,
                password: password.value,
                roles: roles.value,
                name: name.value,
                avatar: avatar.value,
                isAdmin: isAdmin.value,
                status: false
              },
            }
        )
        if (userData.value) {
          console.log('USER DATA IS')
          const formWrapper = document.getElementById('form-wrapper')
          const formHeader = document.getElementById('form-header')
          const avatarBtn = document.getElementById('avatar-btn')
          const successWrapper = document.getElementById('success-wrapper')

          formWrapper.style.display = 'none'
          formHeader.style.display = 'none'
          avatarBtn.style.display = 'none'
          successWrapper.style.display = 'flex'
        }
        if (userError.value) {
          console.log('USER ERROR IS ')
          console.log(userError.value)
          createError(500)
        }
      }
    }
  }
}

function createError(errorCode) {
  const registerError = document.getElementById('register-error')
  switch (errorCode) {
    case 100:
      registerError.style.visibility = 'visible'
      registerError.innerText = 'Registration successful'
      break
    case 410:
      registerError.style.visibility = 'visible'
      registerError.innerText = 'Nieprawidłowa poczta'
      break
    case 420:
      registerError.style.visibility = 'visible'
      registerError.innerText = 'Hasło musi zawierać co najmniej 8 znaków,  tym jedną cyfrę (0-9), jedną wielką literę (A-Z), jedną małą literę (a-z) oraz jeden znak specjalny (!@#$%^&*) '
      break
    case 430:
      registerError.style.visibility = 'visible'
      registerError.innerText = 'Nieprawidlowe imię'
      break
    case 500:
      registerError.style.visibility = 'visible'
      registerError.innerText = 'Bląd servera'
      break
    default:
      registerError.style.visibility = 'visible'
      registerError.innerText = 'Nieznany bład ' + errorCode
      break
  }
}

function toForm() {
  const formWrapper = document.getElementById('form-wrapper')
  const formHeader = document.getElementById('form-header')
  const avatarBtn = document.getElementById('avatar-btn')
  const successWrapper = document.getElementById('success-wrapper')
  const addForm = document.getElementById('add-form')
  addForm.reset()
  formWrapper.style.display = 'flex'
  formHeader.style.display = 'flex'
  avatarBtn.style.display = 'flex'
  successWrapper.style.display = 'none'
}

function capitalizeName(name) {
  return name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
}

function validateEmail(email) {
  let re = /\S+@\S+\.\S+/;
  return re.test(email);
}

function validatePassword(password) {
  let length = password.length
  let hasLetter = /[A-Z]/.test(password);
  let hasDigit = /\d/.test(password);
  let hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
  return length >= 8 && length < 50 && hasLetter && hasDigit && hasSymbol;
}

function validateName(name) {
  let re = /^[a-zA-Z]+$/
  let length = name.length
  return length >= 3 && length <= 8 && re.test(name)
}

function checkBoxMove() {
  let elem = document.getElementById('check-box')
  let btn = document.getElementById('check-box-btn')
  let checkBox = document.getElementById('isAdmin')
  let position = elem.style.justifyContent
  if (position === 'start') {
    elem.style.justifyContent = 'end'
    checkBox.checked = true
    elem.style.backgroundColor = '#8B95C9'
    btn.style.backgroundColor = '#D6EDFF'
  } else {
    elem.style.justifyContent = 'start'
    checkBox.checked = false
    elem.style.backgroundColor = '#D6EDFF'
    btn.style.backgroundColor = '#8B95C9'
  }
}

function sectionVisibilityChange() {
  let section1 = document.getElementById('avatar-1')
  let section1Btn = document.getElementById('avatar-btn')
  let section2 = document.getElementById('avatar-2')
  let section22 = document.getElementById('avatar-2-2')
  section1.style.display = 'none'
  section1Btn.style.display = 'none'
  section2.style.display = 'flex'
  section22.style.display = 'block'
}

function selectAvatar(img) {
  let section1 = document.getElementById('avatar-1')
  let section12 = document.getElementById('avatar-btn')
  let section2 = document.getElementById('avatar-2')
  let avatarImg = document.getElementById('avatar-img')
  let section22 = document.getElementById('avatar-2-2')
  avatarImg.src = img
  section2.style.display = 'none'
  section22.style.display = 'none'
  section1.style.display = 'flex'
  section12.style.display = 'block'
  setAvatar(img)
}

function setAvatar(img) {
  avatar = ref(img)
  return avatar
}

function changePswVisibility() {
  const checkBox = document.getElementById('psw-visibility')
  const visibleIcon = document.getElementById('psw-visible')
  const hiddenIcon = document.getElementById('psw-hidden')
  const input = document.getElementById('psw-input')
  checkBox.checked = checkBox.checked === false;
  if (checkBox.checked === true) {
    hiddenIcon.style.display = 'none'
    visibleIcon.style.display = 'block'
    input.type = 'text'
  } else {
    hiddenIcon.style.display = 'block'
    visibleIcon.style.display = 'none'
    input.type = 'password'
  }
}
</script>
<style scoped>
.local-container {
//border: 1px solid red; display: flex; height: 100%;
  width: 100%;
}

.local-container .main {
//border: 5px solid green; display: flex; display: flex;
  flex: 1;
}

.local-container .main .clm-1 {
//border: 1px solid red; width: 50%; padding: 2em;
  display: flex;
  flex-direction: column;
}

.local-container .main .clm-1 .success-wrapper {
  display: none;
//border: 1px solid grey; height: auto;
  margin-top: 10rem;
//justify-content: center; align-items: center;
  flex-direction: column;
  padding-top: 2em;
  font-size: 2em;
  color: #32A88A;
}

.local-container .main .clm-1 .success-wrapper .row {
//border: 1px solid red; width: 90%;
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 6rem;
}

.local-container .main .clm-1 .success-wrapper .row .btn-2 {
  font-size: 1.3rem;
  color: #8B95C9;
  margin-top: 1rem;
}

.local-container .main .clm-1 .success-wrapper .row button {
//border: 1px solid red; padding: 1rem;
  background-color: #8B95C9;
  color: white;
  font-size: 1.2rem;
  margin-bottom: 1rem;
  width: 100%;
  height: 4.5rem;
  border-radius: 1em;
}

.local-container .main .clm-1 .row-1 {
//border: 1px solid red; font-size: 2.5rem; color: #6d7bbc;
  margin-bottom: 1em;
  display: block;
}

.local-container .main .clm-1 .form-wrapper {
//border: 1px solid red; //background-color: #f8f8f8; //box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; //border: 1px solid red; display: flex; flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 2em;
//display: flex; display: flex;
}

.local-container .main .clm-1 .form-wrapper .register-error {
  visibility: hidden;
  color: #DE7C7C;
//border: 1px solid red; margin-bottom: 1em;
}

.local-container .main .clm-1 .form-wrapper form {
//border: 1px solid red; width: 100%; display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.local-container .main .clm-1 .form-wrapper .header {
//border: 1px solid red; font-size: 1.2em; width: 100%;
  margin-bottom: 1em;
//padding-left: 1.5rem; font-weight: 500; color: #727272;
  display: block;

}

.local-container .main .clm-1 .form-wrapper input[type=text], input[type=password] {
//border: 1px solid green; height: 4em; width: 100%;
  margin-bottom: 2.5em;
  background-color: #D6EDFF;
  border-radius: 1em;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  font-size: 1.09em;
  color: #3778b0;
}


.local-container .main .clm-1 .form-wrapper input[type=checkbox] {
  display: none;

}

.local-container .main .clm-1 .form-wrapper .psw-input {
  display: flex;
//border: 1px solid red; width: 100%;
}

.local-container .main .clm-1 .form-wrapper .psw-input .input-2 {
  margin-bottom: 2.7em;
  display: flex;
  flex: 1;
  background-color: #D6EDFF;
  border-top-right-radius: 1em;
  border-bottom-right-radius: 1em;
//border: 1px solid red; height: 4.40em;
  align-items: center;
  justify-content: end;
  padding-right: 1.5em;
}

.local-container .main .clm-1 .form-wrapper .psw-input .input-2 input [type = checkbox] {
  display: none;
}

.local-container .main .clm-1 .form-wrapper .psw-input .input-2 label {
//border: 1px solid orange; width: 2.5em;
  cursor: pointer;
}

.local-container .main .clm-1 .form-wrapper .psw-input .input-2 label img {
  width: 100%;
}

#psw-visible {
  display: none;
}

.local-container .main .clm-1 .form-wrapper .psw-input input {
  width: 80%;
  border-bottom-right-radius: 0;
  border-top-right-radius: 0;
}

.local-container .main .clm-1 .form-wrapper .is-admin-check {
  display: flex;
//border: 1px solid red; width: 100%; font-size: 1.2em;
  color: #6d7bbc;
  flex-direction: column;
}

.local-container .main .clm-1 .form-wrapper .is-admin-check .check-box {
  display: flex;
  align-items: center;
//border: 1px solid green; height: 2em; width: 4em;
  border-radius: 15em;
  padding-left: 0.2em;
  padding-right: 0.2em;
  justify-content: start;
  margin-top: 0.7em;
  background-color: #D6EDFF;
}

.local-container .main .clm-1 .form-wrapper .is-admin-check .check-box .check-box-btn {
//border: 1px solid red; height: 1.5em; width: 1.5em;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #8B95C9;
  color: white;
}

#check-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.local-container .main .clm-1 .form-wrapper .submit-btn {
//border: 1px solid red; height: 4em; border-radius: 1em;
  margin-top: 1.5em;
  width: 90%;
  background-color: #6d7bbc;
  color: white;
  font-size: 1.2em;
}

.local-container .main .clm-2 {
  background-color: #D6EDFF;
  width: 50%;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 2em;
}

.local-container .main .clm-2 .section-1 {
//border: 1px solid red; width: 27rem; height: 27rem;
  margin-top: 10rem;
  background-color: #8B95C9;
  border-radius: 50%;
//display: flex; align-items: center; justify-content: center;
  display: flex;
}

.local-container .main .clm-2 .section-1 .inner {
//border: 1px solid red; width: 25rem; height: 25rem;
  border-radius: 50%;
  background-color: white;
  padding: 1em;
}

.local-container .main .clm-2 .section-1-2 {
  margin-top: 1em;
  font-size: 1.5em;
  font-weight: 500;
  color: #727272;
  display: block;
}

.local-container .main .clm-2 .section-1-2:hover {
  text-decoration: underline;
  cursor: pointer;
}

.local-container .main .clm-2 .section-2-1 {
//border: 1px solid red; width: 85%; height: auto;
  display: none;
  flex-wrap: wrap;
  justify-content: center;
  margin-top: 10em;
//flex-direction: column;
}

.local-container .main .clm-2 .section-2-1 .avatar-section {
  background-color: white;
  height: 11em;
  width: 11em;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.local-container .main .clm-2 .section-2-1 .avatar-section:hover {
  background-color: #6d7bbc;
}

.local-container .main .clm-2 .section-2-1 .avatar-section img {
  width: 95%;
  height: 95%;
}

.local-container .main .clm-2 .section-2-2 {
  margin-top: 1.5em;
  font-size: 1.5em;
  font-weight: 500;
  color: #727272;
  display: none;
}
</style>