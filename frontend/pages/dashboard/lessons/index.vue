<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="clm-1">
          <LessonSettingsNavBar @is-form = "updateIsForm()" @refresh = "refreshSections" :isPending = "lessonSectionsPending"/>
          <LessonSectionWrapper id = "lesson-section-wrapper"
                                :lesson-sections = lessonSections
                                :lesson-sections-pending = lessonSectionsPending
                                :refresh-lesson-sections = refreshLessonSections
          />
          <AddLessonSectionForm id = "add-lesson-section-form" :refresh-sections = "refreshLessonSections"/>
        </div>
        <div class="clm-2">
          <LessonsWrapper/>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import LessonSectionWrapper from "~/components/account/lessons/LessonSectionWrapper.vue";
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import LessonSettingsNavBar from "~/components/account/lessons/LessonSettingsNavBar.vue";
import LessonsWrapper from "~/components/account/lessons/LessonsWrapper.vue";
import AddLessonSectionForm from "~/components/account/lessons/AddLessonSectionForm.vue";
let isForm = false


const {pending: lessonSectionsPending, data: lessonSections, refresh: refreshLessonSections} = await useFetch('http://localhost:8000/api/lesson-sections')



onMounted(async () => {
  let addLessonSectionForm = document.getElementById('add-lesson-section-form')
  addLessonSectionForm.style.display = 'none'
});
function refreshSections(){
  console.log('Refresh function')
  refreshLessonSections()
}
function updateIsForm(){
  let lessonSectionWrapper = document.getElementById('lesson-section-wrapper')
  let addLessonSectionForm = document.getElementById('add-lesson-section-form')
  if(!isForm){
    lessonSectionWrapper.style.display = 'none'
    addLessonSectionForm.style.display = 'flex'
    isForm = !isForm
  }else{
    addLessonSectionForm.style.display = 'none'
    lessonSectionWrapper.style.display = 'flex'
    isForm = !isForm
  }

}

</script>
<style scoped>
add-lesson-section-form{
  display: none;
}
lesson-section-wrapper{
  display: flex;
}
.local-container {
  //border: 1px solid red;
  display: flex;
  width: 100%;
  height: 100%;

}

.local-container .main{
  //border: 1px solid green;
  display: flex;
  flex: 1;
}
.local-container .main .clm-1{
  width: 65%;
  display: flex;
  flex-direction: column;
  height: 100%;
}
.local-container .main .clm-2{
  display: flex;
  flex: 1;
  flex-direction: column;
  //border: 1px solid red;
}
</style>