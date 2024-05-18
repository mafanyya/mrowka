<template>
  <div class="admin-wrapper">
    <div class="row-1">
      <p>Administratory</p>
    </div>
    <div v-if = "!adminsPending" class="wrapper">
      <template v-for = "user in users.users">
        <div class="user" v-if = "user.status && user.isAdmin">
          <div class="avatar">
            <img :src= "user.avatar" alt="">
          </div>
          <div class="inf">
            <div class="row-1">
              <p>{{user.name}}</p>
              <NuxtLink :to = "'/dashboard/users/' + user.uniqid">
                <p class = "uniqid">@{{user.uniqid}}</p>
              </NuxtLink>
            </div>
            <div class="row-2">
              <p>online</p>
              <i class="fi fi-ss-circle"></i>
            </div>
          </div>
          <div class="panel">
            <div class="btn">
              <div class="btn-inner">
                <img src="../../../assets/images/icons/chat2.svg" alt="">
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-for = "user in users.users">
        <div class="user" v-if = "!user.status && user.isAdmin">
          <div class="avatar">
            <img :src= "user.avatar" alt="">
          </div>
          <div class="inf">
            <div class="row-1">
              <p>{{user.name}}</p>
              <NuxtLink :to = "'/dashboard/users/' + user.uniqid">
                <p class = "uniqid">@{{user.uniqid}}</p>
              </NuxtLink>
            </div>
            <div class="row-2">
              <p>ostatnio online  {{convertDate(user.lastseen)}}</p>
            </div>
          </div>
          <div class="panel">
            <div class="btn">
              <div class="btn-inner">
                <img src="../../../assets/images/icons/chat2.svg" alt="">
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup lang="js">
const {pending: adminsPending, data: users, refresh: refreshUsers } = await useFetch('http://localhost:8000/api/users')
function convertDate(date){
  let convertedDate = new Date(date)
  let options = {year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false}
  return convertedDate.toLocaleDateString("de-DE", options)
}
</script>

<style scoped>
.admin-wrapper{
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
}
.admin-wrapper .row-1{
  background-color: #6d7bbc;
  display: flex;
  height: 6.5em;
  width: 100%;
  align-items: center;
  padding-left: 1em;
  font-size: 1.5em;
  color: white;
  position: sticky;
}
.admin-wrapper .wrapper{
  //border: 1px solid red;
  padding-top: 1.5em;
  flex-direction: column;
  width: 100%;
  overflow-y: scroll;
}
.admin-wrapper .wrapper .user{
  height: 6rem;
  display: flex;
  align-items: center;
  margin-bottom: 1.5em;
  background-color: #f8f8f8;
//box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  margin-right: 1em;
  margin-left: 1em;
  padding-left: 1em;
  padding-right: 1em;
  border-radius: 1em;
}
.admin-wrapper .wrapper .user .avatar{
  border-radius: 50%;
  height: 4em;
  width: 4em;
  margin-right: 1em;
}
.admin-wrapper .wrapper .user .inf{
//border: 1px solid red;
  display: flex;
  flex-direction: column;
  width: 12em;
}
.admin-wrapper .wrapper .user .inf .row-1{
//border: 1px solid red;
  background-color: transparent;
  height: 50%;
  display: flex;
  align-items: center;
  color: #6d7bbc;
  font-size: 1.3em;
  padding-left: 0;
  padding-bottom: 0.5em;
}
.admin-wrapper .wrapper .user .inf .row-1 .uniqid{
  font-size: 0.80em;
  font-weight: 500;
  color: #727272;
  margin-left: 0.5em;
}
.admin-wrapper .wrapper .user .inf .row-1 .uniqid:hover{
  text-decoration: underline;
}
.admin-wrapper .wrapper .user .inf .row-2{
//border: 1px solid red;
  background-color: transparent;
  height: 50%;
  display: flex;
  align-items: center;
  font-size: 0.90em;
  font-weight: 500;
  color: #727272;
}
.admin-wrapper .wrapper .user .inf .row-2 i{
  color: #32A88A;
  margin-left: 0.3em;
}
.admin-wrapper .wrapper .user .panel{
//border: 1px solid red;
  height: 100%;
  display: flex;
  flex: 1;
  align-items: center;
  justify-content: end;
}
.admin-wrapper .wrapper .user .panel .btn{
  border-radius: 50%;
  height: 2.7em;
  width: 2.7em;
  background-color: #8B95C9;
  display: flex;
  align-items: center;
  justify-content: center;
}
.admin-wrapper .wrapper .user .panel .btn .btn-inner{
  height: 80%;
  width: 80%;
//border: 2px solid white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.admin-wrapper .wrapper .user .panel .btn .btn-inner img{
  width: 70%;
  height: 70%;
}
</style>