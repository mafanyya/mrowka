
<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="profile-wrapper">
          <div class="profile-row-1">
            <div class="clm-1">
              <div class="avatar">
                <img :src="sectionData.section[0].img" alt="">
              </div>
              <div class="credentials">
                <p class = 'title'>{{sectionData.section[0].title}}</p>
                <p class = 'uniqid'>@{{sectionData.section[0].uniqId}}</p>
              </div>
              <div class="difficulty">
                <p>Trudność:</p>
                <DifficultyPanel :index= "sectionData.section[0].difficulty" :id = "sectionData.section[0].id"/>
              </div>
            </div>

            <NuxtLink to = "/dashboard/lessons">
              <div class="home-btn">
                <i class="fi fi-sr-book-bookmark"></i>
                <p>Sekcję</p>
              </div>
            </NuxtLink>
          </div>
          <div class="profile-row-2">
            <div id = "setting-section" class="setting-section">
              <p>Ustawienia</p>
              <div class="panel">
                <div class="row">
                  <i class="fi fi-sr-bullet"></i>
                  <p @click.prevent = "changeSection(1)">Zajęcia</p>
                </div>
                <div class="row">
                  <i class="fi fi-sr-bullet"></i>
                  <p @click.prevent = "changeSection(2)">Edytuj sekcję</p>
                </div>
                <div class="row">
                  <i class="fi fi-sr-bullet"></i>
                  <p @click.prevent = "changeSection(3)">Dodaj zajęcie</p>
                </div>
                <div class="row">
                  <i class="fi fi-sr-bullet"></i>
                  <p @click.prevent = "changeSection(4)">Usuń sekcję</p>
                </div>
              </div>
              <div id = "delete-panel" class="delete-panel">
                <div class="row-1">
                  <p>Czy na pewno chcesz usunąć zajęcie?</p>
                </div>
                <div class="row-2">
                  <p @click.prevent = "deletePanelAction(0)">Odrzuć</p>
                  <button @click.prevent = "deletePanelAction(1)">Usuń zajęcie</button>
                </div>
              </div>
              <p id = "delete-message" class = "delete-message"></p>
            </div>
            <div class="credentials-section">

              <div id = "lessons" class="lessons">
                <SectionPageLessonWrapper
                    :section-uniqid = "uniqId"
                    :is-lessons-refresh = "isRefresh"
                    @is-form-open = "openLessonEditForm"
                    @try-delete-lesson = "openDeletePanel"
                />
              </div>
              <div id = "lesson-edit" class="lesson-edit">
                  <LessonEditForm v-if = "formLessonId" :lessonId = formLessonId @refresh-lessons = isRefreshToggle />
              </div>

              <div id = "section-edit" class="section-edit">
                  <SectionEditForm v-if = "sectionData" :uniq-id = uniqId @refresh-lesson-section = refreshSection />
              </div>

              <div id = "lesson-add" class="lesson-add">
                  <LessonAddForm v-if = "sectionData" :uniq-id = uniqId @refresh-lessons = isRefreshToggle />
              </div>
              <div id = "section-delete" class="section-delete">
                <SectionDeleteForm v-if = "sectionData" :uniq-id = uniqId />
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
import SectionPageLessonWrapper from "~/components/account/lessons/section_page/SectionPageLessonWrapper.vue";
import DifficultyPanel from "~/components/account/lessons/DifficultyPanel.vue";
import LessonEditForm from "~/components/account/lessons/section_page/LessonEditForm.vue";
import SectionEditForm from "~/components/account/lessons/section_page/SectionEditForm.vue";
import LessonAddForm from "~/components/account/lessons/section_page/LessonAddForm.vue";
import SectionDeleteForm from "~/components/account/lessons/section_page/SectionDeleteForm.vue";

const route = useRoute()
const uniqId = route.params.uniqid
let formLessonId = ref()
let isRefresh = ref(false)


const {data: sectionData, error: sectionError, refresh: refreshSection, pending: sectionPending} = await useFetch('http://localhost:8000/api/section-by-uniqid', {
      method: 'POST',
      body: {
        uniqid: uniqId
      }
    }
)

if(sectionData.value){
  console.warn('Section data is ')
  console.warn(sectionData.value)
}
if(sectionError.value){
  console.warn('Error: Error from sectionError is ')
  console.warn(sectionError.value)
}

