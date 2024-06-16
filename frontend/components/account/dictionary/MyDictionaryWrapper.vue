<template>
  <div class="dictionary-wrapper">
    <div class="words">
      <MyDictionaryNavBar/>
      <div class="words-wrapper">
        <template v-if="!userData" id="user-data">
          <div class="data-error">
            <div class="clm-1">
              <p class="header-2">Brak danych</p>
              <p v-if="wordsPending" class="pending">Odświerzanie...</p>
              <p v-else class="refresh" @click.prevent="refreshUser">Odświerz dane</p>
            </div>
            <div class="clm-2">
            </div>
          </div>
        </template>
        <template v-else>
          <div v-if="userData.user.words.length === 0" class="no-words">
            <i class="fi fi-ss-cloud-question"></i>
            <p>Nie znaleziono słów</p>
          </div>
          <template v-for="word of wordsData ">
            <div class="word">
              <div class="row-1">
                <div class="clm-1">
                  <div class="id">
                    <p>{{ word.id }}</p>
                  </div>
                  <div class="section">
                    <div class="section-img">
                      <img :src="word.img" alt="">
                    </div>
                  </div>
                  <div class="clm-1-1">
                    <div class="name">
                      <p>{{ word.name }}</p>
                    </div>
                    <div class="translation">
                      <p>{{ word.translation }}</p>
                    </div>
                  </div>
                </div>
                <div class="clm-2">
                  <div class="delete">
                    <div @click.prevent="removeWordUser(word.id)" class="btn">
                      <i class="fi fi-br-cross"></i>
                    </div>
                  </div>
                  <NuxtLink class="link" :to="'/dashboard/lessons/lesson/' + word.lessonUniqid">
                    <div class="lesson-id">
                      <i class="fi fi-sr-book-bookmark"></i>
                    </div>
                  </NuxtLink>
                </div>
              </div>
            </div>
          </template>
        </template>
      </div>
    </div>
    <div id="settings-wrapper" class="settings-wrapper">
      <div class="header">
        <p id="settings-header">Sortowanie</p>
      </div>
      <div v-if="userData" id="sections-wrapper" class="sections-wrapper">
        <template v-if="!sectionsData">
          <p>Brak danych</p>
          <p @click.prevent="refreshSections" v-if="!sectionsPending">Odśwież dane</p>
          <p v-else>Odświeżanie...</p>
        </template>
        <template v-else>
          <div class="all-row">
            <div class="img">
              <img src="~/assets/images/sections/sheep.png" alt="">
            </div>
            <p @click.prevent="findAllWords()" class="title">Wszystkie</p>
          </div>
          <template v-for="section in sectionsData.sections">
            <template v-if="isHasSection(section.id)">
              <div class="section">
                <div class="row-1">
                  <div class="img">
                    <img :src="section.img" alt="">
                  </div>
                  <p @click.prevent="findWordsBySection(section.id)" class="title">{{ section.title }}</p>
                </div>
                <div class="lessons">
                  <template v-if="!sectionsData.lessons">
                    <p>No lessons</p>
                  </template>
                  <template v-else>
                    <template v-for="lesson in sectionsData.lessons">
                      <template v-if="lesson.sectionId === section.id">
                        <template v-if="isHasLesson(lesson.id)">
                          <div class="lesson">
                            <i class="fi fi-ss-circle"></i>
                            <p @click.prevent="findWordsByLesson(lesson.id)" class="lesson-title">{{ lesson.title }}</p>
                          </div>
                        </template>
                      </template>
                    </template>
                  </template>
                </div>
              </div>
            </template>
          </template>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup lang="js">
import DictionarySettingsNavBar from "~/components/account/dictionary/DictionarySettingsNavBar.vue";
import MyDictionaryNavBar from "~/components/account/dictionary/MyDictionaryNavBar.vue";

const {refresh: refreshUser, status: userStatus, data: userData, signOut, token, refreshToken} = useAuth()

let words = null
let name = ref('')
let translation = ref('')
let lessonId = ref('')
let wordsData = ref()

if (userData.value) {
  wordsData.value = userData.value.user.words

}
console.log(wordsData.value)

let byLessonPending
let bySectionPending
let allWordPending
let addWordPending


