<template>
    <div id = "delete-alert" class="delete-alert">
      <div class="inner">
        <div class="row-1">
          <p id = "confirm-text">Czy na pewno chcesz usunąć użytkownika?</p>
        </div>
        <div id = "confirm-row-2" class="row-2">
          <button @click.prevent = "confirmDelete(1)" class = "btn-1">Potwierdź</button>
          <button @click.prevent = "confirmDelete(0)" class = "btn-2">Cofnij</button>
        </div>
      </div>
    </div>
  <div v-if = "!props.usersPending" class="user-wrapper">
    <template v-for="user in users.users">
      <div class="user" v-if="user.status && !user.isAdmin">
        <div class="avatar">
          <img :src="user.avatar" alt="">
        </div>
        <div class="inf">
          <div class="row1"><p>{{ user.email }}</p>
            <NuxtLink :to="'/dashboard/users/' + user.uniqid">
              <p class="uniqid">@{{ user.uniqid }}</p>
            </NuxtLink>
            <NuxtLink :to="'/dashboard/users/' + user.uniqid">

            </NuxtLink>
          </div>
          <div class="row2">
            <p>online</p>
            <i class="fi fi-ss-circle"></i>
          </div>
        </div>
        <div class="panel-1">
          <!--                <button @click.prevent="deleteUser(id = user.id)">delete</button>-->
          <NuxtLink :to="'/dashboard/users/' + user.uniqid">
            <div class="btn-1">
              <img src="../../../assets/images/icons/pencil.svg" alt="">
            </div>
          </NuxtLink>
          <div class="btn-2" @click.prevent="openUserDeleteAlert(user.uniqid)">
            <img src="../../../assets/images/icons/cross-small.svg" alt="">
          </div>
        </div>
      </div>
    </template>
    <template v-for="user in users.users">
      <div class="user" v-if="!user.status && !user.isAdmin">
        <div class="avatar">
          <img :src="user.avatar" alt="">
        </div>
        <div class="inf">
          <div class="row1"><p>{{ user.email }}</p>
            <NuxtLink :to="'/dashboard/users/' + user.uniqid">
              <p class="uniqid">@{{ user.uniqid }}</p>
            </NuxtLink>
          </div>
          <div class="row2">
            <p>ostatnio online {{ convertDate(user.lastseen) }}</p>
          </div>
        </div>
        <div class="panel-1">
          <!--                <button @click.prevent="deleteUser(id = user.id)">delete</button>-->
          <NuxtLink :to="'/dashboard/users/' + user.uniqid">
            <div class="btn-1">
              <img src="../../../assets/images/icons/pencil.svg" alt="">
            </div>
          </NuxtLink>
          <div class="btn-2" @click.prevent="openUserDeleteAlert(user.uniqid)">
            <img src="../../../assets/images/icons/cross-small.svg" alt="">
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup lang="js">
import DeleteUserAlert from "~/components/account/users/DeleteUserAlert.vue";
let uniqId

let props = defineProps({
  refreshUsersStatistics: {
    type: Function
  },
  usersPending:{
    type: Boolean
  }
})

const {pending, data: users, refresh: refreshUsers} = await useFetch('http://localhost:8000/api/users')
function convertDate(date) {
  let convertedDate = new Date(date)
  let options = {year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false}
  return convertedDate.toLocaleDateString("de-DE", options)
}
function openUserDeleteAlert(id){
  let deleteAlert = document.getElementById('delete-alert')
  deleteAlert.style.display = 'flex'
  uniqId = id
}
async function confirmDelete(index) {
  switch (index) {
    case 0:
      let deleteAlert = document.getElementById('delete-alert')
      deleteAlert.style.display = 'none'
          uniqId = null
          break
    case 1:
      await deleteUser(uniqId)
          break
    default:
      console.log("Confirm delete error, undefined case: " + index)
          break
  }
}
async function deleteUser(uniqid) {
    const {data: deleteUserData, error: deleteUserError} = await useFetch('http://localhost:8000/api/user/delete', {
          method: 'POST',
          body: {
            uniqid: uniqid
          }
        }
    )
  if(deleteUserData.value){
    console.log('User successfully deleted')
    console.log(deleteUserData)
    
  }
  if(deleteUserError.value){
    console.log('User delete error is ')
    console.log(deleteUserError)
  }
  let deleteAlert = document.getElementById('delete-alert')
  let confirmText = document.getElementById('confirm-text')
  let btnConfirmRow = document.getElementById('confirm-row-2')
  btnConfirmRow.style.display = 'none'
  confirmText.style.color = 'green'
  confirmText.innerText = 'Użytkownik pomyślnie usunięty'
  setTimeout(deleteAlert.style.display = 'none', 10000)
  confirmText.style.color = '#6D7BBC'
  confirmText.innerText = 'Czy na pewno chcesz usunąć użytkownika?'
  btnConfirmRow.style.display = 'flex'
  uniqId = null
    await refreshUsers()
    await props.refreshUsersStatistics()
}
</script>

