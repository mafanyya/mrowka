<template>
  <div class="edit-test-form">
    <p class="header">Edytowanie testu</p>
    <p class="form-test-error" id="form-error-test"></p>
    <template v-if="testData">
      <form @submit.prevent='editTest'>
        <label for="">Nazwa testu</label>
        <div class="test-input">
          <input
              type=hidden
              id="test-id-input"
              :value="testData.value.test.id"
          >
          <input
              type=text
              id="test-title-input"
              :value="testData.value.test.title"
          >
        </div>
        <p>Pytania</p>
        <template v-for="question in testData.value.questions">
          <label for="">Pytanie {{ question.number }}</label>
          <div class="question-input">
            <input
                type="hidden"
                :id="'question-' + question.number + '-id-input'"
                :value=question.id
            >
            <input
                type="text"
                :id="'question-' + question.number + '-title-input'"
                :value=question.title
            >
            <div class="panel"></div>
          </div>
          <template v-for="answer in testData.value.answers">
            <div v-if="answer.questionId === question.id" class="answer-input">
              <label for="">Odpowiedź {{ answer.number }}</label>
              <input
                  type="hidden"
                  :id="'question-' + question.number +'-answer-' + answer.number + '-id-input'"
                  :value="answer.id"
              >
              <input
                  type="hidden"
                  :id="'question-' + question.number +'-answer-' + answer.number + '-is-true-input'"
                  :value="answer.isTrue"
              >
              <div class="input">
                <input
                    type="text"
                    :id="'question-' + question.number +'-answer-' + answer.number + '-title-input'"
                    :value="answer.title"
                >
                <div class="is-true">
                  <i @click.prevent="changeIsTrue(question.number, answer.number)" v-if="!answer.isTrue"
                     :id="'is-true-icon-' + question.number + '-'+ answer.number" class="fi fi-ss-circle"
                     style="color:#DE7C7C"></i>
                  <i @click.prevent="changeIsTrue(question.number, answer.number)" v-if="answer.isTrue"
                     :id="'is-true-icon-' + question.number + '-'+ answer.number" class="fi fi-ss-circle"
                     style="color:#32A88A"></i>
                </div>
              </div>
            </div>
          </template>
        </template>
        <button type=submit>Zmień test</button>
      </form>
    </template>
    <template v-else>
      <div class="no-data">
        <p class="message">Wybierz test do edytowania</p>
        <i class="fi fi-rr-analyse-alt"></i>
      </div>
    </template>
  </div>
</template>
<script setup lang="js">

let testId = ref()
let refreshTest = ref()
let testData = ref()
let testTitle = ref('')
let testIdInput = ref('')

let questionTitle_1 = ref('')
let questionTitle_2 = ref('')
let questionTitle_3 = ref('')
let questionTitle_4 = ref('')
let questionTitle_5 = ref('')

let questionId_1 = ref('')
let questionId_2 = ref('')
let questionId_3 = ref('')
let questionId_4 = ref('')
let questionId_5 = ref('')

let questionImage_1 = ref('')
let questionImage_2 = ref('')
let questionImage_3 = ref('')
let questionImage_4 = ref('')
let questionImage_5 = ref('')

let answerTitle_1_1 = ref('')
let answerTitle_1_2 = ref('')
let answerTitle_1_3 = ref('')

let answerIsTrue_1_1 = ref('')
let answerIsTrue_1_2 = ref('')
let answerIsTrue_1_3 = ref('')

let answerId_1_1 = ref()
let answerId_1_2 = ref()
let answerId_1_3 = ref()

let answerTitle_2_1 = ref('')
let answerTitle_2_2 = ref('')
let answerTitle_2_3 = ref('')

let answerIsTrue_2_1 = ref('')
let answerIsTrue_2_2 = ref('')
let answerIsTrue_2_3 = ref('')

let answerId_2_1 = ref()
let answerId_2_2 = ref()
let answerId_2_3 = ref()

let answerTitle_3_1 = ref('')
let answerTitle_3_2 = ref('')
let answerTitle_3_3 = ref('')

