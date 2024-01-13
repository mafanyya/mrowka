<script setup lang="ts">

</script>

<template>
  <div class="container">
    <div class="logo">

      <p><NuxtLink to = "/">Mrówka</NuxtLink></p>
    </div>
    <div class="nav-1">
      <p><NuxtLink to = "/about">O nas</NuxtLink></p>
      <p><NuxtLink to = "/about">Dlaczego my</NuxtLink></p>
      <p><NuxtLink to = "/about">Nasze kursy</NuxtLink></p>
    </div>
    <div class="nav-2">
      <p><NuxtLink to = "/login">Zaloguj się</NuxtLink></p>
      <button><NuxtLink to = "/register">Spróbuj</NuxtLink></button>
    </div>
  </div>

</template>

<style scoped>
.container{
  //border: 1px solid red;
  background-color: white;
  margin-top: 2.5em;
  margin-left: 3em;
  margin-right: 3em;
  height: 5.5em;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  display: flex;
  padding: 1em 3em;

}
.logo{
  //border: 1px solid red;
  width: 20%;
  display: flex;
  align-items: center;
}
.logo p{
  font-size: 1.5rem;
}
.nav-1{
  //border: 1px solid green;
  width: 60%;
  display: flex;
  align-items: center;
}
.nav-1 p{
  margin-left: 2em;

}

.nav-2{
  //border: 1px solid red;
  width: 20%;
  display: flex;
  align-items: center;
  justify-content: right;
}
.nav-2 button{
  padding: 1em 2em;
  border: none;
  border-radius: 1.5em;
  font-weight: 600;
  background-color: orange;
  color: white;
  margin-left: 1.5em;
}


</style>