<template>

  <div class="container">
    <NavBar/>
    <p>Account</p>
    <p>Email: {{email}}</p>
    <p @click.prevent = signOut()>Wyloguj sie</p>
    <button @click.prevent=refresh()>Refresh</button>


    <p id = "test" class = test >Hello</p>
    <input  type = checkbox  id = "toggle">


  </div>
</template>
<script setup>
const data = useAuth()
const {status, refresh, signOut} = useAuth()
const email = data.data.value.user.email

</script>
<style scoped>
.test{
  color: orange;
}
#toggle:checked + .test{
  color: red;
}
</style>