function openLessonEditForm(lessonId){
  console.log('OPEN FORM ID IS ' + lessonId)
  formLessonId.value = lessonId
  let lessonsSection = document.getElementById('lessons')
  let lessonFormSection = document.getElementById('lesson-edit')
  lessonsSection.style.display = 'none'
  lessonFormSection.style.display = 'flex'
}
function changeSection(section){
  let lessonsSection = document.getElementById('lessons')
  let editLessonSection = document.getElementById('lesson-edit')
  let editSectionSection = document.getElementById('section-edit')
  let addLessonSection = document.getElementById('lesson-add')
  let deleteSectionSection = document.getElementById('section-delete')

  switch (section){
    case 1:
      lessonsSection.style.display = 'flex'
      editLessonSection.style.display = 'none'
      editSectionSection.style.display = 'none'
      addLessonSection.style.display = 'none'
      deleteSectionSection.style.display = 'none'
      break
    case 2:
      lessonsSection.style.display = 'none'
      editLessonSection.style.display = 'none'
      editSectionSection.style.display = 'flex'
      addLessonSection.style.display = 'none'
      deleteSectionSection.style.display = 'none'
      break
    case 3:
      lessonsSection.style.display = 'none'
      editLessonSection.style.display = 'none'
      editSectionSection.style.display = 'none'
      addLessonSection.style.display = 'flex'
      deleteSectionSection.style.display = 'none'
      break
    case 4:
      lessonsSection.style.display = 'none'
      editLessonSection.style.display = 'none'
      editSectionSection.style.display = 'none'
      addLessonSection.style.display = 'none'
      deleteSectionSection.style.display = 'flex'
      break
    default:
      console.warn('ERROR: Error from change section. Undefined section index: ' + section)
      break
  }

}
function isRefreshToggle(){
  isRefresh.value = !isRefresh.value
  console.log('REFRESH TOGGLE')
  console.log(isRefresh)
}
let deleteLessonId = ref()
function openDeletePanel(lessonId){
  let deletePanel = document.getElementById('delete-panel')
  let settingSection = document.getElementById('setting-section')
  let deleteMessage = document.getElementById('delete-message')
  deleteMessage.style.display = 'none'
  settingSection.style.height = 20 + 'rem'
  deletePanel.style.display = 'flex'
  deleteLessonId.value = lessonId

}
async function deletePanelAction(index) {
  let deletePanel = document.getElementById('delete-panel')
  let settingSection = document.getElementById('setting-section')
  let deleteMessage = document.getElementById('delete-message')
  switch (index) {
    case 0:
      settingSection.style.height = 12 + 'rem'
      deletePanel.style.display = 'none'
      deleteLessonId.value = null
      break
    case 1:
      const {
        data: deleteLessonData,
        error: deleteLessonError,
        pending: deleteLessonPending
      } = await useFetch('http://localhost:8000/api/remove-lesson', {
            method: 'POST',
            body: {
              id: deleteLessonId.value
            }
          }
      )
          console.log('Delete lesson id is ' + deleteLessonId.value)
          if(deleteLessonData.value){
            console.log('Delete lesson data is ')
            console.log(deleteLessonData.value)
            settingSection.style.height = 12 + 'rem'
            deletePanel.style.display = 'none'
            deleteLessonId.value = null
            isRefresh.value = !isRefresh.value
            deleteMessage.style.display = 'block'
            deleteMessage.style.color = 'green'
            deleteMessage.innerText = 'Zajęcię pomyślnie usunięte'

          }
          if(deleteLessonError.value){
            console.log('ERROR: Delete lesson error is ')
            console.log(deleteLessonError.value)
            deleteMessage.style.display = 'block'
            deleteMessage.style.color = '#DE7C7C'
            deleteMessage.innerText = 'Nie udało się usunąć zajęcie'
          }

  }
}

</script>
<style scoped>
.local-container {
//border: 1px solid red;
  display: flex;
  width: 100%;
  height: 100%;
//overflow-y: auto;
}

.local-container .main{
//border: 1px solid green;
  display: flex;
  flex: 1;
  height: 100%;
  justify-content: center;
}

.local-container .main .profile-wrapper{
 //border: 1px solid purple;
  height: 100%;
  width: 85%;
  display: flex;
  align-items: center;
  flex-direction: column;
}
.local-container .main .profile-wrapper .profile-row-1{
  //border: 1px solid grey;
  width: 100%;
  height: 8rem;
  margin-top: 3rem;
  background-color: #f8f8f8;
  border-radius: 1em;
  display: flex;
  padding: 1rem 2rem;
  align-items: center;
  justify-content: space-between;
}
.local-container .main .profile-wrapper .profile-row-1 .clm-1{
//border: 1px solid purple;
  height: 100%;
  display: flex;
  align-items: center;
}
.local-container .main .profile-wrapper .profile-row-1 .clm-1 .avatar{
//border: 1px solid blue;
  width: 5.5rem;
  height: 5.5rem;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}
