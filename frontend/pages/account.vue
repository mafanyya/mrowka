<template>

  <div class="container">
    <NavBar/>
    <div class="local-container">
      <div class="avatar-change">
        <form @submit.prevent="registerUser">
          <input type="radio" id="avatar-1" value="_nuxt/assets/images/avatars/lion.png">
          <label for="avatar-1"><img src="~/assets/images/avatars/lion.png" alt="avatar 1"></label>
          <input type="radio" id="avatar-2" value="_nuxt/assets/images/avatars/kitten.png">
          <label for="avatar-2"><img src="~/assets/images/avatars/kitten.png" alt="avatar 2"></label>
          <input type="radio" id="avatar-3" value="_nuxt/assets/images/avatars/giraffe.png">
          <label for="avatar-3"><img src="~/assets/images/avatars/giraffe.png" alt="avatar 3"></label>
          <input type="radio" id="avatar-4" value="_nuxt/assets/images/avatars/mouse.png">
          <label for="avatar-4"><img src="~/assets/images/avatars/mouse.png" alt="avatar 4"></label>
          <input type="radio" id="avatar-5" value="_nuxt/assets/images/avatars/puppy.png">
          <label for="avatar-5"><img src="~/assets/images/avatars/puppy.png" alt="avatar 5"></label>
          <button type="submit">Submit</button>


        </form>
      </div>
      <div class="clm-1">
        <div class="avatar">
          <img :src="avatar" alt="avatar">
        </div>
        <NuxtLink><p class="heading-avatar">Zmień avatar</p></NuxtLink>
      </div>
      <div class="clm-2">
        <div class="clm-2-1">
          <div class="row">
            <p class="heading">Email: </p>
            <p class="inf"> {{ email }}</p>
          </div>
          <div class="row">
            <p class="heading">Imię: </p>
            <p class="inf"> {{ name }}</p>
          </div>

          <div class="row">
            <button @click.prevent=logOut() class="heading">Wyloguj się</button>
          </div>
          
        </div>
        <div class="clm-2-2"></div>
      </div>
    </div>
  </div>
</template>
<script setup>
const data = useAuth()
const {status, refresh, signOut} = useAuth()
const email = data.data.value.user.email
const name = data.data.value.user.name
const avatar = data.data.value.user.avatar

function logOut() {
  signOut()
  navigateTo("/", {external: true})
}
</script>
<style scoped>
.local-container {
//border: 1px solid red; display: flex;
  padding: 3em;
}

.local-container .clm-1 {
//border: 1px solid red; width: 30%;
  height: auto;
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: center;
}

.local-container .clm-1 .avatar {
//border: 1px solid green; width: 30em;
  height: 30em;
  border-radius: 50%;
}

.local-container .clm-1 .heading-avatar {
  font-size: 2em;
  font-weight: 600;
  color: #7886ba;
  margin-top: 1.2em;
}

.local-container .clm-2 {

//border: 1px solid red; width: 70%;
  height: auto;
  display: flex;
  padding-left: 3em;
}

.local-container .clm-2 .clm-2-1 {
//border: 1px solid purple; width: 50%;
  display: flex;
  flex-direction: column;
  margin-top: 3em;
}

.local-container .clm-2 .clm-2-1 .row {
  display: flex;
  margin-bottom: 2em;

}

.local-container .clm-2 .clm-2-1 .row .heading {
  font-size: 2.5em;
  font-weight: 600;
  color: #7886ba;
  margin-right: 0.3em;
}

.local-container .clm-2 .clm-2-1 .row .inf {
  font-size: 2.5em;
  color: #0d9477;
}

.local-container .clm-2 .clm-2-2 {
//border: 1px solid purple; width: 50%;
}

.avatar-change {
  background-color: white;
  border: 3px solid red;
  width: 80%;
  height: 30em;
  position: absolute;
  top: 230px;
  left: 200px;
  display: flex;
  justify-content: left;
  visibility: hidden;

}

.avatar-change form {
  display: flex;
  justify-content: center;

}

.avatar-change form label img {
  width: 5em;
}


</style>