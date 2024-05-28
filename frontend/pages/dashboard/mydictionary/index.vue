<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <MyDictionaryWrapper/>
      </div>
    </div>
  </div>
</template>
<script setup>
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";

import MyDictionaryWrapper from "~/components/account/dictionary/MyDictionaryWrapper.vue";

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (!data.value) {
        return navigateTo('/')
      }
      if (data.value.user.isAdmin !== true){
        return navigateTo('/')
      }
    }
  ]
})

const data = useAuth()
const {status, refresh, signOut} = useAuth()

</script>
<style scoped>
.local-container {
//border: 1px solid red;
  display: flex;
  width: 100%;
  height: 100%;
//overflow-y: auto;
}

.local-container .main{
//border: 1px solid green;
  display: flex;
  flex: 1;
  height: 100%;
}

</style>