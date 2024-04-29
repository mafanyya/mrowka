<template>
<div class="statistics-panel-users">
  <div v-if = "!props.statisticsPending" class="panel-inner">
    <div class="row-1">
      <div class="clm-1">
        <p class="header-1">{{ props.usersStatistics.users_count }}</p>
        <p class="header-2">użytkowników</p>
      </div>
      <div class="clm-2">
        <p class = "header-1">+{{ props.usersStatistics.users_today }}</p>
        <p class = "header-2">dzisiaj</p>
      </div>
    </div>
    <div class="row-2">
      <div class="clm-1">
        <p class = "header-1">{{ props.usersStatistics.all_online_count }}</p>
        <p class = "header-2">online</p>
      </div>
      <div class="clm-2">
        <p class = "header-1">+{{ props.usersStatistics.users_last_week }}</p>
        <p class = "header-2">za ostatni tydzień</p>
      </div>
    </div>
  </div>
</div>
</template>
<script setup lang="js">

let props = defineProps({
  usersStatistics: {
    type: Function
  },
  statisticsPending:{
    type:Boolean
  }
})

// const allUsers = users.value.users_count
// const onlineAll = users.value.all_online_count
// const onlineAdmins = users.value.admins_online_count
// const onlineUsers = users.value.users_online_count



</script>
<style scoped>
.statistics-panel-users{
  //border: 1px solid red;
  height: 100%;
  width: 100%;
  padding: 1em;
  padding-right: 0;
  display: flex;

}
.statistics-panel-users .panel-inner{
  //border: 1px solid green;
  display: flex;
  flex-direction: column;
  width: 100%;
  background-color: #F5FBFF;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  border-radius: 1em;
}
.statistics-panel-users .panel-inner .row-1{
  //border: 1px solid grey;
  display: flex;
  height: 50%;
}
.statistics-panel-users .panel-inner .row-1 .clm-1{
  //border: 1px solid grey;
  width: 60%;
  display: flex;
  flex-direction: column;
  justify-content: end;
  padding-bottom: 1em;
  padding-left: 3em;
}
.statistics-panel-users .panel-inner .row-1 .clm-1 .header-1{

  font-size: 5em;
  color: #32A88A;
}
.statistics-panel-users .panel-inner .row-1 .clm-1 .header-2{

  font-size: 2em;
  color: #84DCC6;
}
.statistics-panel-users .panel-inner .row-1 .clm-2{
  //border: 1px solid grey;
  width: 40%;
  display: flex;
  flex-direction: column;
  justify-content: end;
  padding-bottom: 1em;

}
.statistics-panel-users .panel-inner .row-1 .clm-2 .header-1{

  font-size: 4em;
  color: #32A88A;
}
.statistics-panel-users .panel-inner .row-1 .clm-2 .header-2{

  font-size: 2em;
  color: #84DCC6;
}
.statistics-panel-users .panel-inner .row-2{
  //border: 1px solid grey;
  display: flex;
  height: 50%;
}
.statistics-panel-users .panel-inner .row-2 .clm-1{
  //border: 1px solid grey;
  width: 40%;
  display: flex;
  flex-direction: column;
  padding-left: 3em;
  justify-content: end;
  padding-bottom: 2em;
}
.statistics-panel-users .panel-inner .row-2 .clm-1 .header-1{

  font-size: 5em;
  color: #6D7BBC;
}
.statistics-panel-users .panel-inner .row-2 .clm-1 .header-2{

  font-size: 2em;
  color: #8B95C9
;
}
.statistics-panel-users .panel-inner .row-2 .clm-2{
  //border: 1px solid grey;
  width: 60%;
  display: flex;
  flex-direction: column;
  justify-content: end;
  padding-bottom: 2em;
  padding-left: 1em;
}
.statistics-panel-users .panel-inner .row-2 .clm-2 .header-1{

  font-size: 4em;
  color: #6D7BBC;
}
.statistics-panel-users .panel-inner .row-2 .clm-2 .header-2{

  font-size: 1.5em;
  color: #8B95C9
;
}

</style>