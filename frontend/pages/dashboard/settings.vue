<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="clm-2">
        <p>settings</p>
      </div>
    </div>
  </div>
</template>
<script setup>
const data = useAuth()
const {status, refresh, signOut} = useAuth()
// const email = data.data.value.user.email
// const name = data.data.value.user.name
// const avatar = data.data.value.user.avatar
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
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
function logOut() {
  signOut()
  navigateTo("/", {external: true})
}
</script>
<style scoped>
.local-container {
  border: 1px solid red;
  display: flex;
}

.local-container .clm-2{
  border: 1px solid green;
  background-color: #2db848;
  height: 20px;
}
</style>