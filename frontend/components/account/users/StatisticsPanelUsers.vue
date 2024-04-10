

<template>
<div class="statistics-panel-users">
  <div class="panel-inner">
    <div class="clm-1">
      <div class="row-1">
        <div class="row-1-1">
          <p>{{allUsers}}</p>
        </div>
        <div class="row-1-2">
          <p>użytkowników</p>
        </div>


      </div>
      <div class="row-2"></div>
    </div>
    <div class="clm-2">
      <div class="row-1"></div>
      <div class="row-2"></div>
    </div>
  </div>

</div>
</template>
<script setup lang="js">

const {data: users, refresh: refreshUsers } = await useFetch('http://localhost:8000/api/users/count')
const allUsers = users.value.users_count
const onlineAll = users.value.all_online_count
const onlineAdmins = users.value.admins_online_count
const onlineUsers = users.value.users_online_count


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
  width: 100%;
  background-color: #D6EDFF;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
}
.statistics-panel-users .panel-inner .clm-1{
  border: 1px solid grey;
  width: 65%;
  display: flex;
  flex-direction: column;

}
.statistics-panel-users .panel-inner .clm-1 .row-1{
  border: 1px solid grey;
  width: 100%;
  height: 60%;
  display: flex;
  flex-direction: column;

  //align-items: center;
  justify-content: center;

}
.statistics-panel-users .panel-inner .clm-1 .row-1 .row-1-1{
  border: 1px solid grey;
  height: 60%;
  display: flex;
  justify-content: center;
  font-size: 9em;
}
.statistics-panel-users .panel-inner .clm-1 .row-1 .row-1-2{
  border: 1px solid grey;
  height: 40%;
}
.statistics-panel-users .panel-inner .clm-1 .row-2{
  border: 1px solid grey;
  width: 100%;
  height: 40%;
  display: flex;
}
.statistics-panel-users .panel-inner .clm-2{
  border: 1px solid grey;
  width: 35%;
  display: flex;
  flex-direction: column;
}
.statistics-panel-users .panel-inner .clm-2 .row-1{
  border: 1px solid grey;
  height: 50%;
  display: flex;
}
.statistics-panel-users .panel-inner .clm-2 .row-2{
  border: 1px solid grey;
  height: 50%;
  display: flex;
}

</style>