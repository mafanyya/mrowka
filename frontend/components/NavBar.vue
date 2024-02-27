<template>
  <div class="container-local">
    <div class="logo">
      <NuxtLink to='/'><img src="~/assets/images/logo.svg" alt="Mrówka"></NuxtLink>
    </div>
    <div class="nav-1">

      <NuxtLink v-if = data to="/about" @mouseover.prevent="imgHide('img_1')" @mouseout.prevent="imgShow('img_1')">
        <div id="btn-1" class="btn-1">
          <div class="rnd">
            <img id='img_1' src="~/assets/images/icons/rabbit.svg" alt="">
          </div>
        </div>
      </NuxtLink>


      <NuxtLink v-if = data to="/about" @mouseover.prevent="imgHide('img_2')" @mouseout.prevent="imgShow('img_2')">
        <div id="btn-2" class="btn-2">
          <div class="rnd">
            <img id='img_2' src="~/assets/images/icons/mushroom.svg" alt="">
          </div>
        </div>
      </NuxtLink>


      <NuxtLink v-if = data to="/about" @mouseover.prevent="imgHide('img_3')" @mouseout.prevent="imgShow('img_3')">
        <div id="btn-3" class="btn-3">
          <div class="rnd">
            <img id='img_3' src="~/assets/images/icons/bird.svg" alt="">
          </div>
        </div>
      </NuxtLink>

    </div>
    <div v-if=!data class="nav-2-1">
      <NuxtLink to="/login" ><p>Zaloguj się</p></NuxtLink>
      <NuxtLink to='/register' @mouseover.prevent="imgHide('label-1')" @mouseout.prevent="imgShow('label-1')">
        <div class="btn">
          <div class="rnd">
            <p id = "label-1">Spróbuj</p>
          </div>
        </div>
      </NuxtLink>
    </div>


    <div v-if=data class="nav-2-2">
      <NuxtLink to = "/account">
      <div class="btn">
        <div class="rnd">
          <img :src = "data.user.avatar" alt = "avatar">

        </div>
      </div>
      </NuxtLink>

    </div>
  </div>
</template>
<script setup lang="js">

const {data, signOut} = useAuth()
let isMenu = false

async function logOut() {
  console.log("LOG OUT")
  await signOut()
}

function imgHide(id) {
  const img = document.getElementById(id)
  img.style.transform = "rotate(-6deg)"
}
function imgShow(id) {
  const img = document.getElementById(id)
  img.style.transform = "rotate(0deg)"
}
function toggleMenu(){
  const menu = document.getElementById('test')
  if(isMenu === false){
    menu.style.display = 'block'
    isMenu = true
  }else{
    menu.style.display = 'none'
    isMenu = false
  }



}


// document.addEventListener('DOMContentLoaded', function (){
//   const btn1 = document.getElementById('btn-1')
//   const btn1_img = document.getElementById('img_1')
//   console.log(btn1)
//   console.log(btn1_img)
//
//   // btn1_img.addEventListener('mouseover', function (){
//   //   console.log('HOVER 1')
//   //   btn1_img.style.visibility = 'hidden'
//   // })
// })


</script>

<style scoped>
.container-local {
//border: 1px solid red; margin-top: 2.5em;
  height: 12em;
  display: flex;
}

/* ----------LOGO-----------*/
.logo {
//border: 1px solid red; width: 20%;
  display: flex;
  align-items: center;
  justify-content: left;
}

.logo img {
  width: 120%;
  height: 100%;
}

.logo p {
  font-size: 1.5rem;
}

/* ----------NAV_1-----------*/

.nav-1 {
//border: 1px solid green; width: 60%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-left: 8em;
  padding-right: 8em;

}

.nav-1 p {
  border-radius: 10em;
//padding: 3.4em 2.7em; color: white;
  font-family: 'Bree Serif', serif;
  font-weight: 600;
  font-size: 2.1rem;
  background-color: #478978;
}

.nav-1 .btn-1 {
  width: 11.2em;
  height: 11.2em;
  border-radius: 10em;
  background-color: #8B95C9;
  display: flex;
  justify-content: center;
  align-items: center;
}

.nav-1 .btn-1:hover {
  background-color: #697bd3;
}

.nav-1 .btn-2 {
  width: 11.2em;
  height: 11.2em;
  border-radius: 10em;
  background-color: #ACD7EC;
  display: flex;
  justify-content: center;
  align-items: center;
}

.nav-1 .btn-2:hover {
  background-color: #6ec1ec;
}

.nav-1 .btn-3 {
  width: 11.2em;
  height: 11.2em;
  border-radius: 10em;
  background-color: #84DCC6;
  display: flex;
  justify-content: center;
  align-items: center;
}

.nav-1 .btn-3:hover {
  background-color: #4be18c;
}

.nav-1 .rnd {
  border: 4px solid white;
  border-radius: 10em;
  width: 10em;
  height: 10em;
  display: flex;
  justify-content: center;
  align-items: center;
}

.nav-1 .rnd img {
  width: 90%;
  height: 90%;
  transform: rotate(0deg);
}

/* ----------NAV_2-1-----------*/

.nav-2-1 {
//border: 1px solid red; width: 20%;
  display: flex;
  align-items: center;
  justify-content: right;
  font-family: 'Bree Serif', serif;
}

.nav-2-1 .btn {
  width: 11.2em;
  height: 11.2em;
  border-radius: 10em;
  background-color: #32A88A;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 1em;
}

.nav-2-1 .btn:hover {
  background-color: #0d9477;
}

.nav-2-1 .btn .rnd {
  border: 4px solid white;
  border-radius: 10em;
  width: 10em;
  height: 10em;
  display: flex;
  justify-content: center;
  align-items: center;

}

.nav-2-1 .btn .rnd p {
  color: white;
  font-size: 2em;
}

.nav-2-1 p {
  font-weight: 600;
  font-size: 1.7rem;
  color: #7886ba;
}

/* ----------NAV_2-2-----------*/

.nav-2-2 {
//border: 1px solid red;
  width: 20%;
  display: flex;
  align-items: center;
  justify-content: right;
  flex-direction: column;
}
.nav-2-2 .btn{
  width: 11.2em;
  height: 11.2em;
  border-radius: 10em;
  background-color: #32A88A;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 1em;
}
.nav-2-2 .btn:hover {
  background-color: #0d9477;
}
.nav-2-2 .btn .rnd {
  border: 4px solid white;
  border-radius: 10em;
  width: 10em;
  height: 10em;
  display: flex;
  justify-content: center;
  align-items: center;

}





</style>