let answerIsTrue_3_1 = ref('')
let answerIsTrue_3_2 = ref('')
let answerIsTrue_3_3 = ref('')

let answerId_3_1 = ref()
let answerId_3_2 = ref()
let answerId_3_3 = ref()

let answerTitle_4_1 = ref('')
let answerTitle_4_2 = ref('')
let answerTitle_4_3 = ref('')

let answerIsTrue_4_1 = ref('')
let answerIsTrue_4_2 = ref('')
let answerIsTrue_4_3 = ref('')

let answerId_4_1 = ref()
let answerId_4_2 = ref()
let answerId_4_3 = ref()

let answerTitle_5_1 = ref('')
let answerTitle_5_2 = ref('')
let answerTitle_5_3 = ref('')

let answerIsTrue_5_1 = ref('')
let answerIsTrue_5_2 = ref('')
let answerIsTrue_5_3 = ref('')

let answerId_5_1 = ref()
let answerId_5_2 = ref()
let answerId_5_3 = ref()

let props = defineProps({
  testId: {
    type: Number
  },
  questionId: {
    type: Number
  },
  answerId: {
    type: Number
  }
})

let emit = defineEmits(["refreshTests"])

function changeIsTrue(questionNumber, answerNumber) {
  let isTrueInput = document.getElementById('question-' + questionNumber + '-answer-' + answerNumber + '-is-true-input')
  switch (answerNumber) {
    case 1:
      if (isTrueInput.value === 'false') {
        console.log('1 FALSE')
        document.getElementById('question-' + questionNumber + '-answer-' + 1 + '-is-true-input').value = true
        document.getElementById('question-' + questionNumber + '-answer-' + 2 + '-is-true-input').value = false
        document.getElementById('question-' + questionNumber + '-answer-' + 3 + '-is-true-input').value = false
        document.getElementById('is-true-icon-' + questionNumber + '-1').style.color = '#32A88A'
        document.getElementById('is-true-icon-' + questionNumber + '-2').style.color = '#DE7C7C'
        document.getElementById('is-true-icon-' + questionNumber + '-3').style.color = '#DE7C7C'
      }
      break
    case 2:
      if (isTrueInput.value === 'false') {
        console.log('2 FALSE')
        document.getElementById('question-' + questionNumber + '-answer-' + 2 + '-is-true-input').value = true
        document.getElementById('question-' + questionNumber + '-answer-' + 1 + '-is-true-input').value = false
        document.getElementById('question-' + questionNumber + '-answer-' + 3 + '-is-true-input').value = false
        document.getElementById('is-true-icon-' + questionNumber + '-2').style.color = '#32A88A'
        document.getElementById('is-true-icon-' + questionNumber + '-1').style.color = '#DE7C7C'
        document.getElementById('is-true-icon-' + questionNumber + '-3').style.color = '#DE7C7C'
      }
      break
    case 3:
      if (isTrueInput.value === 'false') {
        console.log('3 FALSE')
        document.getElementById('question-' + questionNumber + '-answer-' + 3 + '-is-true-input').value = true
        document.getElementById('question-' + questionNumber + '-answer-' + 2 + '-is-true-input').value = false
        document.getElementById('question-' + questionNumber + '-answer-' + 1 + '-is-true-input').value = false
        document.getElementById('is-true-icon-' + questionNumber + '-3').style.color = '#32A88A'
        document.getElementById('is-true-icon-' + questionNumber + '-2').style.color = '#DE7C7C'
        document.getElementById('is-true-icon-' + questionNumber + '-1').style.color = '#DE7C7C'
      }
      break
    default:
      console.warn("ERROR: Error from change isTrue")
      break
  }
}

