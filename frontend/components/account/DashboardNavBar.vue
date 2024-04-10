<template>
<div class="dashboard-nav-bar">
  <div class="row-1">
    <div class="icon">
      <img src="~/assets/images/icons/arrow-left.svg" alt="">
    </div>
    {{name}}
  </div>
  <NuxtLink to = "/dashboard">
    <div id = "btn" class="btn" @mouseover.prevent="scale('btn')">
      <div class="icon">
        <img src="~/assets/images/icons/home.svg" alt="">
      </div>
      <p>Panel</p>
    </div>
  </NuxtLink>
  <NuxtLink to = "/dashboard/users">
    <div class="btn">
      <div class="icon">
        <img src="~/assets/images/icons/users.svg" alt="">
      </div>
      <p>Użytkownicy</p>
    </div>
  </NuxtLink>
  <NuxtLink to = "/dashboard/lessons">
    <div class="btn">
      <div class="icon">
        <img src="~/assets/images/icons/book-alt.svg" alt="">
      </div>
      <p>Lekcji</p>
    </div>
  </NuxtLink>
  <NuxtLink to = "/dashboard/games">
    <div class="btn">
      <div class="icon">
        <img src="~/assets/images/icons/puzzle.svg" alt="">
      </div>
      <p>Gry</p>
    </div>
  </NuxtLink>
  <NuxtLink to = "/dashboard/tests">
    <div class="btn">
      <div class="icon">
        <img src="~/assets/images/icons/test.svg" alt="">
      </div>
      <p>Testy</p>
    </div>
  </NuxtLink>
<!--  <NuxtLink to = "/dashboard/settings">-->
    <NuxtLink to = "/">
    <div class="btn">
      <div class="icon">
        <img src="~/assets/images/icons/settings.svg" alt="">
      </div>
      <p>Ustawienia</p>
    </div>
  </NuxtLink>
  <div class="empty-1"></div>
    <div class="btn-2" @click.prevent = "logOut()">
      <div class="icon">
        <img src="~/assets/images/icons/enter.svg" alt="">
      </div>
      <p>Wyloguj się</p>
    </div>
  <div class="empty-2"></div>
</div>
</template>
<script setup lang="ts">
import {userLogOut} from "~/composables/userLogOut";

const {status, refresh, signOut} = useAuth()
const data = useAuth()
const name = data.data.value.user.name
const id = data.data.value.user.id
const avatar = data.data.value.user.avatar
async function logOut() {
  const {data, error} = await useFetch('http://localhost:8000/api/user/log_out', {
        method: 'POST',
        body: {
          id: id
        }
      }
  )
  await signOut(
      {
        callbackUrl: '/',
        external: true
      }
  )
}

</script>

<style scoped>
.dashboard-nav-bar{
  display: flex;
  flex-direction: column;
  width: 20em;
  height: 100vh;
  position: sticky;
}
.dashboard-nav-bar .row-1{
  align-items: center;
  height: auto;
  color: white;
  font-size: 1.5em;
  display: flex;
  padding-left: 1.5em;
  padding-top: 1em;
  padding-bottom: 1em;
  background-color: #6d7bbc;
}
.dashboard-nav-bar .btn{
  height: auto;
  display: flex;
  align-items: center;
  color: white;
  font-size: 1.2em;
  padding-top: 1.1em ;
  padding-bottom: 1.1em;
  padding-left: 1.5em;
  background-color: #6d7bbc;
}
.dashboard-nav-bar .btn-2{
  display: flex;
  align-items: center;
  color: white;
  font-size: 1.3em;
  padding-left: 1.5em;
  padding-top: 1.1em;
  padding-bottom: 1.1em;
  background-color: #6d7bbc;
  cursor: pointer;
}
 .icon{
  width: 1.5em;
  height: 100%;
  margin-right: 0.8em;
  color: white;
}
 .empty-1:empty{
   height: 3em;
   background-color: #6d7bbc;
 }
.empty-2:empty{
  flex-grow: 1;
  background-color: #6d7bbc;
}


</style>