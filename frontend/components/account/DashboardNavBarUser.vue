<template>
  <div class="dashboard-nav-bar">
    <NuxtLink to="/">
      <div class="row-1">
        <i class="fi fi-sr-left"></i>
        <p v-if="userData">{{ userData.user.name }}</p>
        <p v-else>Główna</p>
      </div>
    </NuxtLink>

    <div class="empty-1"></div>
    <div class="btn-2" @click.prevent="logOut()">
      <i class="fi fi-sr-exit-alt"></i>
      <p>Wyloguj się</p>
    </div>
    <div class="empty-2"></div>
  </div>
</template>
<script setup lang="js">
const {data: userData, signOut} = useAuth()
const data = useAuth()
let id
if (userData.value) {
  id = userData.value.user.id
}

async function logOut() {
  const {signOut} = useAuth()
  const {data, error} = await useFetch('http://localhost:8000/api/user/log_out', {
        method: 'POST',
        body: {
          id: id
        }
      }
  )
  await signOut(
      {
        callbackUrl: '/',
        external: true
      }
  )
}
</script>

<style scoped>
.dashboard-nav-bar {
  display: flex;
  flex-direction: column;
  width: 20em;
  height: auto;
  position: sticky;
}

.dashboard-nav-bar .row-1 {
  align-items: center;
  height: auto;
  color: white;
  font-size: 1.5em;
  display: flex;
  padding-left: 2rem;
  padding-top: 1em;
  padding-bottom: 1em;
  background-color: #6d7bbc;
  transition: 0.5s ease;
  cursor: pointer;
}

.dashboard-nav-bar .row-1 i {
  margin-right: 1rem;
  font-size: 1.5rem;
}

.dashboard-nav-bar .row-1:hover {
  background-color: #8B95C9;
  transition: 0.5s ease;
}

.dashboard-nav-bar .btn {
  height: auto;
  display: flex;
  align-items: center;
  color: white;
  font-size: 1.2em;
  padding-top: 1.1em;
  padding-bottom: 1.1em;
  padding-left: 2rem;
  background-color: #6d7bbc;
  transition: 0.5s ease;
}

.dashboard-nav-bar .btn i {
  margin-right: 1rem;
  font-size: 1.5rem;
}

.dashboard-nav-bar .btn:hover {
  background-color: #8B95C9;
  transition: 0.5s ease;
}

.dashboard-nav-bar .btn-2 {
  display: flex;
  align-items: center;
  color: white;
  font-size: 1.3em;
  padding-left: 2rem;
  padding-top: 1.1em;
  padding-bottom: 1.1em;
  background-color: #6d7bbc;
  cursor: pointer;
  transition: 0.5s ease;
}

.dashboard-nav-bar .btn-2 i {
  margin-right: 1rem;
  font-size: 1.5rem;
}

.dashboard-nav-bar .btn-2:hover {
  background-color: #8B95C9;
  transition: 0.5s ease;
}

.empty-2:empty {
  flex-grow: 1;
  background-color: #6d7bbc;
}
</style>