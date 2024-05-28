<template>
  <div class="container">
    <NavBar/>
    <div class="local-container">
      <template v-if="!lessonData">
        <div class="no-data-wrapper">
          <div class="row-1">
            <p class="error-header-1">Błąd servera:</p>
            <p class="error-header-2">brak danych</p>
          </div>
          <p class="error-content">{{ lessonError }}</p>
          <p v-if="!lessonPending" @click.prevent=refreshLesson class="refresh-btn">Odświerz dane</p>
          <p v-else class="refreshing">Odświerzanie...</p>
        </div>
      </template>
      <template v-else>
        <div class="lesson-wrapper">
          <div class="row-1">
            <p class="lesson-title">{{ lessonData.lesson.title }}</p>
            <p class="title-divide">/</p>
            <p class="section-title">{{sectionData.section[0].title}}</p>
          </div>
          <div class="row-2">
            <p>{{lessonData.lesson.description}}</p>
          </div>
          <div class="lesson-nav-bar">
            <p @click.prevent = "selectSection(1)" id = "content-btn" class = "btn-1">Zajęcie</p>
            <p @click.prevent = "selectSection(2)" id = "test-btn">Test</p>
            <p @click.prevent = "selectSection(3)" id = "dictionary-btn">Słownik</p>
          </div>
          <p id = "section-header-2" class = "section-header-2">Zajęcie</p>
          <div class="lesson-content-wrapper">
            <div id = "content-section" class="content-section">
              <LessonContentSectionUser :lesson-url = "lessonData.lesson.lessonUrl" :lesson-content = "lessonData.lesson.content"/>
            </div>
            <div id = "test-section" class="test-section">
              <LessonTestSectionUser :test-id = lessonData.lesson.testId />
            </div>
            <div id = "dictionary-section" class="dictionary-section">
              <LessonDictionarySectionUser :lesson-id = lessonData.lesson.id />
            </div>
          </div>
        </div>
      </template>
      <Footer/>
    </div>
  </div>
</template>
<script setup>
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import LessonContentSection from "~/components/account/lessons/lesson_page/LessonContentSection.vue";
import LessonTestSection from "~/components/account/lessons/lesson_page/LessonTestSection.vue";
import LessonDictionarySection from "~/components/account/lessons/lesson_page/LessonDictionarySection.vue";
import DifficultyPanel2 from "~/components/account/lessons/DifficultyPanel2.vue";
import SectionPageLessonWrapperUser from "~/components/home/SectionPageLessonWrapperUser.vue";
import NavBar from "~/components/home/NavBar.vue";
import LessonContentSectionUser from "~/components/home/LessonContentSectionUser.vue";
import LessonTestSectionUser from "~/components/home/LessonTestSectionUser.vue";
import LessonDictionarySectionUser from "~/components/home/LessonDictionarySectionUser.vue";

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (!data.value) {
        return navigateTo('/')
      }
    }
  ]
})

const route = useRoute()
const uniqId = route.params.uniqid
let sectionData = ref()

const {
  data: lessonData,
  error: lessonError,
  refresh: refreshLesson,
  pending: lessonPending
} = await useFetch('http://localhost:8000/api/lesson-by-uniqid', {
      method: 'POST',
      body: {
        uniqid: uniqId
      }
    }
)
if (lessonData.value) {
  console.warn('Lesson data is ')
  console.warn(lessonData.value)

  const {
    data: lessonSectionData,
    error: lessonSectionError,
    refresh: refreshLessonSection,
    pending: lessonSectionPending
  } = await useFetch('http://localhost:8000/api/section-by-id', {
        method: 'POST',
        body: {
          id: lessonData.value.lesson.sectionId
        }
      }
  )
  if (lessonSectionData.value) {
    console.log('Section data is ')
    console.log(lessonSectionData.value)
    sectionData.value = lessonSectionData.value
  }
  if (lessonSectionError.value) {
    console.log('ERROR: Error from lesson section error is ')
    console.log(lessonSectionError.value)
  }
}
if (lessonError.value) {
  console.warn('Error: Error from sectionError is ')
  console.warn(lessonError.value)
}
function selectSection(index){
  let contentSection = document.getElementById('content-section')
  let testSection = document.getElementById('test-section')
  let dictionarySection = document.getElementById('dictionary-section')
  let contentBtn = document.getElementById('content-btn')
  let testBtn = document.getElementById('test-btn')
  let dictionaryBtn = document.getElementById('dictionary-btn')
  let sectionHeader = document.getElementById('section-header-2')
  switch (index){
    case 1:
      sectionHeader.innerText = 'Zajęcie'
      contentSection.style.display = 'flex'
      dictionarySection.style.display = 'none'
      testSection.style.display = 'none'
      contentBtn.style.backgroundColor = '#6D7BBC'
      contentBtn.style.borderRadius = 0.5 + 'rem'
      testBtn.style.backgroundColor  = 'transparent'
      dictionaryBtn.style.backgroundColor = 'transparent'
      break
    case 2:
      sectionHeader.innerText = 'Test'
      contentSection.style.display = 'none'
      dictionarySection.style.display = 'none'
      testSection.style.display = 'flex'
      testBtn.style.borderRadius = 0.5 + 'rem'
      contentBtn.style.backgroundColor = 'transparent'
      testBtn.style.backgroundColor  = '#6D7BBC'
      dictionaryBtn.style.backgroundColor = 'transparent'
      break
    case 3:
      sectionHeader.innerText = 'Słownik'
      contentSection.style.display = 'none'
      dictionarySection.style.display = 'flex'
      testSection.style.display = 'none'
      dictionaryBtn.style.borderRadius = 0.5 + 'rem'
      contentBtn.style.backgroundColor = 'transparent'
      testBtn.style.backgroundColor  = 'transparent'
      dictionaryBtn.style.backgroundColor = '#6D7BBC'
      break
    default:
      console.warn('ERROR: Error from select section. Index is ' + index)
      break
  }
}

