<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="clm-1">
          <AchievementsWrapper :is-achievements-refresh=isRefresh @open-edit-form=openEditForm
                               @open-add-form="openAddForm"/>
        </div>
        <div class="clm-2">
          <AchievementForm id="add-achievement-form" @refreshAchievements=refreshAchievements />
          <AchievementFormEdit id="edit-achievement-form" @refreshAchievements=refreshAchievements
                               :achievement=editFormAchieve />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import AchievementsWrapper from "~/components/account/achievements/AchievementsWrapper.vue";
import AchievementForm from "~/components/account/achievements/AchievementForm.vue";
import AchievementFormEdit from "~/components/account/achievements/AchievementFormEdit.vue";

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (!data.value) {
        return navigateTo('/')
      }
      if (data.value.user.isAdmin !== true) {
        return navigateTo('/')
      }
    }
  ]
})

const data = useAuth()
const {status, refresh, signOut} = useAuth()
let editFormAchieve = ref()
let isRefresh = ref(false)

function openEditForm(achievement) {
  console.log("ACHIEVE 1")
  console.log(achievement)
  let addAchievementForm = document.getElementById('add-achievement-form')
  let editAchievementForm = document.getElementById('edit-achievement-form')

  addAchievementForm.style.display = 'none'
  editAchievementForm.style.display = 'flex'
  editFormAchieve.value = achievement
}

function openAddForm() {
  console.log('Hello its me')

  let addAchievementForm = document.getElementById('add-achievement-form')
  let editAchievementForm = document.getElementById('edit-achievement-form')

  addAchievementForm.style.display = 'flex'
  editAchievementForm.style.display = 'none'

}

function refreshAchievements() {
  console.log('Refresh from index')
  isRefresh.value = !isRefresh.value
  console.log(isRefresh.value)
}
</script>
<style scoped>
.local-container {
//border: 1px solid red; display: flex;
  width: 100%;
  height: 100%;
//overflow-y: auto;
}

.local-container .main {
//border: 1px solid green; display: flex;
  flex: 1;
  height: 100%;
}

.local-container .main .clm-1 {
//border: 1px solid green; width: 70%;
}


.local-container .main .clm-2 {
//border: 1px solid green; flex: 1;
}


</style>