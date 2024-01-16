<template>
  <div class="container">
    <NavBar/>
    <!--  <p>Data: {{message}}</p>-->
    <!--  <p>Data: {{test}}</p>-->
    <p>{{status}}</p>
    <p>{{data}}</p>
  </div>


</template>


<script setup lang="js">

import NavBar from "~/components/NavBar.vue";
import {useMyFetch} from "~/composables/useMyFetch.js";

const {signIn, refresh, status, data, lastRefreshedAt, signOut, getCsrfToken, token, refreshToken} = useAuth()
let test


// const {data:test} = await useMyFetch('api/test')
// const {data:message} = await useFetch('http://localhost:8000/api/test');
// const {data:user} = await useFetch('http://localhost:8000/api/users/me')

async function logOut() {
  console.log("LOG OUT")
  await signOut()
}


</script>

<style scoped>
@import url("~/assets/css/home.css");
</style>