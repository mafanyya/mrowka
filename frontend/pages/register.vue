<template>
  <div class="container">
    <form @submit.prevent="registerUser">
      <p class="heading-1">Witaj</p>
      <p class="heading-2">Zarejestruj się do Mrówka</p>
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
        <label for="terms" class="terms-not-check" id = "terms-not-checked" @click.prevent = isTermsChecked()></label>
        <label for="terms" class="terms-check" id = "terms-checked" @click.prevent = isTermsChecked()>
          <span class = "inline-checkbox"></span>
        </label>
        <input type="checkbox" id="terms">
        <p>Zaakceptuj nasze warunki</p>
      </div>
      <button type=submit class="btn-submit">Zarejestruj sie</button>
    </form>
  </div>
</template>
<script setup lang="js">
const {signUp, signIn, status, data} = useAuth()
const username = ref('');
const password = ref('');
const name = ref('');
let isTerms = false
let error


function isTermsChecked(){
  const checkbox = document.getElementById('terms')
  const checked = document.getElementById('terms-checked')
  const notChecked = document.getElementById('terms-not-checked')

  checkbox.checked = isTerms === false;
  if(checkbox.checked === true){
    notChecked.style.display = 'none'
    checked.style.display = 'flex'
    isTerms = true
    console.log(isTerms)
  }else{
    notChecked.style.display = 'block'
    checked.style.display = 'none'
    isTerms = false
    console.log(isTerms)
  }
}
async function registerUser() {
  console.log(username.value, password.value)
  if(isTerms === true){
  try {
    await useFetch('http://localhost:8000/api/register', {
          method: 'POST',
          body: {
            email: username.value,
            password: password.value,
            name: name.value
          }
        }
    )
    try {
      await signIn({
        email: username.value,
        password: password.value,
      })
    } catch (loginError) {
      console.log("Login error is ", loginError)
    }
  } catch (registerError) {
    console.log("Register error is ", registerError)
  } finally {
    if (data) {
      navigateTo("/", {external: true})
    }
  }
  }else{
    let error = "Zaakceptuj nasze warunki"
    console.log(error)

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

form input {
  height: 4.5em;
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
  width: 100%;
  height: 4.3em;
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
form .terms-check .inline-checkbox{
  background-color: white;
  border-radius: 10%;
  width: 60%;
  height: 60%;
}
form .terms-box{
  width: 100%;
  display: flex;
  align-items: center;
  margin-top: 1em;
}
form .terms-box p{
  margin-left: 1em;
  font-size: 1.1em;
  font-family: 'Poppins', sans-serif;
}


</style>