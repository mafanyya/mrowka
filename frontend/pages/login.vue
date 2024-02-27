<template>
  <div class="container">
    <form @submit.prevent="handleLogin(email, password)">
      <p class="heading-1">Witaj ponownie</p>
      <p class="heading-2">Zaloguj się do Mrówka</p>
      <p id="login-error" class="login-error"></p>
      <input
          v-model="email"
          type="text"
          placeholder="Email"
          required
      />
      <div class="psw-input">
        <input
            v-model="password"
            type="password"
            class="input"
            placeholder="Hasło"
            required
            id='psw-input'
        />
        <div class="input-2">
          <input type="checkbox" id="psw-visibility">
          <label for="psw-visibility" id="psw-visible" @click.prevent="changePswVisibility()"><img
              src="~/assets/images/icons/visibility-off.svg" alt=""></label>
          <label for="psw-visibility" id="psw-hidden" @click.prevent="changePswVisibility()"><img
              src="~/assets/images/icons/visibility-on.svg" alt=""></label>

        </div>
      </div>
      <button type=submit class="btn-submit">Zaloguj się</button>
      <p class="inf-1">Jeszcze nie masz konta?</p>
      <NuxtLink to="/register" id = 'login-btn' ><p class="inf-2">Zarejestruj się</p></NuxtLink>
    </form>

  </div>
</template>

<script setup lang="js">
const {signIn, status, data, refreshToken, refresh, token } = useAuth()
let loginError

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

async function handleLogin(email, password) {
  try {
    if(validateEmail(email)){
      let credentials = {email: email, password: password}
      await signIn(
          credentials,
          {
          callbackUrl: '/',
           external: true
      })
    }else{
      const errorElement = document.getElementById('login-error')
      errorElement.innerText = 'Nieprawidłowy email'
      errorElement.style.visibility = 'visible'
    }
  } catch (error) {
    console.log('Error from catch is:', error.data.status)
    if (error.data.code >= 400 && error.data.code < 500) {
      const errorElement = document.getElementById('login-error')
      errorElement.innerText = 'Błędne dane logowania'
      errorElement.style.visibility = 'visible'
    }else if(error.data.status >= 500 && error.data.status < 600){
      const errorElement = document.getElementById('login-error')
      errorElement.innerText = 'Bład servera'
      errorElement.style.visibility = 'visible'
    }
  }finally {
  }
  console.log("Login: ", username, password)
}
function validateEmail(email){
  let re = /\S+@\S+\.\S+/;
  return re.test(email);
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
  align-items: center;
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
  margin-bottom: 2em;
}

form .login-error {
  color: red;
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


form input::placeholder {
  color: #80c2c7;
  font-size: 1.1em;
}

form .btn-submit {
  margin-top: 3em;
  margin-bottom: 2em;
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

form .psw-input {
//border: 1px solid red; display: flex;
  width: 100%;
  align-items: center;
}

form .psw-input input {
  width: 88%;
  border-radius: 1em 0 0 1em;
}

form .psw-input input[type = checkbox] {
  width: 2em;
  height: 2em;
}

.psw-input .input-2 {
  display: flex;

  margin-top: -1.5em;
  background-color: #D6EDFF;
  width: 20%;
  height: 4.3em;
  border-top-right-radius: 1em;
  border-bottom-right-radius: 1em;
}

.psw-input .input-2 input[type = checkbox] {
  display: none;
}

.psw-input .input-2 label {
//border: 1px solid red; width: 2em;
  margin-left: 3.5em;
  margin-top: 1.2em;
  cursor: pointer;

}

.psw-input .input-2 label img {
  width: 100%;
}

#psw-visible {
  display: none;
}

</style>