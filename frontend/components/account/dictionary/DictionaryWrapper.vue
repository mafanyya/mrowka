<template>
<div class="dictionary-wrapper">
  <div class = "words">
    <DictionarySettingsNavBar/>
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
                <p>{{word.lessonId}}</p>
              </div>
            </div>
          </div>
        </template>
      </template>
    </div>
  </div>
  <div class="settings-wrapper">
    <div @click.prevent = "console.log('Words is '); console.log(words)" class="header">
      <p>Sortowanie</p>
    </div>
    <div class="sections-wrapper">
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
  </div>
</div>
</template>

<script setup lang="js">
let words = null

import DictionarySettingsNavBar from "~/components/account/dictionary/DictionarySettingsNavBar.vue";

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
async function findAllWords(){
  const {pending: wordsPending, data: allWordsData, error: wordsError, refresh: refreshWords} = await useFetch('http://localhost:8000/api/words')
  if(allWordsData.value){
    wordsData.value = allWordsData.value
  }

}
async function findWordsBySection($sectionId){
  const {data: wordsBySectionData, error: wordsBySectionError} = await useFetch('http://localhost:8000/api/words-by-section', {
        method: 'POST',
        body: {
          'sectionId': $sectionId
        },
      }
  )
  if(wordsBySectionData.value){
    wordsData.value = wordsBySectionData.value
  }

}
async function findWordsByLesson($lessonId){
  const {data: wordsByLessonData, error: wordsByLessonError} = await useFetch('http://localhost:8000/api/words-by-lesson', {
        method: 'POST',
        body: {
          'lessonId': $lessonId
        },
      }
  )
  if(wordsByLessonData.value){
    wordsData.value = wordsByLessonData.value
  }
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
  width: 75%;
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
.dictionary-wrapper .words .words-wrapper{
  overflow-y: auto;
  height: 100%;
  padding-bottom: 1rem;
  padding-top: 2rem;
  padding-left: 3rem;
  padding-right: 3rem;
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
.dictionary-wrapper .words .words-wrapper .word .clm-2 .lesson-id p{
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
.dictionary-wrapper .words .words-wrapper .word .clm-2 .lesson-id p:hover{
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