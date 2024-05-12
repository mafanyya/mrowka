<template>
<div class="dictionary-wrapper">
  <div class = "words">
    <DictionarySettingsNavBar @update-form = "updateAddForm" :is-pending = "checkIsPending()"/>
    <div class="words-wrapper">
      <template v-if = "!words">
        <div class="data-error">
          <div class="clm-1">
            <p class = "header-1">Bład servera</p>
            <p class = "header-2">Brak danych</p>
            <p class = "error-header">{{wordsError}}</p>
            <p v-if = "wordsPending" class = "pending">Odświerzanie...</p>
            <p v-else class = "refresh" @click.prevent = "refreshWords">Odświerz dane</p>
          </div>
          <div class="clm-2">
          </div>
        </div>
      </template>
      <template v-else>
        <div v-if = "wordsData.words.length === 0" class = "no-words">
          <i class="fi fi-ss-cloud-question"></i>
          <p>Nie znaleziono słów w tej sekcji</p>
        </div>
        <template v-for = "word in words.words">
          <div class="word">
            <div class="clm-1">
              <div class="id">
                <p>{{word.id}}</p>
              </div>
              <div class="section">
                <div class="section-img">
                  <img :src="word.lessonImg" alt="">
                </div>
              </div>
              <div class="clm-1-1">
                <div class="name">
                  <p>{{word.name}}</p>
                </div>
                <div class="translation">
                  <p>{{word.translation}}</p>
                </div>
              </div>
            </div>
            <div class="clm-2">

              <div class="lesson-id">
<!--                <p>{{word.lessonId}}</p>-->
                <i class="fi fi-sr-book-bookmark"></i>
              </div>
            </div>
          </div>
        </template>
      </template>
    </div>
  </div>
  <div id = "settings-wrapper" class="settings-wrapper">
    <div class="header">
      <p id = "settings-header">Sortowanie</p>
    </div>
    <div id = "sections-wrapper" class="sections-wrapper">
      <template v-if = "!sectionsData">
        <p>Brak danych</p>
        <p @click.prevent = "refreshSections" v-if = "!sectionsPending">Odśwież dane</p>
        <p v-else>Odświeżanie...</p>
      </template>
      <template v-else>
        <div class="all-row">
          <div class="img">
            <img src="~/assets/images/sections/sheep.png" alt="">
          </div>
          <p @click.prevent = "findAllWords()" class = "title">Wszystkie</p>
        </div>
        <template v-for = "section in sectionsData.sections">
          <div class="section">
            <div class="row-1">
              <div class="img">
                <img :src="section.img" alt="">
              </div>
              <p @click.prevent = "findWordsBySection(section.id)" class = "title">{{section.title}}</p>
            </div>
            <div class="lessons">
              <template v-if = "!sectionsData.lessons">
                <p>No lessons</p>
              </template>
              <template v-else>
                <template v-for = "lesson in sectionsData.lessons">
                  <template v-if = "lesson.sectionId === section.id">
                    <div class="lesson">
                      <i class="fi fi-ss-circle"></i>
                      <p @click.prevent = "findWordsByLesson(lesson.id)" class = "lesson-title">{{lesson.title}}</p>
                    </div>
                  </template>
                </template>
              </template>
            </div>
          </div>
        </template>
      </template>
    </div>
    <div id = "add-word-form" class="word-form">
      <form @submit.prevent = "addWord()" id = "add-form">
        <p id = "form-error" class = "form-error"></p>
        <label for="name-input">Słowo</label>
        <div class="input-1">
          <input
              v-model="name"
              id = "name-input"
              type = "text"
              maxlength="30"
              minlength="1"
              placeholder=""
              required>
        </div>
        <label for="translation-input">Tłumaczenie</label>
        <div class="input-2">
          <input
              v-model="translation"
              id = "translation-input"
              type = "text"
              maxlength="30"
              minlength="1"
              required>
        </div>
        <label for="lesson-input">Zajęcie</label>
        <div @click.prevent = "openLessonsOptions()" class="input-3">
          <input
              v-model="lessonId"
              id = "lesson-input"
              type = "text"
              placeholder="Wybierz zajęcie"
              readonly
              required>
          <div @click.prevent = "openLessonsOptions()" id = "icon-input" class="icon-input">
            <i id = "unfold-icon" class="fi fi-br-angle-circle-down"></i>
          </div>
        </div>
        <div id = "lesson-options" class="lessons-options">
          <template v-if = "!sectionsData">
            <p class = "lessons-options-error">Bład servera: Brak danych</p>
          </template>
          <template v-else>
            <div class="lesson-options-wrapper">
              <template v-for = "lesson in sectionsData.lessons">
                <div @click.prevent = "selectLessonValue(lesson.id)" class="lesson">
                  <p class = "id">{{lesson.id}}</p>
                  <div class="img">
                    <img :src="lesson.img" alt="">
                  </div>
                  <p class = "title">{{lesson.title}}</p>
                </div>
              </template>
            </div>
          </template>
        </div>
        <button type = "submit">Dodaj słowo</button>
      </form>
    </div>
  </div>
