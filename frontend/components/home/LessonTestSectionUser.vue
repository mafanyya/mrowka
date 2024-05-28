<template>
  <div class="lesson-test-section">
    <template v-if="!testData">
      <div class="no-test">
        <i class="fi fi-sr-assessment-alt"></i>
        <p>Brak testu</p>
      </div>
    </template>
    <template v-else>
      <div class="test">
        <div class="question">
          <div class="question-panel">
            <QuestionProgressPanel :question-number=questionNumber :is-question-true=isQuestionTrue
                                   :is-refresh-panel=isRefreshPanel />
          </div>

          <template v-if="userData && !isHasTest(testData.test.id)">
            <template v-for="question in testData.questions">
              <div :id="'question-inner-' + question.number" :class="'question-inner-' + question.number">
                <div class="title">
                  <p>{{ question.title }}</p>
                </div>
                <div class="answers">
                  <template v-for="answer in testData.answers">
                    <button @click.prevent="checkQuestion(question.number, answer.isTrue, answer.number)"
                            v-if="answer.questionId === question.id "
                            :id="'answer-' + answer.number + '-' + question.number" class="answer">
                      {{ answer.title }}
                    </button>
                  </template>
                </div>
                <button @click.prevent="refreshQuestion(question.number)" :id="'next-btn' + question.number"
                        class="next-btn">Dalej
                </button>
              </div>
              <div :id="'question-' + question.number + '-finish'" class="question-finish">
                <div class="clm-1">
                  <i :id="'finish-icon-' + question.number" class="fi fi-rr-face-sad-sweat"></i>
                </div>
                <div class="clm-2">
                  <p :id="'question-' + question.number + '-finish-title'" class="question-finish-title"></p>
                  <div :id="'answer-panel-' + question.number" class="answers-panel">
                    <p :id="'true-answers-' + question.number" class="true-answers"></p>
                    <p class="answer-divide">/</p>
                    <p :id="'wrong-answers-' + question.number" class="wrong-answers">5</p>
                  </div>
                  <button @click.prevent="refreshLocalTest(question.number)" :id="'refresh-btn-' + question.number"
                          class="refresh-test-btn">Spróbuj jeszcze raz
                  </button>
                </div>
              </div>
            </template>
          </template>


          <template v-else>
            <div :id="'question-1-finish'" class="question-finish-2">
              <div class="clm-1">
                <i :id="'finish-icon-1'" class="fi fi-rr-smile"></i>
              </div>
              <div class="clm-2">
                <p :id="'question-1-finish-title'" class="question-finish-title">Test pomyślnie rozwiązany</p>
                <div :id="'answer-panel-1'" class="answers-panel">
                  <p :id="'true-answers-1'" class="true-answers">5</p>
                  <p class="answer-divide">/</p>
                  <p :id="'wrong-answers-1'" class="wrong-answers">5</p>
                </div>
              </div>
            </div>
          </template>


        </div>
      </div>
    </template>
  </div>
</template>

<script setup lang="js">
const {refresh: refreshUser, status: userStatus, data: userData, signOut, token, refreshToken} = useAuth()
import QuestionProgressPanel from "~/components/account/lessons/lesson_page/QuestionProgressPanel.vue";

let questionNumber = ref()
let isQuestionTrue = ref()
let isRefreshPanel = ref(false)
let trueAnswers = []
let wrongAnswers = []


let props = defineProps({
  testId: {
    type: Number
  }
})
const {
  data: testData,
  error: testError,
  refresh: refreshTest,
  pending: testPending
} = await useFetch('http://localhost:8000/api/test-by-id', {
      method: 'POST',
      body: {
        id: props.testId
      }
    }
)

function isHasTest(testId) {
  for (let test of userData.value.user.tests) {
    if (test.id === testId) {
      return true
    }
  }
}

function checkQuestion(questionNumberLocal, questionIsTrueLocal, answerNumber) {
  console.log(questionIsTrueLocal)
  console.log(answerNumber)
  let answer = document.getElementById('answer-' + answerNumber + '-' + questionNumberLocal)
  let answer1 = document.getElementById('answer-1-' + questionNumberLocal)
  let answer2 = document.getElementById('answer-2-' + questionNumberLocal)
  let answer3 = document.getElementById('answer-3-' + questionNumberLocal)
  let nextBtn = document.getElementById('next-btn' + questionNumberLocal)
  isRefreshPanel.value = false

  if (questionIsTrueLocal === true) {
    answer.style.border = 2 + 'px ' + 'solid ' + '#7FCD1A'
    answer.style.color = '#7FCD1A'
    questionNumber.value = questionNumberLocal
    isQuestionTrue.value = true
    answer1.disabled = 'true'
    answer2.disabled = 'true'
    answer3.disabled = 'true'
    nextBtn.style.display = 'block'
    trueAnswers.push(questionNumberLocal)

  } else {
    answer.style.border = 2 + 'px ' + 'solid ' + '#DE7C7C'
    questionNumber.value = questionNumberLocal
    isQuestionTrue.value = false
    answer.style.color = '#DE7C7C'
    answer1.disabled = 'true'
    answer2.disabled = 'true'
    answer3.disabled = 'true'
    nextBtn.style.display = 'block'
    wrongAnswers.push(questionNumberLocal)
  }
}