async function editTest() {
  let testTitleLocal = document.getElementById('test-title-input')

  let question1Title = document.getElementById('question-1-title-input')
  let question2Title = document.getElementById('question-2-title-input')
  let question3Title = document.getElementById('question-3-title-input')
  let question4Title = document.getElementById('question-4-title-input')
  let question5Title = document.getElementById('question-5-title-input')

  let testIdLocal = document.getElementById('test-id-input')

  let question1Id = document.getElementById('question-1-id-input')
  let question2Id = document.getElementById('question-2-id-input')
  let question3Id = document.getElementById('question-3-id-input')
  let question4Id = document.getElementById('question-4-id-input')
  let question5Id = document.getElementById('question-5-id-input')

  let question1Answer1Title = document.getElementById('question-1-answer-1-title-input')
  let question1Answer2Title = document.getElementById('question-1-answer-2-title-input')
  let question1Answer3Title = document.getElementById('question-1-answer-3-title-input')

  let question1Answer1IsTrue = document.getElementById('question-1-answer-1-is-true-input')
  let question1Answer2IsTrue = document.getElementById('question-1-answer-2-is-true-input')
  let question1Answer3IsTrue = document.getElementById('question-1-answer-3-is-true-input')

  let question1Answer1Id = document.getElementById('question-1-answer-1-id-input')
  let question1Answer2Id = document.getElementById('question-1-answer-2-id-input')
  let question1Answer3Id = document.getElementById('question-1-answer-3-id-input')

  let question2Answer1Title = document.getElementById('question-2-answer-1-title-input')
  let question2Answer2Title = document.getElementById('question-2-answer-2-title-input')
  let question2Answer3Title = document.getElementById('question-2-answer-3-title-input')

  let question2Answer1IsTrue = document.getElementById('question-2-answer-1-is-true-input')
  let question2Answer2IsTrue = document.getElementById('question-2-answer-2-is-true-input')
  let question2Answer3IsTrue = document.getElementById('question-2-answer-3-is-true-input')

  let question2Answer1Id = document.getElementById('question-2-answer-1-id-input')
  let question2Answer2Id = document.getElementById('question-2-answer-2-id-input')
  let question2Answer3Id = document.getElementById('question-2-answer-3-id-input')

  let question3Answer1Title = document.getElementById('question-3-answer-1-title-input')
  let question3Answer2Title = document.getElementById('question-3-answer-2-title-input')
  let question3Answer3Title = document.getElementById('question-3-answer-3-title-input')

  let question3Answer1IsTrue = document.getElementById('question-3-answer-1-is-true-input')
  let question3Answer2IsTrue = document.getElementById('question-3-answer-2-is-true-input')
  let question3Answer3IsTrue = document.getElementById('question-3-answer-3-is-true-input')

  let question3Answer1Id = document.getElementById('question-3-answer-1-id-input')
  let question3Answer2Id = document.getElementById('question-3-answer-2-id-input')
  let question3Answer3Id = document.getElementById('question-3-answer-3-id-input')

  let question4Answer1Title = document.getElementById('question-4-answer-1-title-input')
  let question4Answer2Title = document.getElementById('question-4-answer-2-title-input')
  let question4Answer3Title = document.getElementById('question-4-answer-3-title-input')

  let question4Answer1IsTrue = document.getElementById('question-4-answer-1-is-true-input')
  let question4Answer2IsTrue = document.getElementById('question-4-answer-2-is-true-input')
  let question4Answer3IsTrue = document.getElementById('question-4-answer-3-is-true-input')

  let question4Answer1Id = document.getElementById('question-4-answer-1-id-input')
  let question4Answer2Id = document.getElementById('question-4-answer-2-id-input')
  let question4Answer3Id = document.getElementById('question-4-answer-3-id-input')

  let question5Answer1Title = document.getElementById('question-5-answer-1-title-input')
  let question5Answer2Title = document.getElementById('question-5-answer-2-title-input')
  let question5Answer3Title = document.getElementById('question-5-answer-3-title-input')

  let question5Answer1IsTrue = document.getElementById('question-5-answer-1-is-true-input')
  let question5Answer2IsTrue = document.getElementById('question-5-answer-2-is-true-input')
  let question5Answer3IsTrue = document.getElementById('question-5-answer-3-is-true-input')

  let question5Answer1Id = document.getElementById('question-5-answer-1-id-input')
  let question5Answer2Id = document.getElementById('question-5-answer-2-id-input')
  let question5Answer3Id = document.getElementById('question-5-answer-3-id-input')

  testTitle.value = testTitleLocal.value

  testIdInput.value = testIdLocal.value

  questionTitle_1.value = question1Title.value
  questionTitle_2.value = question2Title.value
  questionTitle_3.value = question3Title.value
  questionTitle_4.value = question4Title.value
  questionTitle_5.value = question5Title.value

  questionId_1.value = question1Id.value
  questionId_2.value = question2Id.value
  questionId_3.value = question3Id.value
  questionId_4.value = question4Id.value
  questionId_5.value = question5Id.value

  answerTitle_1_1.value = question1Answer1Title.value
  answerTitle_1_2.value = question1Answer2Title.value
  answerTitle_1_3.value = question1Answer3Title.value

  answerId_1_1.value = question1Answer1Id.value
  answerId_1_2.value = question1Answer2Id.value
  answerId_1_3.value = question1Answer3Id.value

  answerTitle_2_1.value = question2Answer1Title.value
  answerTitle_2_2.value = question2Answer2Title.value
  answerTitle_2_3.value = question2Answer3Title.value

  answerId_2_1.value = question2Answer1Id.value
  answerId_2_2.value = question2Answer2Id.value
  answerId_2_3.value = question2Answer3Id.value

  answerTitle_3_1.value = question3Answer1Title.value
  answerTitle_3_2.value = question3Answer2Title.value
  answerTitle_3_3.value = question3Answer3Title.value

  answerId_3_1.value = question3Answer1Id.value
  answerId_3_2.value = question3Answer2Id.value
  answerId_3_3.value = question3Answer3Id.value

  answerTitle_4_1.value = question4Answer1Title.value
  answerTitle_4_2.value = question4Answer2Title.value
  answerTitle_4_3.value = question4Answer3Title.value

  answerId_4_1.value = question4Answer1Id.value
  answerId_4_2.value = question4Answer2Id.value
  answerId_4_3.value = question4Answer3Id.value

  answerTitle_5_1.value = question5Answer1Title.value
  answerTitle_5_2.value = question5Answer2Title.value
  answerTitle_5_3.value = question5Answer3Title.value

  answerId_5_1.value = question5Answer1Id.value
  answerId_5_2.value = question5Answer2Id.value
  answerId_5_3.value = question5Answer3Id.value

  answerIsTrue_1_1.value = question1Answer1IsTrue.value
  answerIsTrue_1_2.value = question1Answer2IsTrue.value
  answerIsTrue_1_3.value = question1Answer3IsTrue.value

  answerIsTrue_2_1.value = question2Answer1IsTrue.value
  answerIsTrue_2_2.value = question2Answer2IsTrue.value
  answerIsTrue_2_3.value = question2Answer3IsTrue.value

  answerIsTrue_3_1.value = question3Answer1IsTrue.value
  answerIsTrue_3_2.value = question3Answer2IsTrue.value
  answerIsTrue_3_3.value = question3Answer3IsTrue.value

  answerIsTrue_4_1.value = question4Answer1IsTrue.value
  answerIsTrue_4_2.value = question4Answer2IsTrue.value
  answerIsTrue_4_3.value = question4Answer3IsTrue.value

  answerIsTrue_5_1.value = question5Answer1IsTrue.value
  answerIsTrue_5_2.value = question5Answer2IsTrue.value
  answerIsTrue_5_3.value = question5Answer3IsTrue.value

  const {
    data: editTestData,
    error: editTestError,
    pending: editTestPending
  } = await useFetch('http://localhost:8000/api/edit-test', {
        method: 'POST',
        body: {
          testId: testIdInput.value,
          testTitle: testTitle.value,

          question1Id: questionId_1.value,
          question2Id: questionId_2.value,
          question3Id: questionId_3.value,
          question4Id: questionId_4.value,
          question5Id: questionId_5.value,

          question1Title: questionTitle_1.value,
          question2Title: questionTitle_2.value,
          question3Title: questionTitle_3.value,
          question4Title: questionTitle_4.value,
          question5Title: questionTitle_5.value,

          answerId_1_1: answerId_1_1.value,
          answerId_1_2: answerId_1_2.value,
          answerId_1_3: answerId_1_3.value,

          answerId_2_1: answerId_2_1.value,
          answerId_2_2: answerId_2_2.value,
          answerId_2_3: answerId_2_3.value,

          answerId_3_1: answerId_3_1.value,
          answerId_3_2: answerId_3_2.value,
          answerId_3_3: answerId_3_3.value,

          answerId_4_1: answerId_4_1.value,
          answerId_4_2: answerId_4_2.value,
          answerId_4_3: answerId_4_3.value,

          answerId_5_1: answerId_5_1.value,
          answerId_5_2: answerId_5_2.value,
          answerId_5_3: answerId_5_3.value,

          answerIsTrue_1_1: answerIsTrue_1_1.value,
          answerIsTrue_1_2: answerIsTrue_1_2.value,
          answerIsTrue_1_3: answerIsTrue_1_3.value,

          answerIsTrue_2_1: answerIsTrue_2_1.value,
          answerIsTrue_2_2: answerIsTrue_2_2.value,
          answerIsTrue_2_3: answerIsTrue_2_3.value,

          answerIsTrue_3_1: answerIsTrue_3_1.value,
          answerIsTrue_3_2: answerIsTrue_3_2.value,
          answerIsTrue_3_3: answerIsTrue_3_3.value,

          answerIsTrue_4_1: answerIsTrue_4_1.value,
          answerIsTrue_4_2: answerIsTrue_4_2.value,
          answerIsTrue_4_3: answerIsTrue_4_3.value,

          answerIsTrue_5_1: answerIsTrue_5_1.value,
          answerIsTrue_5_2: answerIsTrue_5_2.value,
          answerIsTrue_5_3: answerIsTrue_5_3.value,

          answerTitle_1_1: answerTitle_1_1.value,
          answerTitle_1_2: answerTitle_1_2.value,
          answerTitle_1_3: answerTitle_1_3.value,

          answerTitle_2_1: answerTitle_2_1.value,
          answerTitle_2_2: answerTitle_2_2.value,
          answerTitle_2_3: answerTitle_2_3.value,

          answerTitle_3_1: answerTitle_3_1.value,
          answerTitle_3_2: answerTitle_3_2.value,
          answerTitle_3_3: answerTitle_3_3.value,

          answerTitle_4_1: answerTitle_4_1.value,
          answerTitle_4_2: answerTitle_4_2.value,
          answerTitle_4_3: answerTitle_4_3.value,

          answerTitle_5_1: answerTitle_5_1.value,
          answerTitle_5_2: answerTitle_5_2.value,
          answerTitle_5_3: answerTitle_5_3.value,

        },
      }
  )
  if (editTestData.value) {
    console.log('Success')
    refreshTest.value()
    createError(100)
    emit("refreshTests")
  }
  if (editTestError.value) {
    createError(500)
    console.warn('ERROR: Error from edit test is ')
    console.warn(editTestError.value)
  }
}