</div>
</template>

<script setup lang="js">
import DictionarySettingsNavBar from "~/components/account/dictionary/DictionarySettingsNavBar.vue";

let words = null
let name = ref('')
let translation = ref('')
let lessonId = ref('')

let byLessonPending
let bySectionPending
let allWordPending
let addWordPending


const {pending: wordsPending, data: wordsData, error: wordsError, refresh: refreshWords} = await useFetch('http://localhost:8000/api/words')
if(wordsError.value){
  console.log('!ERROR: Words fetch error is ')
  console.log(wordsError.value)
}
if(wordsData.value){
  words = wordsData
}

const {pending: sectionsPending, data: sectionsData, error: sectionsError, refresh: refreshSections} = await useFetch('http://localhost:8000/api/lesson-sections')

if(sectionsError.value){
  console.log('!ERROR: Sections fetch error is ')
  console.log(sectionsError.value)
}
if(sectionsData.value){
  console.log('Data from getSections is ')
  console.log(sectionsData.value)
}
async function addWord(){
  if(!validateWordName(name.value)){
    createError(400)
  }else{
    if(!validateWordTranslation(translation.value)){
      createError(401)
    }else{
      name.value = convertName(name.value)
      translation.value = convertTranslation(translation.value)
      const {data: wordAddData, error: wordAddError, pending: wordAddPending} = await useFetch('http://localhost:8000/api/add-word', {
            method: 'POST',
            body: {
              name: name.value,
              translation: translation.value,
              lessonId: lessonId.value
            },
          }
      )
      let addForm = document.getElementById('add-form')
      addForm.reset()

      console.log('NAme is '+ name.value)
      console.log('Translation is '+ translation.value)
      console.log('LessonId is '+ lessonId.value)
      if(wordAddData.value){
        createError(100)
        addWordPending = wordAddPending
      }
      if(wordAddError.value){
        createError(500)
        console.warn('ERROR: From addWord function. Error is ')
        console.warn(wordAddError.value)
      }
    }
  }
}
function createError(errorCode){
  const formError =  document.getElementById('form-error')
  switch (errorCode){
    case 100:
      formError.style.visibility = 'visible'
      formError.style.color = 'green'
      formError.innerText = 'Słowo dodane pomyślnie'

      break
    case 400:
      formError.style.visibility = 'visible'
      formError.innerText = 'Nieprawidłowe słowo'
      break
    case 401:
      formError.style.visibility = 'visible'
      formError.innerText = 'Niprawidłowe tłumaczenie'
      break
    case 500:
      formError.style.visibility = 'visible'
      formError.innerText = 'Bląd servera'
      break
    default:
      formError.style.visibility = 'visible'
      formError.innerText = 'Nieznany bład ' + errorCode

  }
}
function convertName(wordName){
  return wordName
      .split(/\s+/)
      .map(word => {

        if (word.length === 0) {
          return '';
        } else if (word[0] === word[0].toUpperCase()) {
          return word[0] + word.slice(1).toLowerCase();
        } else {
          return word.toLowerCase();
        }
      })
      .join(' ');
}
function convertTranslation(wordTranslation){
  return wordTranslation
      .split(/\s+/)
      .map(word => {
        if (word.length === 0) {
          return ''; //
        } else if (word[0] === word[0].toUpperCase()) {
          return word[0] + word.slice(1).toLowerCase();
        } else {
          return word.toLowerCase();
        }
      })
      .join(' ');
}
function validateWordName(wordName){
  const re = /^[a-zA-Zа-яА-Я]+$/;
  return re.test(wordName)
}
function validateWordTranslation(wordTranslation){
  const re = /^[a-zA-Zа-яА-Я]+$/;
  return re.test(wordTranslation)
}
async function findAllWords(){
  const {pending: allWordsPending, data: allWordsData, error: wordsError, refresh: refreshWords} = await useFetch('http://localhost:8000/api/words')
  if(allWordsData.value){
    allWordPending = allWordsPending
    wordsData.value = allWordsData.value
  }

}
async function findWordsBySection($sectionId){
  const {data: wordsBySectionData, error: wordsBySectionError, pending: wordsBySectionsPending} = await useFetch('http://localhost:8000/api/words-by-section', {
        method: 'POST',
        body: {
          'sectionId': $sectionId
        },
      }
  )
  if(wordsBySectionData.value) {
    bySectionPending = wordsBySectionsPending
    wordsData.value = wordsBySectionData.value
  }

}
async function findWordsByLesson($lessonId){
  const {data: wordsByLessonData, error: wordsByLessonError, pending: wordsByLessonsPending} = await useFetch('http://localhost:8000/api/words-by-lesson', {
        method: 'POST',
        body: {
          'lessonId': $lessonId
        },
      }
  )
  if(wordsByLessonData.value){
    byLessonPending = wordsByLessonsPending
    wordsData.value = wordsByLessonData.value
  }
}
function updateAddForm(index){
  let sectionsWrapper = document.getElementById('sections-wrapper')
  let settingsHeader = document.getElementById('settings-header')
  let addWordForm = document.getElementById('add-word-form')
  if(index){
    console.warn('Form is open')
    sectionsWrapper.style.display = 'none'
    settingsHeader.innerText = 'Dodaj słowo'
    addWordForm.style.display = 'flex'
  }else{
    console.warn('Form is closed')
    sectionsWrapper.style.display = 'flex'
    settingsHeader.innerText = 'Sortowanie'
    addWordForm.style.display = 'none'
  }
}
let isLessonsSettingsOpen = false
function openLessonsOptions(){
  let unfoldIcon = document.getElementById('unfold-icon')
  let iconInput = document.getElementById('icon-input')
  let lessonInput = document.getElementById('lesson-input')
  let lessonOptions = document.getElementById('lesson-options')

  if(!isLessonsSettingsOpen){
    unfoldIcon.className = 'fi fi-br-angle-circle-up'
    iconInput.style.borderBottomRightRadius = '0'
    lessonInput.style.borderBottomLeftRadius = '0'
    lessonOptions.style.display = 'flex'
    isLessonsSettingsOpen = !isLessonsSettingsOpen
  }else{
    unfoldIcon.className = 'fi fi-br-angle-circle-down'
    iconInput.style.borderBottomRightRadius = '0.5rem'
    lessonInput.style.borderBottomLeftRadius = '0.5rem'
    lessonOptions.style.display = 'none'
    isLessonsSettingsOpen = !isLessonsSettingsOpen
  }
}
function selectLessonValue(id){
  let lessonInput = document.getElementById('lesson-input')
  let unfoldIcon = document.getElementById('unfold-icon')
  let iconInput = document.getElementById('icon-input')
  let lessonOptions = document.getElementById('lesson-options')
  unfoldIcon.className = 'fi fi-br-angle-circle-down'
  iconInput.style.borderBottomRightRadius = '0.5rem'
  lessonInput.style.borderBottomLeftRadius = '0.5rem'
  lessonOptions.style.display = 'none'
  isLessonsSettingsOpen = !isLessonsSettingsOpen
  lessonInput.value = id
  lessonId.value = id
}
function checkIsPending(){
  console.log(byLessonPending)
  console.log(bySectionPending)
  console.log(allWordPending)
  console.log(addWordPending)
  return !!(wordsPending === true || addWordPending === true || allWordPending === true  || bySectionPending === true  || byLessonPending === true)
}
</script>