<style scoped>
.delete-alert{
//border: 1px solid red;
  padding-top: 1rem;
  position: sticky;
  width: 100%;
  height: 60rem;
  transition: 2s ease;
  display: none;
  justify-content: center;
  padding-bottom: 1rem;
}
.delete-alert .inner{
//border: 1px solid red;
  width: 85%;
  background-color: #f8f8f8;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  border-radius: 1rem;
  display: flex;
  flex-direction: column;
}
.delete-alert .inner .row-1{
//border: 1px solid red;
  width: 100%;
  height: 40%;
  display: flex;
  justify-content: center;
  align-items: end;
  padding-bottom: 0.5rem;
  padding-top: 1rem;
  font-size: 1.2rem;
  color: #6D7BBC;
}
.delete-alert .inner .row-2{
//border: 1px solid red;
  width: 100%;
  height: 60%;
  display: flex;
  justify-content: space-between;
  padding: 1rem 11rem;
}
.delete-alert .inner .row-2 .btn-1{
//border: 1px solid red;
  width: 10rem;
  background-color: #f66f6f;
  color: white;
  font-size: 1.1rem;
  border-radius: 1rem;
  cursor: pointer;
}
.delete-alert .inner .row-2 .btn-1:hover{
  background-color: #de4141;
  transition: 0.25s ease;
}
.delete-alert .inner .row-2 .btn-2{
//border: 1px solid red;
  width: 10rem;
  font-size: 1.1rem;
  color: #727272;
  cursor: pointer;
}
.delete-alert .inner .row-2 .btn-2:hover{
  text-decoration: underline;
}
.user-wrapper {
  padding: 2em 3em 3em;
  overflow-y: scroll;
  width: 100%;
}

.user-wrapper .user {
  margin-bottom: 2em;
  display: flex;
  height: 7em;
  align-items: center;
  background-color: #f8f8f8;
//background-color: #f5f8ff; padding: 0.5em;
  padding-left: 1em;
  border-radius: 1em;
  //box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
}

.user-wrapper .user .avatar {
//border: 1px solid green; height: 90%;
  width: auto;
  margin-right: 1.5em;
}

.user-wrapper .user .avatar img {
  width: 100%;
  height: 100%;
}

.user-wrapper .user .inf {
  height: 100%;
  width: 40%;
  display: flex;
  flex-direction: column;
//border: 1px solid red;
}

.user-wrapper .user .inf .row1 {
  height: 60%;
  display: flex;
  align-items: center;
  font-size: 1.3em;
  font-weight: 500;
  color: #6d7bbc;
}

.user-wrapper .user .inf .row1 .uniqid {
  font-size: 0.80em;
  font-weight: 500;
  color: #727272;
  margin-left: 1em;
}

.user-wrapper .user .inf .row1 .uniqid:hover {
  text-decoration: underline;
}

.user-wrapper .user .inf .row2 {
  height: 40%;
  display: flex;
//align-items: center; font-size: 0.90em;
  font-weight: 500;
  color: #727272;
}

.user-wrapper .user .inf .row2 i {
  color: #32A88A;
  margin-left: 0.3em;
}

.user-wrapper .user .panel-1 {
//border: 1px solid red; width: auto;
  height: 100%;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: end;
  margin-right: 1em;
}

.user-wrapper .user .panel-1 .btn-1 {
  border-radius: 50%;
  background-color: #84DCC6;
  height: 3em;
  width: 3em;
  margin-left: 1em;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.user-wrapper .user .panel-1 .btn-2 {
  border-radius: 50%;
  background-color: #f66f6f;
  height: 3em;
  width: 3em;
  margin-left: 1em;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.user-wrapper .user .panel-1 .btn-1:hover {
  background-color: #32A88A;
}

.user-wrapper .user .panel-1 .btn-2:hover {
  background-color: #de4141;
}

.user-wrapper .user .panel-1 .btn-1 img {
  width: 40%;
  height: 40%;
}

.user-wrapper .user .panel-1 .btn-2 img {
  width: 60%;
  height: 60%;
}
</style>