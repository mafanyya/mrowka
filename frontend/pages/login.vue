<template>
  <div class="container">
    <!--    <div class="clm-1">-->
    <!--      <button>-->
    <!--        <NuxtLink to="/register">Zarejestruj się</NuxtLink>-->
    <!--      </button>-->
    <!--      <button>-->
    <!--        <NuxtLink to="/">Home</NuxtLink>-->
    <!--      </button>-->
    <!--    </div>-->


    <div class="clm-2">
      <p v-if=loginError>{{ loginError }}</p>

      <form @submit.prevent="handleLogin(username, password)">
        <h1>Witaj ponownie</h1>
        <p>Zaloguj się do Mrówka</p>
        <p>{{ status }}</p>
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
        <button type=submit class="button">Zaloguj się</button>
      </form>
      <button><NuxtLink to = '/'>HOME</NuxtLink></button>
      <button @click.prevent = refresh()>Refresh</button>
      <button @click.prevent = refresh()>Refresh 2</button>


    </div>


  </div>
</template>

<script setup lang="js">
const {signIn, status, data, refreshToken, refresh, } = useAuth()

let loginError
let error
let response = 'hi'

async function handleLogin(username, password) {
try{
  console.log("Login: ", username, password)
  response = await signIn({
    email: username,
    password: password
  })

}catch (error){
  console.log('ERROR IS')
  console.log(error.message)
}
}

async function refreshUserToken(){
  console.log('refresh')
  await refresh()
}




</script>


<style scoped>
.container {
  margin: 0 auto;
  border: none;
  border-radius: 1.5em;
  width: 60%;
  height: 800px;
  margin-top: 4em;
  display: flex;
}

.container .clm-1 {
  width: 40%;
  border: none;

  background-color: orange;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: end;
}

.container .clm-1 button {
  margin-bottom: 2em;
  border: none;
  border-radius: 1.5em;
  padding: 1em 2em;
  background-color: white;
  color: orange;


}

.container .clm-2 {
  width: 60%;

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 3em;

}

.clm-2 form {
  width: 100%;
  height: 100%;

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;

}

.clm-2 form input {
  background-color: #fff4d8;
  width: 80%;
  padding: 1em 1.5em;
  margin-bottom: 1em;
  border: none;
  border-radius: 2em;

}

.clm-2 form input:focus {
  background-color: #fcedd4;

}

.clm-2 form h1 {
  font-size: 3rem;
  margin-bottom: 1em;
}

.clm-2 form p {
  margin-bottom: 3em;
}

.clm-2 form button {
  background-color: orange;
  padding: 1em 1.5em;
  border: none;
  border-radius: 2em;
  width: 60%;
  color: white;
  margin-top: 2em;

}

.clm-2 form button:hover {
  background-color: #ec9a00;
}


</style>