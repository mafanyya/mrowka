<template>
  <div class="dictionary-wrapper">
    <template v-if="!userData">
      <ServerError/>
    </template>
    <template v-else>
      <p class="header">Mój słownik</p>
      <div class="words">
        <template v-if="userData.user.words.length === 0">
          <p class="no-achieve-header"><i class="fi fi-rr-guide-alt"></i>Nie masz jeszcze słow w słowniku</p>
        </template>
        <template v-else>
          <template v-for="word in userData.user.words ">
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
                  <NuxtLink class="link" :to="'/lesson/'+ word.lessonUniqid">
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
    </template>
  </div>
</template>
<script setup lang="js">
import ServerError from "~/components/errors/ServerError.vue";

const {refresh: refreshUser, status: userStatus, data: userData, signOut, token, refreshToken} = useAuth()

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
  }
  if (removeWordError.value) {
    console.log('Add word error is ')
    console.log(removeWordError.value)
  }
}
</script>

<style scoped>
.dictionary-wrapper {
//border: 1px solid red; width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 1rem;
}

.dictionary-wrapper .header {
  font-size: 3rem;
  color: #6d7bbc;
}

.dictionary-wrapper .no-achieve-header {
  font-size: 1.8rem;
  color: #8B95C9;
  display: flex;
  justify-content: center;
  width: 100%;
  margin-bottom: 1rem;
  align-items: center;
}

.dictionary-wrapper .no-achieve-header i {
  margin-right: 1rem;
}

.dictionary-wrapper .words {
//border: 1px solid red; width: 80%;
  margin-top: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.dictionary-wrapper .words .word {
//border: 1px solid red; height: auto; margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
  background-color: #f8f8f8;
  border-radius: 1rem;
//box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; padding: 2rem 2rem;
  height: 8rem;
  justify-content: center;
}

.dictionary-wrapper .words .word .row-1 {
  display: flex;
  justify-content: space-between;
//border: 1px solid red; height: 100%;
}

.dictionary-wrapper .words .word .row-1 .clm-1 {
//border: 1px solid red; width: 95%; display: flex;
  align-items: center;
}

.dictionary-wrapper .words .word .row-1 .clm-1 .clm-1-1 {
//border: 1px solid red; display: flex; flex-direction: column;
  margin-left: 2rem;
}

.dictionary-wrapper .words .word .row-1 .clm-2 {
//border: 1px solid purple; display: flex; justify-content: space-between;
}

.dictionary-wrapper .words .word .row-1 .clm-1 .id {
//border: 1px solid red; width: 2rem; height: 3rem;
  width: 3rem;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #84DCC6;
  border-radius: 0.5rem;
  color: white;
  font-size: 1.5rem;
}

.dictionary-wrapper .words .word .row-1 .clm-1 .section {
//border: 1px solid red; display: flex; margin-left: 1rem;
}

.dictionary-wrapper .words .word .row-1 .clm-1 .section .section-img {
  width: 5rem;
  height: 5rem;
  border-radius: 50%;
//border: 1px solid orange; display: flex; align-items: center;
  justify-content: center;
}

.dictionary-wrapper .words .word .row-1 .clm-1 .section .section-img img {
  width: 90%;
  height: 90%;
}

.dictionary-wrapper .words .word .row-1 .clm-1 .clm-1-1 .name {
//border: 1px solid red; display: flex; align-items: center;
  font-size: 2rem;
  color: #6D7BBC;
}

.dictionary-wrapper .words .word .row-1 .clm-1 .clm-1-1 .translation {
//border: 1px solid red; display: flex; align-items: center;
  font-size: 1.1rem;
  color: #727272;
  margin-top: 0.5rem;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .lesson-id {
//border: 1px solid red; display: flex; justify-content: center;
  align-items: center;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .lesson-id i {
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

.dictionary-wrapper .words .word .row-1 .clm-2 .lesson-id i:hover {
  background-color: #84DCC6;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .link {
  display: flex;
  align-items: center;
  justify-content: center;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .edit {
//border: 1px solid green; height: 100%; width: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .edit .btn {
//border: 1px solid green; width: 2rem; height: 2rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.25s ease;
  background-color: #84DCC6;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .edit .btn:hover {
  background-color: #41d5ae;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .edit .btn i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: white;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .delete {
//border: 1px solid green; height: 100%;
  width: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .delete .btn {
//border: 1px solid green; width: 3rem;
  height: 3rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #DE7C7C;
  color: white;
  cursor: pointer;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .delete .btn:hover {
  background-color: #b95656;
  transition: 0.25s ease;
}

.dictionary-wrapper .words .word .row-1 .clm-2 .delete .btn i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.7rem;
}

.dictionary-wrapper .words .word .row-2 {
//border: 1px solid red; height: 5rem; display: none;
  margin-top: 1rem;
  justify-content: end;
}

.dictionary-wrapper .words .word .row-2 .inner {
//border: 1px solid green; width: 60%; display: flex;
}

.dictionary-wrapper .words .word .row-2 .inner .clm-1 {
//border: 1px solid orange; width: 63%; display: flex;
  padding-top: 1.5rem;
  font-size: 1rem;
  color: #727272;
  padding-right: 1rem;
}

.dictionary-wrapper .words .word .row-2 .inner .clm-2 {
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
</style>