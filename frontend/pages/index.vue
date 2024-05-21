<template>
  <div class="container">
    <NavBar/>
    <div class="local-container">
      <HomeSection v-if = "!userData"/>
      <HomeSectionData v-else :user-name = "userData.user.name"/>
      <Footer/>
    </div>
  </div>
</template>

<script setup lang="js">
import NavBar from "~/components/home/NavBar.vue";
import {userLogOut} from "~/composables/userLogOut.js";
import Footer from "~/components/home/Footer.vue";
import HomeSectionData from "~/components/home/HomeSectionData.vue";

const {refresh: refreshUser, status: userStatus, data: userData, signOut, token, refreshToken} = useAuth()
async function logOut() {
  console.log("LOG OUT")
  await signOut()
}
</script>

<style scoped>
.local-container {
  display: flex;
  height: auto;
  flex-direction: column;
  padding-bottom: 1.5rem;
}
</style>