</script>
<style scoped>
.local-container {
  display: flex;
  height: auto;
  flex-direction: column;
  padding-bottom: 1.5rem;
  justify-content: center;
}
.local-container .no-data-wrapper {
//border: 1px solid red; width: 100%;
  display: flex;
  flex-direction: column;
}

.local-container .no-data-wrapper .row-1 {
  display: flex;
  align-items: end;
}

.local-container .no-data-wrapper .row-1 .error-header-1 {
  font-size: 3rem;
  color: #DE7C7C;
}

.local-container .no-data-wrapper .row-1 .error-header-2 {
  font-size: 2.5rem;
  color: #727272;
  margin-left: 0.5rem;
}

.local-container .no-data-wrapper .error-content {
  margin-top: 2rem;
  margin-bottom: 2rem;
  font-size: 1rem;
  color: #727272;
}

.local-container .no-data-wrapper .refresh-btn {
  font-size: 1.3rem;
  cursor: pointer;
  color: #727272;
}

.local-container .no-data-wrapper .refreshing {
  font-size: 1.3rem;
  color: #727272;
}

.local-container .no-data-wrapper .refresh-btn:hover {
  text-decoration: underline;
}

.local-container .lesson-wrapper {
//border: 1px solid red;
  width: 100%;
//display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding-left: 10rem;
  padding-right: 10rem;

}

.local-container .lesson-wrapper .row-1 {
//border: 1px solid green;
  height: 5rem;
  display: flex;
  align-items: center;
}

.local-container .lesson-wrapper .row-1 .lesson-title {
  font-size: 2.5rem;
  color: #6D7BBC;
}
.local-container .lesson-wrapper .row-1 .title-divide {
  font-size: 2rem;
  margin-left: 1rem;
  margin-right: 1rem;
  color: #8B95C9;
}
.local-container .lesson-wrapper .row-1 .section-title {
  font-size: 2rem;
  color: #8B95C9;
  cursor: pointer;
}
.local-container .lesson-wrapper .row-1 .section-title:hover{
  color: #6D7BBC;
}
.local-container .lesson-wrapper .row-2{
//border: 1px solid orange;
  height: 3rem;
  display: flex;
  align-items: center;
  color: #727272;
  font-size: 1.1rem;
  width: 100%;
  line-height: 1.5rem;
}
.local-container .lesson-wrapper .lesson-nav-bar{
  border-radius: 0.5rem;
  margin-top: 1rem;
  width: 25%;
  height: 3rem;
  background-color: #8B95C9;
  display: flex;
  align-items: center;
  justify-content: space-between;
  color: white;
  padding-right: 1.5rem;
  padding-left: 1.5rem;
}
.local-container .lesson-wrapper .lesson-nav-bar p{
  cursor: pointer;
  padding: 0.5rem;
  transition: 0.10s ease;
}
.local-container .lesson-wrapper .lesson-nav-bar p:hover{
  padding: 0.5rem;
  background-color: #6D7BBC;
  border-radius: 0.5rem;
  transition: 0.10s ease;
}
.local-container .lesson-wrapper .lesson-nav-bar .btn-1{
  padding: 0.5rem;
  background-color: #6D7BBC;
  border-radius: 0.5rem;
}
.local-container .lesson-wrapper .section-header-2{
  font-size: 2.5rem;
  color: #727272;
  margin-top: 2rem;
  margin-bottom: 2rem;
}
.local-container .lesson-wrapper .lesson-content-wrapper{
  margin-top: 1rem;
  border-radius: 1rem;
  height: auto;
  background-color: #f8f8f8;
//border: 1px solid red;
  flex-direction: column;
  align-items: center;
  width: 100%;
  padding: 2rem;
}
.local-container .lesson-wrapper .lesson-content-wrapper .content-section{
  display: flex;
  width: 100%;
  height: auto;

}
.local-container .lesson-wrapper .lesson-content-wrapper .test-section{
  display: none;
  width: 100%;
  height: auto;
}
.local-container .lesson-wrapper .lesson-content-wrapper .dictionary-section{
  display: none;
  width: 100%;
  height: auto;
}


</style>