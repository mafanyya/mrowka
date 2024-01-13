<template>
  <div class="container">
    <div class="clm-2">
      <form @submit.prevent="registerUser">
        <h1>Witaj</h1>
        <p>Zarejestruj się do Mrówka</p>
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
        <button type=submit>Zarejestruj sie</button>
      </form>
      <button><NuxtLink to = '/'>HOME</NuxtLink></button>
    </div>
<!--    <div class="clm-1">-->
<!--      <button>-->
<!--        <NuxtLink to="/login">Zaloguj się</NuxtLink>-->
<!--      </button>-->
<!--    </div>-->
  </div>
</template>
<script setup lang="js">
const {signUp, signIn, status} = useAuth()


const username = ref('');
const password = ref('');

async function registerUser(){
  console.log(username.value, password.value)

try{
  await signUp({
    email: username.value,
    password: password.value
  })
}catch(registerError) {
  console.log(registerError)
}
}
</script>







<style scoped>
.container {
  margin: 0 auto;
  border: none;
  border-radius: 1.5em;
  width: 65%;
  height: 800px;
  margin-top: 4em;
  display: flex;
}

.container .clm-1 {
  width: 35%;
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