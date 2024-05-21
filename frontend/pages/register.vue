<template>
  <div class="container">
    <form @submit.prevent="registerUser">
      <p class="heading-1">Witaj</p>
      <p class="heading-2">Zarejestruj się do Mrówka</p>
      <p id="register-error" class="register-error"></p>
      <input
          v-model="username"
          type="text"
          placeholder="Email"
      />
      <input
          v-model="password"
          type="password"
          placeholder="Hasło"
      />
      <input
          v-model="name"
          type="text"
          placeholder="Imię"
      />
      <div class="terms-box">
        <label for="terms" class="terms-not-check" id="terms-not-checked" @click.prevent=isTermsChecked()></label>
        <label for="terms" class="terms-check" id="terms-checked" @click.prevent=isTermsChecked()>
          <span class="inline-checkbox"></span>
        </label>
        <input type="checkbox" id="terms">
        <p>Zaakceptuj nasze warunki</p>
      </div>
      <button type=submit class="btn-submit">Zarejestruj sie</button>
      <p class="inf-1">Masz nasze konto?</p>
      <NuxtLink to="/login"><p class="inf-2">Zaloguj się</p></NuxtLink>
    </form>
  </div>
</template>

<script setup lang="js">
const {signUp, signIn, status, data} = useAuth()
const username = ref('');
const password = ref('');
const name = ref('');
const isAdmin = ref(false);
const roles = ['ROLE_USER'];
const avatar = ref('/_nuxt/assets/images/avatars/lion.png')
let isTerms = false
let error

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (data.value) {
        return navigateTo('/')
      }
    }
  ]
})

async function registerUser() {
  if (!isTerms === true) {
    createError(440)
  } else {
    if (!validateEmail(username.value)) {
      createError(410)
    } else {
      if (!validatePassword(password.value)) {
        createError(420)
      } else {
        if (!validateName(name.value)) {
          createError(430)
        } else {
          const {data: registerData, error: registerError} = await useFetch('http://localhost:8000/api/register', {
                method: 'POST',
                body: {
                  email: username.value,
                  password: password.value,
                  roles: roles,
                  name: name.value,
                  avatar: avatar.value,
                  isAdmin: isAdmin.value,
                  status: true
                }
              }
          )
          if (registerError.value) {
            console.log('Registration error is ' + registerError)
            createError(500)
          }
          if (registerData.value) {
            console.log('Registration successful')
            createError(100)
            let credentials = {email: username.value, password: password.value}
            await signIn(
                credentials,
                {
                  callbackUrl: '/',
                  external: true
                })
          }
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
        registerError.style.color = '#32A88A'
      registerError.innerText = 'Pomyślnie zarejestrowany'
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
    case 440:
      registerError.style.visibility = 'visible'
      registerError.innerText = 'Zaakceptuj nasze warunki'
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

function isTermsChecked() {
  const checkbox = document.getElementById('terms')
  const checked = document.getElementById('terms-checked')
  const notChecked = document.getElementById('terms-not-checked')
  checkbox.checked = isTerms === false;
  if (checkbox.checked === true) {
    notChecked.style.display = 'none'
    checked.style.display = 'flex'
    isTerms = true
    console.log(isTerms)
  } else {
    notChecked.style.display = 'block'
    checked.style.display = 'none'
    isTerms = false
    console.log(isTerms)
  }
}


</script>

<style scoped>
.container {
  margin: 0 auto;
  margin-top: 5em;
  border-radius: 1.5em;
  width: 40%;
  height: 50em;
  display: flex;
  background-color: white;
  padding: 5em;
  justify-content: center;
  flex-direction: column;
}

.container p {
  font-family: 'Bree Serif', serif;
}

.container form {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.container .heading-1 {
  font-size: 4em;
  color: #32A88A;
  margin-bottom: 0.3em;
}

.container .heading-2 {
  font-size: 2em;
  color: #84DCC6;
  margin-bottom: 1em;
}

form .register-error {
  color: #DE7C7C;
  visibility: hidden;
  margin-bottom: 1em;
  font-family: 'Poppins', sans-serif;
}

form input {
  height: 4.2em;
  width: 100%;
  background-color: #D6EDFF;
  border-radius: 1em;
  margin-bottom: 1.5em;
  padding-left: 1.5em;
  padding-right: 1.5em;
  font-size: 1em;
  color: #3778b0;
}

form input[type = checkbox] {
  display: none;
}

form input::placeholder {
  color: #80c2c7;
  font-size: 1.1em;
}

form .btn-submit {
  margin-top: 2em;
  margin-bottom: 1em;
  width: 80%;
  height: 4.1em;
  border-radius: 1em;
  background-color: #8B95C9;
  color: white;
  font-size: 1.1em;
}

form .btn-submit:hover {
  background-color: #6d7bbc;
}

form .terms-not-check {
  display: block;
  width: 1.8em;
  height: 1.8em;
  background-color: #6d7bbc;
  border-radius: 10%;
  cursor: pointer;
}

form .terms-check {
  display: none;
  width: 1.8em;
  height: 1.8em;
  background-color: #6d7bbc;
  border-radius: 10%;
  cursor: pointer;
  justify-content: center;
  align-items: center;
}

form .terms-check .inline-checkbox {
  background-color: white;
  border-radius: 10%;
  width: 60%;
  height: 60%;
}

form .terms-box {
  width: 100%;
  display: flex;
  align-items: center;
  margin-top: 1em;
}

form .terms-box p {
  margin-left: 1em;
  font-size: 1.1em;
  font-family: 'Poppins', sans-serif;
}

form .inf-1 {
  margin-bottom: 0.5em;
  font-family: 'Poppins', sans-serif;
  font-size: 1.1em;
  color: #8B95C9;
}

form .inf-2 {
  margin-bottom: 0.5em;
  font-family: 'Poppins', sans-serif;
  font-size: 1.1em;
  font-weight: 600;
  color: #8B95C9;
}
</style>