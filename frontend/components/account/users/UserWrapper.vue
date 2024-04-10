<template>
  <div class="user-wrapper">
    <template v-for="user in users.users">
      <div class = "user" v-if = "user.status && !user.isAdmin">
        <div class="avatar">
          <img :src= "user.avatar" alt="">
        </div>
        <div class="inf">
          <div class="row1"><p>{{ user.email }}</p></div>
          <div class="row2">
            <p>online</p>
          </div>
        </div>
        <div class="panel-1">
          <!--                <button @click.prevent="deleteUser(id = user.id)">delete</button>-->
          <div class = "btn" @click.prevent = "">
            <div class="btn-inner-1">
              <img src="../../../assets/images/icons/pencil.svg" alt="">
            </div>
          </div>
          <div id = "btn-toggle" class = "btn" @click.prevent = "">
            <div class="btn-inner-2">
              <img src="../../../assets/images/icons/cross-small.svg" alt="">
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-for="user in users.users">
      <div class = "user" v-if = "!user.status && !user.isAdmin">
        <div class="avatar">
          <img :src= "user.avatar" alt="">
        </div>
        <div class="inf">
          <div class="row1"><p>{{ user.email }} </p></div>
          <div class="row2">
            <p>ostatnio widziano {{convertDate(user.lastseen)}}</p>
          </div>
        </div>
        <div class="panel-1">
          <!--                <button @click.prevent="deleteUser(id = user.id)">delete</button>-->
          <div class = "btn" @click.prevent = "">
            <div class="btn-inner-1">
              <img src="../../../assets/images/icons/pencil.svg" alt="">
            </div>
          </div>
          <div class = "btn" @click.prevent = "">
            <div class="btn-inner-2">
              <img src="../../../assets/images/icons/cross-small.svg" alt="">
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup lang="js">
const {pending, data: users, refresh: refreshUsers } = await useFetch('http://localhost:8000/api/users')

function convertDate(date){
  let convertedDate = new Date(date)
  let options = {year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false}
  return convertedDate.toLocaleDateString("de-DE", options)
}
async function deleteUser(id) {
  try {
    const {data, error} = await useFetch('http://localhost:8000/api/user/delete', {
          method: 'POST',
          body: {
            id: id
          }
        }
    )
    await refreshUsers()
  } catch (error) {
    console.log(error)
  }
}
</script>

<style scoped>
.user-wrapper{
  padding: 3em;
  overflow-y: scroll;
}
.user-wrapper .user{
  margin-bottom: 2em;
  display: flex;
  height: 7em;
  align-items: center;
  background-color: #f8f8f8;
//background-color: #f5f8ff;
  padding: 0.5em;
  padding-left: 1em;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
}
.user-wrapper .user .avatar{
//border: 1px solid green;
  height: 90%;
  width: auto;
  margin-right: 1.5em;
}
.user-wrapper .user .avatar img{
  width: 100%;
  height: 100%;
}
.user-wrapper .user .inf{
  height: 100%;
  width: 40%;
  display: flex;
  flex-direction: column;
//border: 1px solid red;
}
.user-wrapper .user .inf .row1{
  height: 60%;
  display: flex;
  align-items: center;
  font-size: 1.3em;
  font-weight: 500;
  color: #6d7bbc;
}
.user-wrapper .user .inf .row2{
  height: 40%;
  display: flex;
//align-items: center;
  font-size: 0.90em;
  font-weight: 500;
  color: #727272;
}
.user-wrapper .user .panel-1{
//border: 1px solid red;
  width: auto;
  height: 100%;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: end;
  margin-right: 1em;
}
.user-wrapper .user .panel-1 .btn{
  border-radius: 50%;
  background-color: #8B95C9;
  height: 3em;
  width: 3em;
  margin-left: 1em;
  display: flex;
  justify-content: center;
  align-items: center;
}
.user-wrapper .user .panel-1 .btn .btn-inner-1{
//border: 2px solid #d6edff;
  border-radius: 50%;
  background-color: #8B95C9;
  height: 2.5em;
  width: 2.5em;
  display: flex;
  justify-content: center;
  align-items: center;
}
.user-wrapper .user .panel-1 .btn .btn-inner-2{
//border: 2px solid #d6edff;
  border-radius: 50%;
  background-color: #8B95C9;
  height: 2.5em;
  width: 2.5em;
  display: flex;
  justify-content: center;
  align-items: center;
}
.user-wrapper .user .panel-1 .btn .btn-inner-1 img{
  width: 55%;
  height: 55%;
}
.user-wrapper .user .panel-1 .btn .btn-inner-2 img{
  width: 90%;
  height: 90%;
}
</style>