<template>
  <div class="container-local">
    <div class="logo">
      <NuxtLink to='/'><img src="@/assets/images/logo.svg" alt="Mrówka"></NuxtLink>
    </div>
    <div class="nav-1">
      <NuxtLink v-if=data to="/lesson-sections">
        <div id="btn-1" class="btn-1">
          <div class="rnd">
            <img id='img_1' src="@/assets/images/book3.png" alt="">
          </div>
        </div>
      </NuxtLink>
      <NuxtLink v-if=data to="/about">
        <div id="btn-2" class="btn-2">
          <div class="rnd">
            <img id='img_2' src="@/assets/images/book2.png" alt="">
          </div>
        </div>
      </NuxtLink>
      <NuxtLink v-if=data to="/about">
        <div id="btn-3" class="btn-3">
          <div class="rnd">
            <img id='img_3' src="@/assets/images/diamond.png" alt="">
          </div>
        </div>
      </NuxtLink>
    </div>
    <div v-if=!data class="nav-2-1">
      <NuxtLink to="/login"><p>Zaloguj się</p></NuxtLink>
      <NuxtLink to='/register' @mouseover.prevent="imgHide('label-1')" @mouseout.prevent="imgShow('label-1')">
        <div class="btn">
          <div class="rnd">
            <p id="label-1">Spróbuj</p>
          </div>
        </div>
      </NuxtLink>
    </div>
    <div v-if=data class="nav-2-2">
      <NuxtLink to="/dashboard">
        <div class="btn">
          <div class="rnd">
            <img :src="data.user.avatar" alt="avatar">
          </div>
        </div>
      </NuxtLink>
    </div>
  </div>
</template>
<script setup lang="js">
const {data, signOut} = useAuth()

</script>

<style scoped>
.container-local{
  padding-top: 1rem;
  height: 13rem;
  display: flex;
  align-items: center;
}
.container-local .logo {
  width: 20%;
  display: flex;
  align-items: center;
  justify-content: left;
}
.container-local .logo img {
  width: 120%;
  height: 100%;
}

.container-local .logo p {
  font-size: 1.5rem;
}

.container-local .nav-1 {
  width: 60%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-left: 8rem;
  padding-right: 8rem;
}

.container-local .nav-1 p {
  border-radius: 10rem;
  color: white;
  font-family: 'Bree Serif', serif;
  font-weight: 600;
  font-size: 2.1rem;
  background-color: #478978;
}

.container-local .nav-1 .btn-1 {
  width: 11.2rem;
  height: 11.2rem;
  border-radius: 10rem;
  background-color: #8B95C9;
  display: flex;
  justify-content: center;
  align-items: center;
  transform: rotate(20deg);
  transition: 0.25s ease;
}
.container-local .nav-1 .btn-1 .rnd{
  display: flex;
  align-items: center;
  justify-content: center;
}
.container-local .nav-1 .btn-1 .rnd img{
  height: 90%;
  width: 90%;
}
.container-local .nav-1 .btn-2 .rnd img{
  height: 100%;
  width: 100%;
}
.container-local .nav-1 .btn-3 .rnd img{
  height: 90%;
  width: 90%;
}

.container-local .nav-1 .btn-1:hover {
  background-color: #6D7BBC;
  transition: 0.25s ease;
}

.container-local .nav-1 .btn-2 {
  width: 11.2rem;
  height: 11.2rem;
  border-radius: 10rem;
  background-color: #ACD7EC;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: 0.25s ease;
}

.container-local .nav-1 .btn-2:hover {
  background-color: #6ec1ec;
  transition: 0.25s ease;
}

.container-local .nav-1 .btn-3 {
  width: 11.2rem;
  height: 11.2rem;
  border-radius: 10rem;
  background-color: #84DCC6;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: 0.25s ease;
}

.container-local .nav-1 .btn-3:hover {
  background-color: #4be18c;
  transition: 0.25s ease;
}

.container-local .nav-1 .rnd {
  border: 4px solid white;
  border-radius: 10rem;
  width: 10rem;
  height: 10rem;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container-local .nav-1 .rnd img {
  width: 90%;
  height: 90%;
}

.container-local .nav-2-1 {
  width: 20%;
  display: flex;
  align-items: center;
  justify-content: right;
  font-family: 'Bree Serif', serif;
}

.container-local .nav-2-1 .btn {
  width: 11.2rem;
  height: 11.2rem;
  border-radius: 10rem;
  background-color: #32A88A;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 1rem;
}

.container-local .nav-2-1 .btn:hover {
  background-color: #0d9477;
}

.container-local .nav-2-1 .btn .rnd {
  border: 4px solid white;
  border-radius: 10rem;
  width: 10rem;
  height: 10rem;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container-local .nav-2-1 .btn .rnd p {
  color: white;
  font-size: 2rem;
}

.container-local .nav-2-1 p {
  font-weight: 600;
  font-size: 1.7rem;
  color: #7886ba;
}

.container-local .nav-2-2 {
  width: 20%;
  display: flex;
  align-items: center;
  justify-content: right;
  flex-direction: column;
}

.container-local .nav-2-2 .btn {
  width: 11.2rem;
  height: 11.2rem;
  border-radius: 10rem;
  background-color: #32A88A;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 1rem;
}

.container-local .nav-2-2 .btn:hover {
  background-color: #0d9477;
}

.container-local .nav-2-2 .btn .rnd {
  border: 4px solid white;
  border-radius: 10rem;
  width: 10rem;
  height: 10rem;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>