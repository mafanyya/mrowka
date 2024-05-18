<template>
  <div class="tests-wrapper">
    <div v-if="lessonSectionsData" class="inner-wrapper">
      <div id="sections" class="sections">
        <div v-for="section in lessonSectionsData.sections" :id="'section-' + section.id" class="section">
          <div :id="'section-panel-' + section.id" class="section-panel">
            <div class="img">
              <img :src="section.img" alt="">
            </div>
            <p @click.prevent=openCloseLessons(section.id) :id="'section-title-' + section.id" class="section-title">
              {{ section.title }}</p>
            <NuxtLink :to="'/dashboard/lessons/section/' + section.uniqid">
              <p class="uniq-id">@{{ section.uniqid }}</p>
            </NuxtLink>
          </div>
          <div :id="'lessons-' + section.id" class="lessons">
            <template v-for="lesson in lessonSectionsData.lessons">
              <div v-if="lesson.sectionId === section.id" :id="'lesson-' + lesson.id" class="lesson">
                <div class="lesson-panel">
                  <i class="fi fi-ss-dot-circle"></i>
                  <p @click.prevent=openCloseTests(lesson.id) class="lesson-title">{{ lesson.title }}</p>
                </div>
                <div :id="'tests-' + lesson.id" class="tests">
                  <template v-for="test in testsData.tests">
                    <div v-if="test.lessonId === lesson.id" :id="'test-' + test.id" class="test">
                      <div class="test-panel">
                        <i class="fi fi-sr-bullet"></i>
                        <p @click.prevent=openCloseQuestions(test.id) class="test-title">{{ test.title }}</p>
                      </div>
                      <div :id="'questions-' + test.id" class="questions">
                        <template v-for="question in testsData.questions">
                          <div v-if="question.testId === test.id" :id="'question-' + test.id" class="question">
                            <div class="question-panel">
                              <i class="fi fi-br-bullet"></i>
                              <p @click.prevent=openCloseAnswers(question.id,test.id) class="question-title">
                                {{ question.title }}</p>
                            </div>
                            <div :id="'answers-' + question.id" class="answers">
                              <template v-for="answer in testsData.answers">
                                <div v-if="answer.questionId === question.id" class="answer">
                                  <i class="fi fi-br-circle-dashed"></i>
                                  <p @click.prevent="$emit('editTest', test.id)" class="answer-title">
                                    {{ answer.title }}</p>
                                </div>
                              </template>
                            </div>
                          </div>
                        </template>
                      </div>
                    </div>
                  </template>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="js">
let emit = defineEmits(['editTest',])
let props = defineProps({
  isTestRefresh: {
    type: Boolean
  }
})

const {
  pending: sectionsPending,
  data: lessonSectionsData,
  error: lessonSectionsError,
  refresh: refreshLessonSections
} = await useFetch('http://localhost:8000/api/lesson-sections')
if (lessonSectionsData.value) {
  console.log('Lesson section data is ')
  console.log(lessonSectionsData)
}
if (lessonSectionsError.value) {
  console.warn("ERROR: Error from lesson section error is ")
  console.warn(lessonSectionsError.value)
}
const {
  pending: testsPending,
  data: testsData,
  error: testsError,
  refresh: refreshTests
} = await useFetch('http://localhost:8000/api/tests')
if (testsData.value) {
  console.log('Lesson section data is ')
  console.log(testsData.value)
}
if (testsError.value) {
  console.warn("ERROR: Error from lesson section error is ")
  console.warn(testsError.value)
}
watch(() => props.isTestRefresh, async () => {
  console.log('IS REFRESH FROM WATCH')
  await refreshTests()
  await refreshLessonSections
})

function openCloseLessons(sectionId) {
  let lessonsSection = document.getElementById('lessons-' + sectionId)
  let sectionPanel = document.getElementById('section-panel-' + sectionId)
  console.log('Display is ' + lessonsSection.style.display)
  if (lessonsSection.style.display === 'flex') {
    lessonsSection.style.display = 'none'
    sectionPanel.style.marginBottom = 0 + 'rem'
  } else {
    lessonsSection.style.display = 'flex'
    sectionPanel.style.marginBottom = 1.5 + 'rem'
  }
}