const {
  pending: sectionsPending,
  data: sectionsData,
  error: sectionsError,
  refresh: refreshSections
} = await useFetch('http://localhost:8000/api/lesson-sections')

if (sectionsError.value) {
  console.log('!ERROR: Sections fetch error is ')
  console.log(sectionsError.value)
}
if (sectionsData.value) {
  console.log('Data from getSections is ')
  console.log(sectionsData.value)
}


function findAllWords() {
  wordsData.value = userData.value.user.words
}

function findWordsBySection(sectionId) {
  let wordsArray = []
  for (let word of userData.value.user.words) {
    if (word.sectionId === sectionId) {
      wordsArray.push(word)
    }
  }
  wordsData.value = wordsArray
}

function findWordsByLesson(lessonId) {
  let wordsArray = []
  for (let word of userData.value.user.words) {
    if (word.lessonId === lessonId) {
      wordsArray.push(word)
    }
  }
  wordsData.value = wordsArray
}

function isHasLesson(lessonId) {
  for (let lesson of userData.value.user.lessons) {
    if (lesson.id === lessonId) {
      return true
    }
  }
}

function isHasSection(sectionId) {
  for (let section of userData.value.user.sections) {
    if (section.id === sectionId) {
      return true
    }
  }
}

async function removeWordUser(wordId) {
  const {
    data: removeWordData,
    error: removeWordError,
    refresh: refreshRemoveWord,
    pending: removeWordPending
  } = await useFetch('http://localhost:8000/api/remove-word-user', {
        method: 'POST',
        body: {
          wordId: wordId,
          userId: userData.value.user.id
        }
      }
  )
  if (removeWordData.value) {
    console.log('Remove word data is ')
    console.log(removeWordData.value)
    await refreshUser()
    wordsData.value = userData.value.user.words
  }
  if (removeWordError.value) {
    console.log('Add word error is ')
    console.log(removeWordError.value)
  }
}
</script>

<style scoped>
.dictionary-wrapper {
//border: 1px solid purple; width: 100%; height: 100%;
  display: flex;
}

.dictionary-wrapper .words {
  width: 70%;
//border: 1px solid purple; height: 100%; display: flex;
  flex-direction: column;
}

.dictionary-wrapper .settings-wrapper {
  display: flex;
  flex: 1;
//border: 1px solid purple; height: 100%; flex-direction: column;
  background-color: #eef6ff;
}