<style scoped>
.dictionary-wrapper{
  //border: 1px solid purple;
  width: 100%;
  height: 100%;
  display: flex;
}
.dictionary-wrapper .words{
  width: 70%;
  //border: 1px solid purple;
  height: 100%;
  display: flex;
  flex-direction: column;
}
.dictionary-wrapper .settings-wrapper{
  display: flex;
  flex: 1;
  //border: 1px solid purple;
  height: 100%;
  flex-direction: column;
}
.dictionary-wrapper .settings-wrapper .header{
  background-color: #6D7BBC;
  height: 6rem;
  width: 100%;
  display: flex;
  align-items: center;
  padding-left: 1rem;
  font-size: 1.5rem;
  color: white;


}
.dictionary-wrapper .settings-wrapper .sections-wrapper{
  //border: 1px solid red;
  width: 100%;
  display: flex;
  flex-direction: column;
  flex: 1;
  overflow-y: auto;
  padding-bottom: 1rem;
  //padding-top: 1rem;
  transition: 1s ease;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .all-row{
  display: flex;
  align-items: center;
  background-color: #D6EDFF;
  color: #6D7BBC;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  font-size: 1.2rem;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .all-row .title:hover{
  text-decoration: underline;
  cursor: pointer;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper  .all-row .img{
//border: 1px solid red;
  height: 2rem;
  width: 2rem;
  margin-right: 0.5rem;
  margin-left: 1rem;

//border-radius: 50%;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section{
  //border: 1px solid red;
  display: flex;
  flex-direction: column;
  //margin-bottom: 2rem;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .row-1{
  //border: 1px solid red;
  display: flex;
  align-items: center;
  background-color: #D6EDFF;
  color: #6D7BBC;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .row-1 .img{
  //border: 1px solid red;
  height: 2rem;
  width: 2rem;
  margin-right: 0.5rem;
  margin-left: 1rem;

  //border-radius: 50%;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .row-1 .title{
  font-size: 1.2rem;
  cursor: pointer;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section  .row-1 .title:hover{
  text-decoration: underline;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons{
  //border: 1px solid red;
  margin-left: 1.5rem;

  padding-bottom: 1rem;
  padding-top: 1rem;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson{
  display: flex;
  //border: 1px solid red;
  align-items: center;
  margin-bottom: 0.5rem;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson .lesson-title{
  cursor: pointer;
  color: #727272;
  transition: 0.25s ease;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson .lesson-title:hover{
  text-decoration: underline;
  color: #6D7BBC;
  transition: 0.25s ease;
}
.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson i{
  margin-right: 0.5rem;
  font-size: 0.5rem;
  color: #6D7BBC;
}
.dictionary-wrapper .settings-wrapper .word-form{
  display: none;
  flex: 1;
  //border: 1px solid purple;
  height: 100%;
  flex-direction: column;
  padding: 1.5rem;
  transition: 1s ease;
}
.dictionary-wrapper .settings-wrapper .word-form form label{
  font-size: 1rem;
  color: #727272;
  margin-left: 1rem;
  margin-top: 2rem;

}
.dictionary-wrapper .settings-wrapper .word-form form .form-error{
  color: #DE7C7C;
  margin-left: 1rem;
  margin-bottom: 1rem;
}
.dictionary-wrapper .settings-wrapper .word-form form .input-1 input{
  background-color: #D6EDFF;
  height: 2.5rem;
  margin-top: 0.5rem;
  border-radius: 0.5rem;
  font-size: 0.9rem;
  color: #6d7bbc;
  padding-left: 1rem;
  padding-right: 1rem;
  margin-bottom: 2rem;
}
.dictionary-wrapper .settings-wrapper .word-form form .input-2 input{
  background-color: #D6EDFF;
  height: 2.5rem;
  margin-top: 0.5rem;
  border-radius: 0.5rem;
  font-size: 0.9rem;
  color: #6d7bbc;
  padding-left: 1rem;
  padding-right: 1rem;
  margin-bottom: 2rem;
}
.dictionary-wrapper .settings-wrapper .word-form form .input-3{
  display: flex;
  height: 2.5rem;
  margin-top: 0.5rem;
  transition: 2s ease;
  //border: 1px solid red;

}
.dictionary-wrapper .settings-wrapper .word-form form .input-3 input{
  background-color: #D6EDFF;
  height: 100%;
  border-bottom-left-radius: 0.5rem;
  border-top-left-radius: 0.5rem;
  font-size: 0.9rem;
  color: #6d7bbc;
  padding-left: 1rem;
  padding-right: 1rem;
  width: 85%;
  cursor: pointer;

}
.dictionary-wrapper .settings-wrapper .word-form form .input-1 input::placeholder{
  color: #7886ba;
}
.dictionary-wrapper .settings-wrapper .word-form form .input-2 input::placeholder{
  color: #7886ba;
}
.dictionary-wrapper .settings-wrapper .word-form form .input-3 input::placeholder{
  color: #7886ba;
}
.dictionary-wrapper .settings-wrapper .word-form form .input-3 .icon-input{
  display: flex;
  flex: 1;
  background-color: #D6EDFF;
  border-bottom-right-radius: 0.5rem;
  border-top-right-radius: 0.5rem;
  //border: 1px solid red;
  align-items: center;
  justify-content: center;
  color: #6d7bbc;
  cursor: pointer;
}

.dictionary-wrapper .settings-wrapper .word-form form  .input-4 input[type = text]:focus{

  border:none;
  transition: 0.25s ease;
}
.dictionary-wrapper .settings-wrapper .word-form form button[type = submit]{
  //border: 1px solid red;
  width: 100%;
  height: 4rem;
  margin-top: 2rem;
  background-color: #8B95C9;
  border-radius: 0.5rem;
  color: white;
  transition: 0.20s ease;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options{
  //border: 1px solid red;
  display: none;
  height: auto;
  background-color: #D6EDFF;
  border-bottom-right-radius: 0.5rem;
  border-bottom-left-radius: 0.5rem;
  transition: 2s ease;
  padding-left: 1rem;
  padding-right: 1rem;
  padding-bottom: 1rem;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lessons-options-error{
  color: #DE7C7C;
  font-size: 0.9rem;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper{
  //border: 1px solid red;
  height: 10rem;
  width: 100%;
  overflow-y: auto;
  font-size: 0.9rem;
  color: #7886ba;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson{
  display: flex;
  //border: 1px solid red;
  height: 1.5rem;
  align-items: center;
  margin-bottom: 0.5rem;
  cursor: pointer;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson:hover{
  background-color: #cae1f3;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson .id{
  width: 1.2rem;
  height: 1.2rem;
  color: white;
  padding: 0.5rem;
  background-color: #7886ba;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 0.2rem;
  font-size: 0.8rem;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson .title{
  display: flex;
  overflow-wrap: normal;
}
.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson .img{
  //border: 1px solid red;
  width: 6%;
  margin-right: 0.5rem;
  margin-left: 0.5rem;
}
.dictionary-wrapper .settings-wrapper .word-form form button[type = submit]:hover{
  background-color: #6d7bbc;
  transition: 0.20s ease;
}

.dictionary-wrapper .words .words-wrapper{
  overflow-y: auto;
  height: 100%;
  padding-bottom: 1rem;
  padding-top: 2rem;
  padding-left: 3rem;
  padding-right: 3rem;
}
.dictionary-wrapper .words .words-wrapper .no-words{
  color: #6d7bbc;
  margin-left: 0.5rem;
  font-size: 1.3rem;
  display: flex;
  align-items: center;
}
.dictionary-wrapper .words .words-wrapper .no-words i{
  font-size: 3rem;
  margin-right: 1rem;
}
.dictionary-wrapper .words .words-wrapper .word{
  //border: 1px solid red;
  height: 5rem;
  margin-bottom: 1rem;
  display: flex;
  background-color: #f8f8f8;
  border-radius: 1rem;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  padding: 1rem;
  padding-left: 2rem;
  padding-right: 2rem;
  align-items: center;
  justify-content: space-between;

}
.dictionary-wrapper .words .words-wrapper .word .clm-1{
  //border: 1px solid red;
  width: 95%;
  display: flex;
  align-items: center;
}
.dictionary-wrapper .words .words-wrapper .word .clm-1 .clm-1-1{
  //border: 1px solid red;
  display: flex;
  flex-direction: column;
  margin-left: 2rem;
}
.dictionary-wrapper .words .words-wrapper .word .clm-2{
  //border: 1px solid purple;
  display: flex;
  justify-content: space-between;
}
.dictionary-wrapper .words .words-wrapper .word .clm-1 .id{
  //border: 1px solid red;
  width: 2rem;
  height: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #84DCC6;
  border-radius: 0.5rem;
  color: white;
}
.dictionary-wrapper .words .words-wrapper .word .clm-1 .section{
  //border: 1px solid red;
  display: flex;
  margin-left: 1rem;
}
.dictionary-wrapper .words .words-wrapper .word .clm-1 .section .section-img{
  width: 3rem;
  height: 3rem;
  border-radius: 50%;
  //border: 1px solid orange;
  display: flex;
  align-items: center;
  justify-content: center;
}
.dictionary-wrapper .words .words-wrapper .word .clm-1 .section .section-img img{
  width: 90%;
  height: 90%;
}
.dictionary-wrapper .words .words-wrapper .word .clm-1 .clm-1-1 .name{
  //border: 1px solid red;
  display: flex;
  align-items: center;
  font-size: 1.5rem;
  color: #6D7BBC;
}
.dictionary-wrapper .words .words-wrapper .word .clm-1 .clm-1-1 .translation{
  //border: 1px solid red;
  display: flex;
  align-items: center;
  font-size: 1.1rem;
  color: #727272;
  margin-top: 0.5rem;
}
.dictionary-wrapper .words .words-wrapper .word .clm-2 .lesson-id{
  //border: 1px solid red;
  display: flex;
  justify-content: center;
  align-items: center;
}
.dictionary-wrapper .words .words-wrapper .word .clm-2 .lesson-id i{
  //border: 1px solid red;
  height: 2rem;
  width: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #32A88A;
  border-radius: 0.5rem;
  color: white;
  cursor: pointer;
  transition: 0.25s ease;
}
.dictionary-wrapper .words .words-wrapper .word .clm-2 .lesson-id i:hover{
  background-color: #84DCC6;
  transition: 0.25s ease;
}
.dictionary-wrapper .words .words-wrapper .data-error{
  //border: 1px solid red;
  width: 100%;
  height: 70%;
  display: flex;
}
.dictionary-wrapper .words .words-wrapper .data-error .clm-1{
  //border: 1px solid red;
  width: 50%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-left: 3rem;

}
.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .header-1{
  font-size: 3.5em;
  color: #f66f6f;
  margin-bottom: 1rem;
}
.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .header-2{
  font-size: 2.5rem;
  color: #727272;
}
.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .error-header{
  margin-top: 1rem;
  font-size: 0.9rem;
  color: #727272;
}
.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .refresh{
  cursor: pointer;
  margin-top: 1rem;
  color: #727272;
}
.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .pending{
  margin-top: 1rem;
  color: #727272;
}
.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .refresh:hover{
  text-decoration: underline;

}
.dictionary-wrapper .words .words-wrapper .data-error .clm-2{
  //border: 1px solid red;
  width: 50%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 20rem;
  padding-right: 15rem;
  color: #727272;
}
</style>