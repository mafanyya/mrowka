<template>
  <div class="container">
      <form @submit.prevent="handleLogin(username, password)">
        <p class="heading-1">Witaj ponownie</p>
        <p class="heading-2">Zaloguj się do Mrówka</p>
        <input
            v-model="username"
            type="text"
            placeholder="Email"
            required
        />
        <input
            v-model="password"
            type="password"
            class="input"
            placeholder="Hasło"
            required
        />
        <button type=submit class="btn-submit">Zaloguj się</button>
        <p class = "inf-1">Jeszcze nie masz konta?</p>
        <NuxtLink to ="/register"><p class = "inf-2">Zarejestruj się</p></NuxtLink>
      </form>

    </div>
</template>

<script setup lang="js">
const {signIn, status, data, refreshToken, refresh, token} = useAuth()
let error

async function handleLogin(username, password) {
  try {
    console.log("Login: ", username, password)
    response = await signIn({
      email: username,
      password: password
    })

  } catch (error) {
    console.log('ERROR IS')
    console.log(error.message)
  }finally {
    if(data){
      navigateTo("/", {external: true})
    }
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
form .inf-1{
  margin-bottom: 0.5em;
  font-family: 'Poppins', sans-serif;
  font-size: 1.1em;
  color: #8B95C9;
}
form .inf-2{
  margin-bottom: 0.5em;
  font-family: 'Poppins', sans-serif;
  font-size: 1.1em;
  font-weight: 600;
  color: #8B95C9;
}

</style>