.local-container .main .profile-wrapper .profile-row-1 .clm-1 .avatar img{
  overflow: hidden;
  height: 100%;
  width: 100%;
  border-radius: 50%;
}
.local-container .main .profile-wrapper .profile-row-1 .clm-1 .credentials{
//border: 1px solid purple;
  height: 65%;
  display: flex;
  justify-content: space-between;
  flex-direction: column;
  margin-left: 2rem;
}
.local-container .main .profile-wrapper .profile-row-1 .clm-1 .difficulty{
  //border: 1px solid red;
  height: 80%;
  width: 12rem;
  margin-left: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: #727272;
}
.local-container .main .profile-wrapper .profile-row-1 .clm-1 .difficulty p{
  margin-right: 1.5rem;
}
.local-container .main .profile-wrapper .profile-row-1  .role i{
  margin-right: 0.25rem;
}
.local-container .main .profile-wrapper .profile-row-1 .home-btn{
//border: 1px solid red;
  height: 4.5rem;
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
.local-container .main .profile-wrapper .profile-row-1 .home-btn:hover{
  background: #239076;
}
.local-container .main .profile-wrapper .profile-row-1 .home-btn p{
  margin-left: 0.5rem;
}
.local-container .main .profile-wrapper .profile-row-1 .credentials .title{
  font-size: 2rem;
  color: #6D7BBC;
  transition: 1s ease;

}
.local-container .main .profile-wrapper .profile-row-1 .credentials .uniqid{
  color: #727272;
//font-weight: 500;
  font-size: 1rem;
  transition: 1s ease;
}

.local-container .main .profile-wrapper .profile-row-2{
  //border: 3px solid orange;
  width: 100%;
  height: 10rem;
  margin-top: 3rem;
  display: flex;
  flex: 1;
  margin-bottom: 1rem;
  //margin-bottom: 4rem;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section{
  color: #727272;
//border: 1px solid purple;
  height: 15rem;
  width: 18rem;
  background-color: #f8f8f8;
  border-radius: 1em;
  padding: 2rem;
  font-size: 1.1rem;
  display: flex;
  flex-direction: column;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-panel{
  //border: 1px solid red;
  display: none;
  flex-direction: column;
  flex: 1;
  margin-top: 1rem;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-panel .row-1{
  //border: 1px solid red;
  height: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1rem;
  color: #DE7C7C;
  text-align: center;
  line-height: 1.2rem;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-panel .row-2{
  //border: 1px solid red;
  height: 50%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-left: 1rem;
  padding-right: 1rem;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-panel .row-2 p{
  font-size: 0.9rem;
  color: #727272;
  cursor: pointer;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-panel .row-2 p:hover{
  text-decoration: underline;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-panel .row-2 button{
  font-size: 1rem;
  //border: 1px solid blue;
  height: 80%;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
  color: white;
  background-color: #DE7C7C;
  border-radius: 0.5rem;
  transition: 0.15s ease;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-panel .row-2 button:hover{
  background-color: #c56d6d;
  transition: 0.15s ease;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .delete-message{
  margin-top: 3rem;
  margin-bottom: 1rem;
  display: none;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel{
//border: 1px solid purple;
//margin-left: 1rem;
  margin-top: 1.5rem;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel .row{
  display: flex;
//border: 1px solid grey;
  margin-bottom: 0.5rem;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel .row p{
  margin-left: 0.5rem;
  cursor: pointer;
}
.local-container .main .profile-wrapper .profile-row-2 .setting-section .panel .row p:hover{
  text-decoration: underline;
}
.local-container .main .profile-wrapper .profile-row-2 .credentials-section{
//border: 1px solid purple;
  margin-left: 3rem;
  display: flex;
  flex: 1;
  flex-direction: column;
  background-color: #f8f8f8;
  border-radius: 1em;
}
.local-container .main .profile-wrapper .profile-row-2 .credentials-section .lessons{
  display: flex;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;
  border-radius: 1em;

}

.local-container .main .profile-wrapper .profile-row-2 .credentials-section .lesson-edit{
  display: none;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;

}
.local-container .main .profile-wrapper .profile-row-2 .credentials-section .section-edit{
  display: none;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;
}
.local-container .main .profile-wrapper .profile-row-2 .credentials-section .lesson-add{
  display: none;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;
}
.local-container .main .profile-wrapper .profile-row-2 .credentials-section .section-delete{
  display: none;
  flex-direction: column;
  padding: 2rem;
  width: 100%;
  height: 100%;
}
</style>