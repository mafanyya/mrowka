<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <p class = "header">Panel administratora</p>
        <div class="row-1">
          <div class="clm-1">
            <DashboardUsers/>
          </div>
          <div class="clm-2">
            <DashboardLessons/>
            <DashboardDictionary/>
            <DashboardTests/>
            <DashboardAchievements/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>

import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import DashboardUsers from "~/components/account/dashboard/DashboardUsers.vue";
import DashboardLessons from "~/components/account/dashboard/DashboardLessons.vue";
import DashboardDictionary from "~/components/account/dashboard/DashboardDictionary.vue";
import DashboardTests from "~/components/account/dashboard/DashboardTests.vue";
import DashboardAchievements from "~/components/account/dashboard/DashboardAchievements.vue";
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
</script>
<style scoped>

.local-container {
//border: 1px solid red;
  display: flex;
  width: 100%;
  height: 100%;

}

.local-container .main{
//border: 1px solid green;
  display: flex;
  flex: 1;
  flex-direction: column;
  padding-left: 3rem;
  padding-top: 2rem;
}
.local-container .main .header{
  font-size: 2.5rem;
  color: #6d7bbc;
}
.local-container .main .row-1{
  //border: 1px solid orange;
  margin-top: 2rem;
  display: flex;


}
.local-container .main .row-1 .clm-1{
  width: 35%;
}
.local-container .main .row-1 .clm-2{
  width: 35%;
  display: flex;
  flex-direction: column;
  margin-left: 10rem;
}
.local-container .main .row-2{
  border: 1px solid orange;
}

</style>