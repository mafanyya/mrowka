<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="clm-1">
          <UserSettingsNavBar/>
          <UserWrapper :refreshUsersStatistics = refreshStatisticsUsers :usersPending = usersPending />
        </div>
        <div class="clm-2">
         <div class="row-1">
           <AdminWrapper/>
         </div>
          <div class="row-2">
            <StatisticsPanelUsers :usersStatistics = usersStatistics :statisticsPending = statisticsPending />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import UserSettingsNavBar from "~/components/account/users/UserSettingsNavBar.vue";
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import UserWrapper from "~/components/account/users/UserWrapper.vue";
import AdminWrapper from "~/components/account/users/AdminWrapper.vue";
import StatisticsPanelUsers from "~/components/account/users/StatisticsPanelUsers.vue";
const data = useAuth()
const {status, refresh, signOut} = useAuth()
// const email = data.data.value.user.email
// const name = data.data.value.user.name
// const avatar = data.data.value.user.avatar
const {pending: usersPending, data: users, refresh: refreshUsers } = await useFetch('http://localhost:8000/api/users')
const {data: usersStatistics, refresh: refreshStatisticsUsers, pending: statisticsPending } = await useFetch('http://localhost:8000/api/users/count')
</script>
<style scoped>
.local-container {
  display: flex;
  height: 100vh;
}
.local-container .main {
  //border: 1px solid red;
  display: flex;
  flex: 1;
}
.local-container .main .clm-1{
  //border: 1px solid green;
  width: 65%;
  display: flex;
  flex-direction: column;
  padding-top: 1rem;

}
.local-container .main .clm-2{
  //border: 1px solid orange;
  width: 35%;
  display: flex;
  flex-direction: column;
}
.local-container .main .clm-2 .row-1{
  //border: 1px solid red;
  height: 60%;
}
.local-container .main .clm-2 .row-2{
  //border: 1px solid orange;

  height: 40%;
}

</style>