function refreshQuestion(questionNumber) {
  let nextQuestionNumber = questionNumber + 1
  let question = document.getElementById('question-inner-' + questionNumber)
  let nextQuestion = document.getElementById('question-inner-' + nextQuestionNumber)
  let questionFinish = document.getElementById('question-' + questionNumber + '-finish')


  if (questionNumber >= 5) {
    question.style.display = 'none'
    questionFinish.style.display = "flex"
    let questionFinishTitle = document.getElementById('question-' + questionNumber + '-finish-title')
    let finishIcon = document.getElementById('finish-icon-' + questionNumber)
    let answerPanel = document.getElementById('answer-panel-' + questionNumber)
    let trueAnswersTitle = document.getElementById('true-answers-' + questionNumber)

    let refreshBtn = document.getElementById('refresh-btn-' + questionNumber)

    if (wrongAnswers.length !== 0) {
      finishIcon.className = 'fi fi-rr-face-sad-sweat'
      questionFinishTitle.innerText = "Test rozwiązany, ale są blędy"
      trueAnswersTitle.innerText = trueAnswers.length
      refreshBtn.style.display = 'block'
    } else {
      finishIcon.className = 'fi fi-rr-smile'
      finishIcon.style.color = "#84DCC6"
      questionFinishTitle.innerText = "Test pomyślnie rozwiązany"
      trueAnswersTitle.innerText = trueAnswers.length
      trueAnswersTitle.style.color = "#32A88A"
      refreshBtn.style.display = 'none'
      addLessonUser(testData.value.test.id)


    }
  } else {
    question.style.display = 'none'
    nextQuestion.style.display = 'flex'
  }
}

async function addLessonUser(testId) {
  const {
    data: addLessonData,
    error: addLessonError,
    refresh: refreshAddLesson,
    pending: addLessonPending
  } = await useFetch('http://localhost:8000/api/add-lesson-user', {
        method: 'POST',
        body: {
          testId: testId,
          userId: userData.value.user.id
        }
      }
  )
  if (addLessonData.value) {
    console.log('Add Lesson data is ')
    console.log(addLessonData.value)
    await refreshUser()
  }
  if (addLessonError.value) {
    console.log('Add Lesson error is ')
    console.log(addLessonError.value)
  }
}

function refreshLocalTest(questionNumberLocal) {
  let question = document.getElementById('question-inner-1')
  let questionFinish = document.getElementById('question-' + questionNumberLocal + '-finish')

  trueAnswers = []
  wrongAnswers = []

  questionNumber.value = 0
  for (let i = 1; i <= 5; i++) {
    for (let j = 1; j <= 3; j++) {
      let answer = document.getElementById('answer-' + j + '-' + i)
      answer.style.border = '2px solid #8B95C9'
      answer.style.color = '#8B95C9'
      answer.disabled = false
    }
    let nextBtn = document.getElementById('next-btn' + i)
    nextBtn.style.display = 'none'
  }
  questionFinish.style.display = 'none'
  question.style.display = 'flex'
}
</script>

<style scoped>
.lesson-test-section {
  width: 100%;
  height: 100%;
//border: 1px solid red;
}

.lesson-test-section .no-test {
  display: flex;
  align-items: end;
}

.lesson-test-section .no-test i {
  font-size: 10rem;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #84DCC6;
}

.lesson-test-section .no-test p {
  font-size: 2rem;
  margin-left: 2rem;
  color: #727272;
}

.lesson-test-section .test {
  display: flex;
  flex-direction: column;
}

.lesson-test-section .test .question .question-inner-1 {
//border: 1px solid red; display: flex; flex-direction: column;
  align-items: center;

}

.lesson-test-section .test .question .question-panel {
  height: 2rem;
}

.lesson-test-section .test .question .title {
//border: 1px solid red; height: 7rem; display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
  color: #727272;
  flex-wrap: wrap;
  text-wrap: normal;
}

.lesson-test-section .test .question .answers {
//border: 1px solid red; width: 100%; height: 8rem;
  display: flex;
  padding: 2rem;
  justify-content: space-between;
  align-items: center;
}

.lesson-test-section .test .question .answers .answer {
  border-radius: 1rem;
  border: 2px solid #8B95C9;
  min-width: 18rem;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  background-color: white;
  color: #8B95C9;
  cursor: pointer;
  transition: 0.25s ease;
}

