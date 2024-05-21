<template>
  <div class="achievements-wrapper">
    <AchievementsNavBar :achieve-pending = achievementsPending @open-form="openAddForm"/>
    <div class="achievements">
      <template v-if = "!achievementsData">
        <div class="server-error">
          <p class = "header-1">Błąd servera</p>
          <p class = "header-2"><i class="fi fi-rr-sad-tear"></i>Niestety</p>
        </div>
      </template>
      <template v-else>
        <template v-if = "achievementsData.achievements.length === 0">
          <p class = "no-data">Brak osiągnięć</p>
        </template>
        <template v-else>
          <div class="wrapper">
            <div v-for = "achievement in achievementsData.achievements" class="achievement">
              <div class="row-1">
                <div class="clm-1">
                  <p class = "id">{{achievement.id}}</p>
                  <div class="img">
                    <img :src="achievement.img" alt="">
                  </div>
                  <p class = "title">{{achievement.title}}</p>
                </div>
                <div class="clm-2">
                  <div @click.prevent = "emit('openEditForm', achievement)" class="btn-edit">
                    <i class="fi fi-sr-pencil"></i>
                  </div>
                  <div @click.prevent = "tryDelete(achievement.id, 1)" class="btn-delete">
                    <i class="fi fi-br-cross"></i>
                  </div>
                </div>
              </div>

              <div :id = "'delete-wrapper-'+ achievement.id" class="delete-wrapper">
                <p :id = "'msg-delete-' + achievement.id" class = "msg">Czy na pewno chcesz usunąć osiągnięcie?</p>
                <div :id = "'delete-panel-' + achievement.id" class="panel">
                  <button @click.prevent = "tryDelete(achievement.id, 2)" class = "back-btn">Cofnij</button>
                  <button @click.prevent = "deleteAchievement(achievement.id)" class = "delete-btn">Usunąć</button>
                </div>
              </div>

            </div>
          </div>
        </template>
      </template>

    </div>
  </div>
</template>
<script setup lang="js">

import AchievementsNavBar from "~/components/account/achievements/AchievementsNavBar.vue";
let isAddFormOpen = ref(false)

let props = defineProps({
  isAchievementsRefresh:{
    type: Boolean
  }
})
let emit = defineEmits(['openEditForm', 'openAddForm'])

const {
  pending: achievementsPending,
  data: achievementsData,
  error: achievementsError,
  refresh: refreshAchievements
} = await useFetch('http://localhost:8000/api/achievements')

if (achievementsError.value) {
  console.log('!ERROR: Achievements fetch error is ')
  console.log(achievementsError.value)
}
if (achievementsData.value) {
  console.log('Data from get achievements is ')
  console.log(achievementsData.value)
}
watch(() => props.isAchievementsRefresh, () => {
  console.log('Refresh from wrapper')
  refreshAchievements()
})

function openAddForm(){
  emit('openAddForm')
}

function tryDelete(achieveId, index){
  let deleteWrapper = document.getElementById('delete-wrapper-' + achieveId)



  switch(index){
    case 1:
      deleteWrapper.style.display = 'flex'
          break
    case 2:
      deleteWrapper.style.display = 'none'
          break
    default:
      console.warn('ERROR: Error from tryDelete switch. Index is ' + index)
  }
}
async function deleteAchievement(achieveId) {
  const {
    data: achievementDeleteData,
    error: achievementDeleteError,
    pending: achievementDeletePending
  } = await useFetch('http://localhost:8000/api/remove-achievement', {
        method: 'POST',
        body: {
          id: achieveId
        },
      }
  )
  if(achievementDeleteData.value){
    let deleteWrapper = document.getElementById('delete-wrapper-' + achieveId)
    deleteWrapper.style.display = 'none'
    await refreshAchievements()
  }
  if(achievementDeleteError.value){
    console.warn('ERROR: Error from delete achievement is ')
    console.warn(achievementDeleteData.value)
  }
}

</script>

