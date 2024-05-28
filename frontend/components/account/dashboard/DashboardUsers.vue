<template>
  <div class="users">
    <NuxtLink to="/dashboard/users">
      <p class="header"><i class="fi fi-rr-employees"></i>Użytkownicy</p>
    </NuxtLink>
    <div class="section">
      <div class="row">
        <p class="label"><i class="fi fi-rr-users-alt"></i>Łącznie użytkowników:</p>
        <p v-if="usersStatistics" class="value-1">{{ usersStatistics.users_count }}
          <span class="value-1-2">osób</span>
        </p>
        <p v-else class="value-1">0</p>
      </div>
      <div class="row-2">
        <p class="label"><i class="fi fi-ss-circle"></i>Łącznie online:</p>
        <p v-if="usersStatistics" class="value-1">{{ usersStatistics.all_online_count }}
          <span class="value-1-2">osób</span>
        </p>
        <p v-else class="value-1">0</p>
      </div>
      <div class="row">
        <p class="label"><i class="fi fi-rr-user"></i>Użytkownicy:</p>
        <p v-if="usersStatistics" class="value-1">{{ usersStatistics.users_count_users }}
          <span class="value-1-2">osób</span>
        </p>
        <p v-else class="value-1">0</p>
      </div>
      <div class="row-2">
        <p class="label"><i class="fi fi-ss-circle"></i>Online:</p>
        <p v-if="usersStatistics" class="value-1">{{ usersStatistics.users_online_count }}
          <span class="value-1-2">osób</span>
        </p>
        <p v-else class="value-1">0</p>
      </div>
      <div class="row">
        <p class="label"><i class="fi fi-rr-user-crown"></i>Administratory:</p>
        <p v-if="usersStatistics" class="value-1">{{ usersStatistics.admins_count }}
          <span class="value-1-2">osób</span>
        </p>
        <p v-else class="value-1">0</p>
      </div>
      <div class="row-2">
        <p class="label"><i class="fi fi-ss-circle"></i>Online:</p>
        <p v-if="usersStatistics" class="value-1">{{ usersStatistics.admins_online_count }}
          <span class="value-1-2">osób</span>
        </p>
        <p v-else class="value-1">0</p>
      </div>
    </div>
    <div class="section">
      <div class="row">
        <p class="label"><i class="fi fi-rr-user-add"></i>Dzisiaj:</p>
        <p v-if="usersStatistics" class="value-1">+{{ usersStatistics.users_today }}</p>
        <p v-else class="value-1">+0</p>
      </div>
      <div class="row">
        <p class="label"><i class="fi fi-rr-user-add"></i>Za ostatni tydzień:</p>
        <p v-if="usersStatistics" class="value-1">+{{ usersStatistics.users_last_week }}</p>
        <p v-else class="value-1">+0</p>
      </div>

    </div>

  </div>
</template>
<script setup lang="js">
const {
  data: usersStatistics,
  refresh: refreshUserStatistics,
  pending: usersStatisticsPending
} = await useFetch('http://localhost:8000/api/users/count')

</script>

<style scoped>
.users {
  width: 100%;

  display: flex;
  flex-direction: column;
}

.users .header {
  background-color: #32A88A;
  border-radius: 1rem;
  font-size: 2.5rem;
  margin-bottom: 2rem;
  color: white;
  transition: 0.15s ease;
  padding: 1.5rem;
}

.users .header i {
  margin-right: 1rem;
  color: white;
}

.users .section {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.5rem;
  background-color: #f8f8f8;
  border-radius: 1rem;
  padding: 2rem 2rem 1rem;
}

.users .section .row {
//border: 1px solid red; display: flex;
  align-items: end;
  margin-bottom: 1.2rem;
}

.users .section .row .label {
  font-size: 1.2rem;
  color: #727272;
}

.users .section .row .label i {
  margin-right: 0.75rem;
  color: #32A88A;
  font-size: 1.5rem;
}

.users .section .row .value-1 {
//border: 1px solid red; margin-left: 1rem;
  color: #6d7bbc;
  font-size: 2rem;
}

.users .section .row .value-1-2 {
  font-size: 1.2rem;
  color: #727272;
}

.users .section .row-2 {
//border: 1px solid red; display: flex;
  align-items: end;
  margin-bottom: 2rem;
  margin-left: 1rem;
}

.users .section .row-2 .label {
  font-size: 1rem;
  color: #727272;
}

.users .section .row-2 .label i {
  margin-right: 0.5rem;
  color: #32A88A;
  font-size: 0.8rem;
}

.users .section .row-2 .value-1 {
//border: 1px solid red; margin-left: 1rem;
  color: #6d7bbc;
  font-size: 1.2rem;
}

.users .section .row-2 .value-1-2 {
  font-size: 1rem;
  color: #727272;
}

</style>