<template>
  <div class="container">
    <NavBar/>
    <div class="home">
      <div class="img">
        <img src="~/assets/images/unicorn.svg" alt="">
      </div>
      <div class="greetings">
        <p v-if="data">Cześć, {{ data.user.name }}!</p>
        <p v-else>Cześc! </p>
        <img src="~/assets/images/pencil.svg" alt="">
      </div>
    </div>
  </div>
</template>

<script setup lang="js">
import NavBar from "~/components/NavBar.vue";
import {userLogOut} from "~/composables/userLogOut.js";

const {signIn, refresh, status, data, lastRefreshedAt, signOut, getCsrfToken, token, refreshToken} = useAuth()
let test
async function logOut() {
  console.log("LOG OUT")
  await signOut()
}
</script>

<style scoped>
.home {
  height: 43em;
  padding-top: 1em;
  display: flex;
}

.home .img {
  width: 40%;
  height: 100%;
  padding-left: 7em
}

.home .img img {
  height: 100%;
}

.home .greetings {
  width: 60%;
  height: 100%;
}

.home .greetings p {
  margin-top: 1em;
  margin-left: 2em;
  font-size: 6em;
  font-weight: 600;
  transform: rotate(-10deg);
  color: #6d7bbc;
}

.home .greetings img {
  margin-left: 30em;
  transform: rotate(50deg);
}
</style>