<template>
  <div class="container">
    <NavBar/>
    <div class="local-container">
      <SectionsWrapperUser/>
      <Footer/>
    </div>
  </div>
</template>

<script setup lang="js">
import NavBar from "~/components/home/NavBar.vue";
import Footer from "~/components/home/Footer.vue";
import SectionsWrapperUser from "~/components/home/SectionsWrapperUser.vue";

const {refresh: refreshUser, status: userStatus, data: userData, signOut, token, refreshToken} = useAuth()

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (!data.value) {
        return navigateTo('/')
      }
    }
  ]
})

</script>

<style scoped>
.local-container {
  display: flex;
  height: auto;
  flex-direction: column;
  padding-bottom: 1.5rem;
}
</style>