.lesson-test-section .test .question .answers .answer:disabled {
  background-color: #D6EDFF;
}

.lesson-test-section .test .question .answers .answer:hover {
  background-color: #D6EDFF;
  transition: 0.25s ease;
}

.lesson-test-section .test .question .next-btn {
  color: white;
  font-size: 1.2rem;
  width: 18rem;
  height: 4rem;
  border-radius: 1rem;
  background-color: #84DCC6;
  transition: 0.25s ease;
  display: none;
}

.lesson-test-section .test .question .next-btn:hover {
  background-color: #32a88a;
  transition: 0.25s ease;
}

.lesson-test-section .test .question .question-inner-2 {
//border: 1px solid red; display: none; flex-direction: column;
  align-items: center;
}

.lesson-test-section .test .question .question-inner-3 {
//border: 1px solid red; display: none; flex-direction: column;
  align-items: center;
}

.lesson-test-section .test .question .question-inner-4 {
//border: 1px solid red; display: none; flex-direction: column;
  align-items: center;
}

.lesson-test-section .test .question .question-inner-5 {
//border: 1px solid red; display: none; flex-direction: column;
  align-items: center;
}

.lesson-test-section .test .question-finish {
//border: 1px solid red; display: none;
  padding: 2rem;

}

.lesson-test-section .test .question-finish .clm-1 {
//border: 1px solid green; width: 40%; display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12rem;
}

.lesson-test-section .test .question-finish .clm-1 i {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #DE7C7C;
}

.lesson-test-section .test .question-finish .clm-2 {
//border: 1px solid green; width: 60%; display: flex;
  flex-direction: column;
  align-items: center;
}

.lesson-test-section .test .question-finish .clm-2 .answers-panel {
//border: 1px solid red; margin-top: 1.5rem; width: 12rem;
  height: 4rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-test-section .test .question-finish .clm-2 .answers-panel .true-answers {
  font-size: 3rem;
  margin-right: 1rem;
  color: #DE7C7C;
}

.lesson-test-section .test .question-finish .clm-2 .answers-panel .answer-divide {
  font-size: 3rem;
  color: #727272;
}

.lesson-test-section .test .question-finish .clm-2 .answers-panel .wrong-answers {
  font-size: 3rem;
  margin-left: 1rem;
  color: #32a88a;
}

.lesson-test-section .test .question-finish .clm-2 .question-finish-title {
  font-size: 2.5rem;
  color: #727272;
}

.lesson-test-section .test .question-finish .clm-2 .refresh-test-btn {
//border: 1px solid green; display: none; font-size: 1.2rem;
  margin-top: 1.5rem;
  padding: 1rem 2rem;
  background-color: #8B95C9;
  color: white;
  border-radius: 1rem;
  transition: 0.15s ease;
}

.lesson-test-section .test .question-finish .clm-2 .refresh-test-btn:hover {
  background-color: #6D7BBC;
  transition: 0.15s ease;
}

.lesson-test-section .test .question-finish-2 {
//border: 1px solid red; display: flex;
  padding: 2rem;

}

.lesson-test-section .test .question-finish-2 .clm-1 {
//border: 1px solid green; width: 40%; display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12rem;
}

.lesson-test-section .test .question-finish-2 .clm-1 i {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #32a88a;
}

.lesson-test-section .test .question-finish-2 .clm-2 {
//border: 1px solid green; width: 60%; display: flex;
  flex-direction: column;
  align-items: center;
}

.lesson-test-section .test .question-finish-2 .clm-2 .answers-panel {
//border: 1px solid red; margin-top: 1.5rem; width: 12rem;
  height: 4rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-test-section .test .question-finish-2 .clm-2 .answers-panel .true-answers {
  font-size: 3rem;
  margin-right: 1rem;
  color: #32a88a;
}

.lesson-test-section .test .question-finish-2 .clm-2 .answers-panel .answer-divide {
  font-size: 3rem;
  color: #727272;
}

.lesson-test-section .test .question-finish-2 .clm-2 .answers-panel .wrong-answers {
  font-size: 3rem;
  margin-left: 1rem;
  color: #32a88a;
}

.lesson-test-section .test .question-finish-2 .clm-2 .question-finish-title {
  font-size: 2.5rem;
  color: #727272;
}

.lesson-test-section .test .question-finish-2 .clm-2 .refresh-test-btn {
//border: 1px solid green; display: none; font-size: 1.2rem;
  margin-top: 1.5rem;
  padding: 1rem 2rem;
  background-color: #8B95C9;
  color: white;
  border-radius: 1rem;
  transition: 0.15s ease;
}

.lesson-test-section .test .question-finish-2 .clm-2 .refresh-test-btn:hover {
  background-color: #6D7BBC;
  transition: 0.15s ease;
}
</style>