.dictionary-wrapper .settings-wrapper .header {
  background-color: #6D7BBC;
  height: 6rem;
  width: 100%;
  display: flex;
  align-items: center;
  padding-left: 1rem;
  font-size: 1.5rem;
  color: white;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper {
//border: 1px solid red; width: 100%; display: flex;
  flex-direction: column;
  flex: 1;
  overflow-y: auto;
  padding-bottom: 1rem;
//padding-top: 1rem; transition: 1s ease;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .all-row {
  display: flex;
  align-items: center;
  background-color: #D6EDFF;
  color: #6D7BBC;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  font-size: 1.2rem;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .all-row .title:hover {
  text-decoration: underline;
  cursor: pointer;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .all-row .img {
//border: 1px solid red; height: 2rem; width: 2rem;
  margin-right: 0.5rem;
  margin-left: 1rem;

//border-radius: 50%;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section {
//border: 1px solid red; display: flex; flex-direction: column;
//margin-bottom: 2rem;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .row-1 {
//border: 1px solid red; display: flex; align-items: center;
  background-color: #D6EDFF;
  color: #6D7BBC;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .row-1 .img {
//border: 1px solid red; height: 2rem; width: 2rem;
  margin-right: 0.5rem;
  margin-left: 1rem;

//border-radius: 50%;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .row-1 .title {
  font-size: 1.2rem;
  cursor: pointer;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .row-1 .title:hover {
  text-decoration: underline;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons {
//border: 1px solid red; margin-left: 1.5rem; padding-bottom: 1rem;
  padding-top: 1rem;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson {
  display: flex;
//border: 1px solid red; align-items: center; margin-bottom: 0.5rem;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson .lesson-title {
  cursor: pointer;
  color: #727272;
  transition: 0.25s ease;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson .lesson-title:hover {
  text-decoration: underline;
  color: #6D7BBC;
  transition: 0.25s ease;
}

.dictionary-wrapper .settings-wrapper .sections-wrapper .section .lessons .lesson i {
  margin-right: 0.5rem;
  font-size: 0.5rem;
  color: #6D7BBC;
}

.dictionary-wrapper .settings-wrapper .word-form {
  display: none;
  flex: 1;
//border: 1px solid purple; height: 100%; flex-direction: column;
  padding: 1.5rem;
  transition: 1s ease;
}

.dictionary-wrapper .settings-wrapper .word-form form label {
  font-size: 1rem;
  color: #727272;
  margin-left: 1rem;
  margin-top: 2rem;

}

.dictionary-wrapper .settings-wrapper .word-form form .form-error {
  color: #DE7C7C;
  margin-left: 1rem;
  margin-bottom: 1rem;
}

.dictionary-wrapper .settings-wrapper .word-form form .input-1 input {
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

.dictionary-wrapper .settings-wrapper .word-form form .input-2 input {
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

.dictionary-wrapper .settings-wrapper .word-form form .input-3 {
  display: flex;
  height: 2.5rem;
  margin-top: 0.5rem;
  transition: 2s ease;
//border: 1px solid red;
}

.dictionary-wrapper .settings-wrapper .word-form form .input-3 input {
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

.dictionary-wrapper .settings-wrapper .word-form form .input-1 input::placeholder {
  color: #7886ba;
}

.dictionary-wrapper .settings-wrapper .word-form form .input-2 input::placeholder {
  color: #7886ba;
}

.dictionary-wrapper .settings-wrapper .word-form form .input-3 input::placeholder {
  color: #7886ba;
}

.dictionary-wrapper .settings-wrapper .word-form form .input-3 .icon-input {
  display: flex;
  flex: 1;
  background-color: #D6EDFF;
  border-bottom-right-radius: 0.5rem;
  border-top-right-radius: 0.5rem;
//border: 1px solid red; align-items: center; justify-content: center;
  color: #6d7bbc;
  cursor: pointer;
}

.dictionary-wrapper .settings-wrapper .word-form form .input-4 input[type = text]:focus {
  border: none;
  transition: 0.25s ease;
}

.dictionary-wrapper .settings-wrapper .word-form form button[type = submit] {
//border: 1px solid red; width: 100%; height: 4rem;
  margin-top: 2rem;
  background-color: #8B95C9;
  border-radius: 0.5rem;
  color: white;
  transition: 0.20s ease;
}

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options {
//border: 1px solid red; display: none; height: auto;
  background-color: #D6EDFF;
  border-bottom-right-radius: 0.5rem;
  border-bottom-left-radius: 0.5rem;
  transition: 2s ease;
  padding-left: 1rem;
  padding-right: 1rem;
  padding-bottom: 1rem;
}

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lessons-options-error {
  color: #DE7C7C;
  font-size: 0.9rem;
}

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper {
//border: 1px solid red; height: 10rem; width: 100%;
  overflow-y: auto;
  font-size: 0.9rem;
  color: #7886ba;
}

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson {
  display: flex;
//border: 1px solid red; height: 1.5rem; align-items: center;
  margin-bottom: 0.5rem;
  cursor: pointer;
}

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson:hover {
  background-color: #cae1f3;
}

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson .id {
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

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson .title {
  display: flex;
  overflow-wrap: normal;
}

.dictionary-wrapper .settings-wrapper .word-form form .lessons-options .lesson-options-wrapper .lesson .img {
//border: 1px solid red; width: 6%; margin-right: 0.5rem;
  margin-left: 0.5rem;
}

.dictionary-wrapper .settings-wrapper .word-form form button[type = submit]:hover {
  background-color: #6d7bbc;
  transition: 0.20s ease;
}

.dictionary-wrapper .words .words-wrapper {
  overflow-y: auto;
  height: 100%;
  padding: 2rem 3rem 1rem;
}

.dictionary-wrapper .words .words-wrapper .no-words {
  color: #6d7bbc;
  margin-left: 0.5rem;
  font-size: 1.3rem;
  display: flex;
  align-items: center;
}

.dictionary-wrapper .words .words-wrapper .no-words i {
  font-size: 3rem;
  margin-right: 1rem;
}

.dictionary-wrapper .words .words-wrapper .word {
//border: 1px solid red; height: auto; margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
  background-color: #f8f8f8;
  border-radius: 1rem;
//box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; padding: 1rem; padding-left: 2rem;
  padding-right: 2rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 {
  display: flex;
  justify-content: space-between;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 {
//border: 1px solid red; width: 95%; display: flex;
  align-items: center;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 .clm-1-1 {
//border: 1px solid red; display: flex; flex-direction: column;
  margin-left: 2rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 {
//border: 1px solid purple; display: flex; justify-content: space-between;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 .id {
//border: 1px solid red; width: 2rem; height: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #84DCC6;
  border-radius: 0.5rem;
  color: white;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 .section {
//border: 1px solid red; display: flex; margin-left: 1rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 .section .section-img {
  width: 3rem;
  height: 3rem;
  border-radius: 50%;
//border: 1px solid orange; display: flex; align-items: center;
  justify-content: center;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 .section .section-img img {
  width: 90%;
  height: 90%;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 .clm-1-1 .name {
//border: 1px solid red; display: flex; align-items: center;
  font-size: 1.5rem;
  color: #6D7BBC;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-1 .clm-1-1 .translation {
//border: 1px solid red; display: flex; align-items: center;
  font-size: 1.1rem;
  color: #727272;
  margin-top: 0.5rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .lesson-id {
//border: 1px solid red; display: flex; justify-content: center;
  align-items: center;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .lesson-id i {
//border: 1px solid red; height: 2rem; width: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #32A88A;
  border-radius: 0.5rem;
  color: white;
  cursor: pointer;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .lesson-id i:hover {
  background-color: #84DCC6;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .link {
  display: flex;
  align-items: center;
  justify-content: center;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .edit {
//border: 1px solid green; height: 100%; width: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .edit .btn {
//border: 1px solid green; width: 2rem; height: 2rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.25s ease;
  background-color: #84DCC6;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .edit .btn:hover {
  background-color: #41d5ae;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .edit .btn i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: white;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .delete {
//border: 1px solid green; height: 100%; width: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .delete .btn {
//border: 1px solid green; width: 2rem; height: 2rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #DE7C7C;
  color: white;
  cursor: pointer;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .delete .btn:hover {
  background-color: #b95656;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .words-wrapper .word .row-1 .clm-2 .delete .btn i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.7rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 {
//border: 1px solid red; height: 5rem; display: none;
  margin-top: 1rem;
  justify-content: end;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 .inner {
//border: 1px solid green; width: 60%; display: flex;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 .inner .clm-1 {
//border: 1px solid orange; width: 63%; display: flex;
  padding-top: 1.5rem;
  font-size: 1rem;
  color: #727272;
  padding-right: 1rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 .inner .clm-2 {
//border: 1px solid pink; width: 37%; display: flex;
  flex-direction: column;
  align-items: center;
  margin-left: 0.5rem;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 .inner .clm-2 button {
  border-radius: 0.5rem;
  height: 2.5rem;
  background-color: #DE7C7C;
  color: white;
  width: 100%;
  margin: 0.5rem 0.5rem 1rem;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 .inner .clm-2 button:hover {
  background-color: #e16d6d;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 .inner .clm-2 p {
  color: #727272;
  font-size: 0.9rem;
  cursor: pointer;
}

.dictionary-wrapper .words .words-wrapper .word .row-2 .inner .clm-2 p:hover {
  text-decoration: underline;
}


.dictionary-wrapper .words .words-wrapper .data-error {
//border: 1px solid red; width: 100%; height: 70%;
  display: flex;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-1 {
//border: 1px solid red; width: 50%; height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-left: 3rem;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .header-1 {
  font-size: 3.5em;
  color: #f66f6f;
  margin-bottom: 1rem;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .header-2 {
  font-size: 2.5rem;
  color: #727272;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .error-header {
  margin-top: 1rem;
  font-size: 0.9rem;
  color: #727272;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .refresh {
  cursor: pointer;
  margin-top: 1rem;
  color: #727272;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .pending {
  margin-top: 1rem;
  color: #727272;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-1 .refresh:hover {
  text-decoration: underline;
}

.dictionary-wrapper .words .words-wrapper .data-error .clm-2 {
//border: 1px solid red; width: 50%; height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 20rem;
  padding-right: 15rem;
  color: #727272;
}
</style>