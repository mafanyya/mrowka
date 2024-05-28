<template>
  <div class="achievements-wrapper">
    <template v-if="!userData">
      <ServerError/>
    </template>
    <template v-else>
      <p @click-.prevent="test()" class="header">Moje osiągnięcia</p>
      <div class="achievements">
        <template v-if="userData.user.achievements.length === 0">
          <p class="no-achieve-header"><i class="fi fi-rr-guide-alt"></i>Nie masz jeszcze osiągnięć</p>
        </template>
        <template v-else>

          <div v-for="achievement in userData.user.achievements" class="achievement">
            <div class="img">
              <img :src="achievement.img" alt="">
            </div>
            <p class="title">{{ achievement.title }}</p>
          </div>
        </template>
      </div>
    </template>
  </div>
</template>
<script setup lang="js">
import ServerError from "~/components/errors/ServerError.vue";

const {refresh: refreshUser, status: userStatus, data: userData, signOut, token, refreshToken} = useAuth()

function test() {
  console.log(userData.user.achievements.count)
}

</script>

<style scoped>
.achievements-wrapper {
//border: 1px solid red; width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 1rem;
}

.achievements-wrapper .header {
  font-size: 3rem;
  color: #6d7bbc;
}

.achievements-wrapper .no-achieve-header {
  font-size: 1.8rem;
  color: #8B95C9;
  display: flex;
  justify-content: center;
  width: 100%;
  margin-bottom: 1rem;
  align-items: center;
}

.achievements-wrapper .no-achieve-header i {
  margin-right: 1rem;
}

.achievements-wrapper .achievements {
//border: 1px solid red; width: 80%;
  margin-top: 2rem;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.achievements-wrapper .achievements .achievement {
//border: 1px solid blue; height: 15rem;
  width: 15rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.achievements-wrapper .achievements .achievement .img {
//border: 1px solid red; height: 9rem;
  width: 9rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  background-color: #D6EDFF;
}

.achievements-wrapper .achievements .achievement .img img {
  height: 120%;

}

.achievements-wrapper .achievements .achievement .title {
  margin-top: 1.5rem;
  font-size: 1.5rem;
  color: #6d7bbc;
}
</style>