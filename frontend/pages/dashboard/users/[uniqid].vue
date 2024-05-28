<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="profile-wrapper">
          <div class="profile-row-1">
            <div class="clm-1">
              <div @click.prevent="test()" class="avatar">
                <img :src="userData.user.avatar" alt="">
              </div>
              <div class="credentials">
                <p class='name'>{{ userData.user.name }}</p>
                <p class='email'>{{ userData.user.email }}</p>
              </div>
            </div>
            <div class="role">
              <i class="fi fi-sr-user"></i>
              <p v-if="userData.user.isAdmin">Administrator</p>
              <p v-else>Użytkownik</p>
            </div>
            <NuxtLink to="/">
              <div class="home-btn">
                <i class="fi fi-sr-home"></i>
                <p>Główna</p>
              </div>
            </NuxtLink>
          </div>
          <div class="profile-row-2">
            <div class="setting-section">
              <p>Ustawienia</p>
              <div class="panel">
                <div class="row">
                  <i class="fi fi-sr-bullet"></i>
                  <p @click.prevent="sectionChange(1)">Konto</p>
                </div>
                <div class="row">
                  <i class="fi fi-sr-bullet"></i>
                  <p @click.prevent="sectionChange(2)">Bezpieczeństwo</p>
                </div>
                <div class="row">
                  <i class="fi fi-sr-bullet"></i>
                  <p @click.prevent="sectionChange(3)">Usuń konto</p>
                </div>
              </div>
            </div>
            <div class="credentials-section">
              <div id="profile" class="profile">
                <ProfileSection
                    :avatar="userData.user.avatar"
                    :email="userData.user.email"
                    :name="userData.user.name"
                    :uniqid="uniqId"
                    :refreshUser="refreshUser"
                    :userPending="userPending"/>
              </div>
              <div id="security" class="security">
                <SecuritySection
                    :uniqid="uniqId"
                />
              </div>
              <div id="delete" class="delete">
                <DeleteSection
                    :uniqid="uniqId"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import ProfileSection from "~/components/account/profile/ProfileSection.vue";
import SecuritySection from "~/components/account/profile/SecuritySection.vue";
import DeleteSection from "~/components/account/profile/DeleteSection.vue";

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (!data.value) {
        return navigateTo('/')
      }
      if (data.value.user.isAdmin !== true){
        return navigateTo('/')
      }
    }
  ]
})

const route = useRoute()
const uniqId = route.params.uniqid
let index = 'HELLO ITS ME'

async function test() {
  console.log('REFRESH')
  await refreshUser()
  console.log('REFRESH')
}

const {
  data: userData,
  error: userError,
  refresh: refreshUser,
  pending: userPending
} = await useFetch('http://localhost:8000/api/users/find', {
      method: 'POST',
      body: {
        uniqid: uniqId
      }
    }
)
function sectionChange(section) {
  let profileSection = document.getElementById('profile')
  let securitySection = document.getElementById('security')
  let deleteSection = document.getElementById('delete')
  switch (section) {
    case 1:
      securitySection.style.display = 'none'
      deleteSection.style.display = 'none'
      profileSection.style.display = 'flex'
      break
    case 2:
      deleteSection.style.display = 'none'
      profileSection.style.display = 'none'
      securitySection.style.display = 'flex'
      break
    case 3:
      securitySection.style.display = 'none'
      profileSection.style.display = 'none'
      deleteSection.style.display = 'flex'
      break
    default:
      index = 1
      break
  }
}
</script>
<style scoped>
.local-container {
//border: 1px solid red; display: flex;
}

.local-container .main {
//border: 1px solid green; display: flex;
  flex: 1;
  justify-content: center;
}

.local-container .main .profile-wrapper {
//border: 1px solid purple; height: 100%;
  width: 85%;
  display: flex;
  align-items: center;
  flex-direction: column;
}

.local-container .main .profile-wrapper .profile-row-1 {
//border: 1px solid grey; width: 100%;
  height: 8rem;
  margin-top: 3rem;
  background-color: #f8f8f8;
  border-radius: 1em;
  display: flex;
  padding: 1rem 2rem;
  align-items: center;
  justify-content: space-between;
}

.local-container .main .profile-wrapper .profile-row-1 .clm-1 {
//border: 1px solid purple; height: 100%;
  display: flex;
  align-items: center;
}

.local-container .main .profile-wrapper .profile-row-1 .clm-1 .avatar {
//border: 1px solid blue; width: 5.5rem;
  height: 5.5rem;
  border-radius: 50%;
  cursor: pointer;
}

.local-container .main .profile-wrapper .profile-row-1 .clm-1 .credentials {
//border: 1px solid purple; height: 60%;
  display: flex;
  justify-content: space-between;
  flex-direction: column;
  margin-left: 2rem;
}

.local-container .main .profile-wrapper .profile-row-1 .role {
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: start;
  align-items: center;
  padding-left: 2rem;
  font-size: 1.2rem;
  color: #727272
}

.local-container .main .profile-wrapper .profile-row-1 .role i {
  margin-right: 0.25rem;
}

.local-container .main .profile-wrapper .profile-row-1 .home-btn {
//border: 1px solid red; height: 4.5rem;
  width: 10rem;
  background-color: #32A88A;
  border-radius: 1em;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  color: white;
  cursor: pointer;
}

.local-container .main .profile-wrapper .profile-row-1 .home-btn:hover {
  background: #239076;
}

.local-container .main .profile-wrapper .profile-row-1 .home-btn p {
  margin-left: 0.5rem;
}

.local-container .main .profile-wrapper .profile-row-1 .credentials .name {
  font-size: 2rem;
  color: #6D7BBC;
  transition: 1s ease;

}

.local-container .main .profile-wrapper .profile-row-1 .credentials .email {
  color: #727272;
//font-weight: 500; font-size: 1.1rem;
  transition: 1s ease;
}

.local-container .main .profile-wrapper .profile-row-2 {
//border: 1px solid purple; width: 100%;
  margin-top: 3rem;
  display: flex;
  flex: 1;
  margin-bottom: 4rem;
}

.local-container .main .profile-wrapper .profile-row-2 .setting-section {
  color: #727272;
//border: 1px solid purple; height: 30%;
  width: 18rem;
  background-color: #f8f8f8;
  border-radius: 1em;
  padding: 2rem;
  font-size: 1.1rem;
}

.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel {
//border: 1px solid purple; //margin-left: 1rem; margin-top: 1.5rem;
}

.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel .row {
  display: flex;
//border: 1px solid grey; margin-bottom: 0.5rem;
}

.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel .row p {
  margin-left: 0.5rem;
  cursor: pointer;
}

.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel .row p:hover {
  text-decoration: underline;
}

.local-container .main .profile-wrapper .profile-row-2 .credentials-section {
//border: 1px solid purple; margin-left: 3rem;
  display: flex;
  flex: 1;
  flex-direction: column;
  background-color: #f8f8f8;
  border-radius: 1em;
}

.local-container .main .profile-wrapper .profile-row-2 .credentials-section .profile {
  display: flex;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;
}

.local-container .main .profile-wrapper .profile-row-2 .credentials-section .security {
  display: none;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;
}

.local-container .main .profile-wrapper .profile-row-2 .credentials-section .delete {
  display: none;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;
}

</style>