<style scoped>
.achievements-wrapper{
  //border: 1px solid red;
  width: 100%;
  display: flex;
  flex-direction: column;
  height: 100%;
  overflow-y: auto;
}
.achievements-wrapper .no-data{
  font-size: 2rem;
  color: #727272;
  margin-left: 3rem;
}
.achievements-wrapper .server-error{
  margin-left: 3rem;
}
.achievements-wrapper .server-error i{
  margin-right: 0.5rem;
}
.achievements-wrapper .server-error .header-1{
  color: #DE7C7C;
  font-size: 2rem;
}
.achievements-wrapper .server-error .header-2{
  color: #727272;
  font-size: 1rem;
  margin-top: 1.5rem;
  align-items: center;
}
.achievements-wrapper .achievements{
  //border: 1px solid orange;
  flex: 1;
  flex-direction: column;
}
.achievements-wrapper .achievements .wrapper{
  flex-direction: column;
  padding-left: 3rem;
  padding-right: 3rem;
  padding-top: 1rem;
}
.achievements-wrapper .achievements .wrapper .achievement{
  //border: 1px solid red;
  display: flex;
  flex-direction: column;
  height: auto;
  margin-bottom: 1.5rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  background-color: #f8f8f8;
  border-radius: 1rem;

}
.achievements-wrapper .achievements .wrapper .achievement .row-1{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-1{
  display: flex;
  align-items: center;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-1 .id{
  display: flex;
  align-items: center;
  justify-content: center;
  height: 2rem;
  width: 2rem;
  border-radius: 0.25rem;
  background-color: #84dcc6;
  color: white;
  margin-right: 1.5rem;
}
.achievements-wrapper .achievements .wrapper .achievement  .row-1 .clm-1 .img{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 4rem;
  width: 4rem;
  margin-right: 1.5rem;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-1 .img img{
  width: 100%;
  height: 100%;
  overflow: hidden;
  border-radius: 50%;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-1 .title{
  font-size: 1.4rem;
  color: #6d7bbc;

}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-2{
  display: flex;
  align-items: center;
  //border: 1px solid red;
  font-size: 0.9rem;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-2 .btn-edit{
  height: 2rem;
  width: 2rem;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #84DCC6;
  color: white;
  cursor:pointer;
  transition: 0.15s ease;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-2 .btn-edit:hover{
  background-color: #32a88a;
  transition: 0.15s ease;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-2 .btn-edit i{
  display: flex;
  justify-content: center;
  align-items: center;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-2 .btn-delete{
  height: 2rem;
  width: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  background-color:#DE7C7C;
  color: white;
  margin-left: 1rem;
  transition: 0.15s ease;
  cursor:pointer;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-2 .btn-delete:hover{
  background-color: #df6767;
  transition: 0.15s ease;
}
.achievements-wrapper .achievements .wrapper .achievement .row-1 .clm-2 .btn-delete i{
  display: flex;
  justify-content: center;
  align-items: center;
}
.achievements-wrapper .achievements .wrapper .achievement .delete-wrapper{
  height: 5rem;
  display: none;
  align-items: center;
  justify-content: space-between;
}
.achievements-wrapper .achievements .wrapper .achievement .delete-wrapper .panel{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.achievements-wrapper .achievements .wrapper .achievement .delete-wrapper .msg{
  font-size: 1rem;
  color: #727272;

}
.achievements-wrapper .achievements .wrapper .achievement .delete-wrapper .panel .delete-btn{
  padding:1rem;
  background-color: #DE7C7C;
  border-radius: 0.5rem;
  color: white;
  margin-left: 1rem;
  transition: 0.15s ease;
}
.achievements-wrapper .achievements .wrapper .achievement .delete-wrapper .panel .delete-btn:hover{
  background-color: #df6767;
  transition: 0.15s ease;
}
.achievements-wrapper .achievements .wrapper .achievement .delete-wrapper .panel .back-btn{
  color: #727272;
}
</style>