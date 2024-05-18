<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="clm-2">
        <p>index</p>
      </div>
    </div>
  </div>
</template>
<script setup>
const data = useAuth()
const {status, refresh, signOut} = useAuth()
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
function logOut() {
  signOut()
  navigateTo("/", {external: true})
}
</script>
<style scoped>
.local-container {
  //border: 1px solid red;
  display: flex;
}

.local-container .clm-2{
  border: 1px solid green;
  background-color: #2db848;
  height: 20px;
}
</style>