watch(() => props.testId, async (newTestId, prevTestId) => {
  testId = newTestId
  const {
    data,
    error: testError,
    pending: testPending,
    refresh
  } = await useFetch('http://localhost:8000/api/test-by-id', {
        method: 'POST',
        body: {
          id: testId
        },
      }
  )
  if (data.value) {
    testData.value = data
    refreshTest.value = refresh
  }
  if (testError.value) {
    createError(500)
    console.warn('ERROR: Error from get test is ')
    console.warn(testError.value)
  }
})

function createError(errorCode) {
  const formError = document.getElementById('form-error-test')
  switch (errorCode) {
    case 100:
      formError.style.visibility = 'visible'
      formError.style.color = 'green'
      formError.innerText = 'Test zmieniony pomyślnie'
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

</script>
<style scoped>
.edit-test-form {
//border: 1px solid red; width: 100%; height: 100%;
  overflow-y: auto;
}

.edit-test-form .header {
  font-size: 2rem;
  margin-top: 2rem;
  margin-bottom: 1.5rem;
  color: #6d7bbc;
}

.edit-test-form .form-test-error {
  margin-bottom: 1rem;
  color: #DE7C7C;
}

.edit-test-form .no-data {
  display: flex;
  align-items: center;
  margin-top: 3rem;

}

.edit-test-form .no-data .message {
  font-size: 1.8rem;
  color: #727272;
}

.edit-test-form .no-data i {
  font-size: 10rem;
  color: #32a88a;
  margin-left: 1rem;
  opacity: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.edit-test-form form {
//border: 1px solid red; display: flex; flex-direction: column;
  padding-right: 1rem;
  padding-bottom: 1rem;

}

.edit-test-form form p {
  font-size: 1.2rem;
  color: #32A88A;
  margin-bottom: 1rem;
}

.edit-test-form form label {
  font-size: 0.9rem;
  color: #727272;
  margin-bottom: 0.5rem;
}

.edit-test-form form .test-input {
  display: flex;
  margin-bottom: 2rem;
}

.edit-test-form form .test-input input {
  border-radius: 0.5rem;
  font-size: 1.2rem;
  height: 3rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  background-color: #bfddfa;
}

.edit-test-form form .question-input {
  display: flex;
  margin-bottom: 1rem;
}

.edit-test-form form .question-input input {

  font-size: 1.1rem;
  height: 2.5rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  background-color: #D6EDFF;
  width: 85%;
  border-radius: 0.5rem 0 0 0.5rem;
}

.edit-test-form form .question-input .panel {
//border: 1px solid red; background-color: #D6EDFF; border-radius: 0 0.5rem 0.5rem 0;
  flex: 1;
}

.edit-test-form form input[type = file] {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.edit-test-form form .row-img {
  margin-bottom: 1rem;
  height: 4rem;
  display: flex;
  align-items: center;
  border: 1px solid red;
}

.edit-test-form form .row-img .section-img {
  height: 3rem;
  width: 3rem;
  margin-right: 1rem;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;

}

.edit-test-form form .row-img .section-img img {
  height: 100%;
  width: 100%;
  border-radius: 50%;
}

.edit-test-form form .row-img .img-name {
//border: 1px solid red; height: 100%;
  margin-left: 1rem;
  display: flex;
  align-items: center;
  color: #727272;

}

.edit-test-form form .row-img .image-input {
  border-radius: 0.5rem;
  height: 80%;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  padding: 1rem;
  background-color: #84DCC6;
  color: white;
  transition: 0.10s ease;

}

.edit-test-form form .row-img .image-input:hover {
  background-color: #3ecea8;
  transition: 0.10s ease;
}

.edit-test-form form .answer-input {
  display: flex;
  margin-bottom: 1rem;
  margin-left: 1rem;
  flex-direction: column;
}

.edit-test-form form .answer-input .input input {
  border-bottom-left-radius: 0.5rem;
  border-top-left-radius: 0.5rem;
  font-size: 0.9rem;
  height: 2rem;
  padding-left: 1rem;
  padding-right: 1rem;
  background-color: #ebf6ff;
  width: 90%;
}

.edit-test-form form .answer-input .input {
  display: flex;
}

.edit-test-form form .answer-input .input .is-true {
//border: 1px solid red; background-color: #ebf6ff; border-bottom-right-radius: 0.5rem;
  border-top-right-radius: 0.5rem;
  display: flex;
  flex: 1;
  align-items: center;
  justify-content: center;
}

.edit-test-form form .answer-input .input .is-true i {
  cursor: pointer;
}


.edit-test-form form input[type = text] {
  color: #6d7bbc;
}

.edit-test-form form button[type = submit] {
  border-radius: 0.5rem;
  height: 3rem;
  background-color: #32A88A;
  color: white;
  margin-top: 2rem;
  transition: 0.25s ease;
}

.edit-test-form form button[type = submit]:hover {
  background-color: #84DCC6;
  transition: 0.25s ease;
}
</style>