function openCloseTests(lessonId) {
  let testsSection = document.getElementById('tests-' + lessonId)
  if (testsSection.style.display === 'flex') {
    testsSection.style.display = 'none'
  } else {
    testsSection.style.display = 'flex'
  }
}

function openCloseQuestions(testId) {
  let questionsSection = document.getElementById('questions-' + testId)
  if (questionsSection.style.display === 'flex') {
    questionsSection.style.display = 'none'
  } else {
    questionsSection.style.display = 'flex'
  }
  emit("editTest", testId)
}

function openCloseAnswers(questionId, testId) {
  let answersSection = document.getElementById('answers-' + questionId)
  if (answersSection.style.display === 'flex') {
    answersSection.style.display = 'none'
  } else {
    answersSection.style.display = 'flex'
    emit("editTest", testId)
  }
}

</script>
<style scoped>
.tests-wrapper {
//border: 1px solid red; width: 100%;
  display: flex;
  flex: 1;
  flex-direction: column;
  padding: 1.5rem;
  overflow-y: auto;
  padding-left: 3rem;
}

.tests-wrapper .inner-wrapper {
//border: 3px solid green; display: flex;
  height: 100%;
  flex-direction: column;
  overflow-y: auto;
}

.tests-wrapper .inner-wrapper .sections {
//border: 1px solid red; display: flex;
  flex-direction: column;
  flex: 1;
}

.tests-wrapper .inner-wrapper .sections .section {
  cursor: pointer;
  margin-bottom: 1rem;
//border: 1px solid red; border-radius: 1rem;
  padding: 1.3rem;
  background-color: #f8f8f8;
  display: flex;
  flex-direction: column;
}

.tests-wrapper .inner-wrapper .sections .section .section-panel {
//border: 1px solid red; display: flex;
  align-items: center;
}

.tests-wrapper .inner-wrapper .sections .section .section-panel .img {
//border: 1px solid green; width: 2.1rem;
  height: 2.1rem;
  margin-right: 1rem;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.tests-wrapper .inner-wrapper .sections .section .section-panel .section-title {
  font-size: 1.1rem;
  color: #727272;
}

.tests-wrapper .inner-wrapper .sections .section .section-panel .img img {
  height: 100%;
  width: 100%;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.tests-wrapper .inner-wrapper .sections .section .section-panel .uniq-id {
  margin-left: 1rem;
  color: #727272;
  font-size: 0.85rem;
  cursor: pointer;
}

.tests-wrapper .inner-wrapper .sections .section .section-panel .uniq-id:hover {
  text-decoration: underline;
}

.tests-wrapper .inner-wrapper .sections .section .lessons {
//border: 1px solid orange; display: none;
  flex-direction: column;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson {
//border: 1px solid red; margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
  margin-left: 1rem;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .lesson-panel {
//border: 1px solid red; display: flex;
  color: #727272;
  margin-bottom: 0.5rem;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .lesson-panel i {
//border: 1px solid green; margin-right: 0.8rem;
  font-size: 0.8rem;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #8B95C9;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests {
//border: 1px solid red; display: none;
  flex-direction: column;
  margin-left: 1rem;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test {
  display: flex;
  flex-direction: column;
  margin-left: 2rem;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .test-panel {
  display: flex;
  margin-bottom: 0.5rem;
  color: #727272;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .test-panel i {
  margin-right: 0.2rem;
  color: #8B95C9;
  display: flex;
  justify-content: center;
  align-items: center;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .questions {
//border: 1px solid #3791da; display: none;
  flex-direction: column;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .questions .question {
  display: flex;
  flex-direction: column;
  margin-left: 2rem;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .questions .question .question-panel {
  display: flex;
  margin-bottom: 0.25rem;
  color: #727272;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .questions .question .question-panel i {
  margin-right: 0.2rem;
  color: #8B95C9;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .questions .question .answers {
//border: 1px solid red; display: none;
  flex-direction: column;
  margin-top: 0.5rem;
  margin-bottom: 0.5rem;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .questions .question .answers .answer {
//border: 1px solid red; margin-left: 2rem;
  display: flex;
  align-items: center;
  margin-bottom: 0.5rem;
  color: #727272;
}

.tests-wrapper .inner-wrapper .sections .section .lessons .lesson .tests .test .questions .question .answers .answer i {
//border: 1px solid green; font-size: 0.7rem;
  margin-right: 0.2rem;
  color: #8B95C9;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>