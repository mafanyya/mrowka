<template>
  <div class="lesson-dictionary-section">
    <template v-if="!wordsData || wordsData.words.length === 0">
      <div class="no-words">
        <i class="fi fi-br-books"></i>
        <p>Brak słów w tej lekcji</p>
      </div>
    </template>
    <template v-else>
      <div class="words-wrapper">
        <template v-for="word in wordsData.words">
          <div class="word">
            <div class="row-1">
              <div class="clm-1">
                <div class="id">
                  <p>{{ word.id }}</p>
                </div>
                <div class="section">
                  <div class="section-img">
                    <img :src="word.lessonImg" alt="">
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
                <template v-if="userData">
                  <div v-if="!isHasWord(word.id)" @click.prevent="addWordUser(word.id)" class="lesson-id">
                    <i class="fi fi-rr-add"></i>
                  </div>
                  <div v-if="isHasWord(word.id) || wordsPending" @click.prevent="removeWordUser(word.id)"
                       class="lesson-id">
                    <i class="fi fi-br-check-circle"></i>
                    <i class="fi fi-br-cross-small"></i>
                  </div>
                </template>
                <template v-else>
                  <div class="lesson-id-disabled">
                    <p>Loading...</p>
                    <i class="fi fi-rr-truck-loading"></i>
                  </div>
                </template>
              </div>
            </div>

          </div>
        </template>
      </div>
    </template>

  </div>
</template>
<script setup lang="js">
const {refresh: refreshUser, status: userStatus, data: userData, signOut, token, refreshToken} = useAuth()
let props = defineProps({
  lessonId: {
    type: Number
  }
})

const {
  data: wordsData,
  error: wordsError,
  refresh: refreshWords,
  pending: wordsPending
} = await useFetch('http://localhost:8000/api/words-by-lesson', {
      method: 'POST',
      body: {
        lessonId: props.lessonId
      }
    }
)

async function addWordUser(wordId) {
  const {
    data: addWordData,
    error: addWordError,
    refresh: refreshAddWord,
    pending: addWordPending
  } = await useFetch('http://localhost:8000/api/add-word-user', {
        method: 'POST',
        body: {
          wordId: wordId,
          userId: userData.value.user.id
        }
      }
  )
  if (addWordData.value) {
    console.log('Add word data is ')
    console.log(addWordData.value)
    await refreshUser()
  }
  if (addWordError.value) {
    console.log('Add word error is ')
    console.log(addWordError.value)
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
    console.log('Add word data is ')
    console.log(removeWordData.value)
    await refreshUser()
  }
  if (removeWordError.value) {
    console.log('Add word error is ')
    console.log(removeWordError.value)
  }
}

function isHasWord(wordId) {
  console.log(wordId)
  for (let word of userData.value.user.words) {
    console.log(word)
    if (word.id === wordId) {
      return true
    }
  }
}
</script>

<style scoped>
.lesson-dictionary-section {
  width: 100%;
  height: 100%;
//border: 1px solid red;
}

.lesson-dictionary-section .no-words {
  display: flex;
  align-items: end;
}

.lesson-dictionary-section .no-words i {
  font-size: 10rem;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #84DCC6;
}

.lesson-dictionary-section .no-words p {
  font-size: 2rem;
  margin-left: 2rem;
  color: #727272;
}

.lesson-dictionary-section .words-wrapper .word {
//border: 1px solid red; height: auto; margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
  background-color: white;
  border-radius: 1rem;
  padding: 1rem 2rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 {
  display: flex;
  justify-content: space-between;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 {
//border: 1px solid red; width: 95%; display: flex;
  align-items: center;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 .clm-1-1 {
//border: 1px solid red; display: flex; flex-direction: column;
  margin-left: 2rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 {
//border: 1px solid purple; display: flex; justify-content: space-between;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 .id {
//border: 1px solid red; width: 2rem; height: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #84DCC6;
  border-radius: 0.5rem;
  color: white;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 .section {
//border: 1px solid red; display: flex; margin-left: 1rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 .section .section-img {
  width: 3rem;
  height: 3rem;
  border-radius: 50%;
//border: 1px solid orange; display: flex; align-items: center;
  justify-content: center;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 .section .section-img img {
  width: 90%;
  height: 90%;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 .clm-1-1 .name {
//border: 1px solid red; display: flex; align-items: center;
  font-size: 1.5rem;
  color: #6D7BBC;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-1 .clm-1-1 .translation {

  display: flex;
  align-items: center;
  font-size: 1.1rem;
  color: #727272;
  margin-top: 0.5rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id {
  display: flex;
  justify-content: center;
  align-items: center;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id i {
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
  font-size: 1.1rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id .fi-rr-truck-loading {
  background-color: #747474;
  margin-left: 1rem;
  cursor: default;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id p {
  color: #727272;
  margin-right: 1rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id .fi-br-check-circle {
  background-color: transparent;
  margin-left: 1rem;
  cursor: default;
  color: #32a88a;
  font-size: 1.5rem;

}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id .fi-br-check-circle:hover {
  background-color: #32A88A;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id .fi-br-cross-small {
  background-color: #DE7C7C;
  margin-left: 1rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id .fi-br-cross-small:hover {
  background-color: #e16363;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id-disabled {
  display: flex;
  justify-content: center;
  align-items: center;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id-disabled i {
  height: 2rem;
  width: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #32A88A;
  border-radius: 0.5rem;
  color: white;
  transition: 0.25s ease;
  font-size: 1.1rem;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .lesson-id i:hover {
  background-color: #84DCC6;
  transition: 0.25s ease;
}

.lesson-dictionary-section .words-wrapper .word .row-1 .clm-2 .link {
  display: flex;
  align-items: center;
  justify-content: center;
}

</style>