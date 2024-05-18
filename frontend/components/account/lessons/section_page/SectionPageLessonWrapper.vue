<template>
  <div class="lesson-wrapper">
    <template v-if="lessonsData">
      <p class="header" @click.prevent=test()>Zajecia</p>
      <template v-if="lessonsData.lessonsCount === 0">
        <div class="no-lessons">
          <div class="clm-2">
            <p>Nie znaleziono słów w tej sekcji</p>
            <p class="refresh">Odśwież</p>
          </div>
          <i class="fi fi-tr-cloud-question"></i>
        </div>
      </template>
      <template v-else>
        <template v-for="lesson in lessonsData.lessons">
          <div class="lesson">
            <div class="id">
              <p>{{ lesson.id }}</p>
            </div>
            <div class="img">
              <img :src="lesson.img" alt="">
            </div>
            <div class="title">
              <p>{{ lesson.title }}</p>
              <p class="uniqid">@{{ lesson.uniqId }}</p>
            </div>
            <div class="edit">
              <div @click.prevent="openLessonForm(lesson.id)" class="btn">
                <i class="fi fi-sr-pencil"></i>
              </div>
            </div>
            <div class="delete">
              <div @click.prevent="tryDelete(lesson.id)" class="btn">
                <i class="fi fi-br-cross"></i>
              </div>
            </div>
          </div>
        </template>
      </template>
    </template>
    <template v-else>
      <p>no data</p>
    </template>
  </div>
</template>

<script setup lang="js">
let props = defineProps(['sectionUniqid', 'isLessonsRefresh'])
let lessonsData
let emit = defineEmits(['isFormOpen', 'tryDeleteLesson'])
let refreshLessons

const {
  data: sectionData,
  error: sectionError,
  refresh: refreshSection,
  pending: sectionPending
} = await useFetch('http://localhost:8000/api/section-by-uniqid', {
      method: 'POST',
      body: {
        uniqid: props.sectionUniqid
      }
    }
)

if (sectionData.value) {
  console.warn('Lessons data is ')
  console.warn(sectionData.value)
}
if (sectionError.value) {
  console.warn('Error: Error from sectionError is ')
  console.warn(sectionError.value)
}
if (sectionData.value) {
  const {
    data: lessons,
    error: lessonsError,
    refresh: refresh,
    pending: lessonsPending
  } = await useFetch('http://localhost:8000/api/lessons-by-section', {
        method: 'POST',
        body: {
          id: sectionData.value.section[0].id
        }
      }
  )
  lessonsData = lessons
  refreshLessons = refresh
}

function openLessonForm(lessonId) {
  emit("isFormOpen", lessonId)
}

watch(() => props.isLessonsRefresh, () => {
  refreshLessons()
});

function tryDelete(lessonId) {
  emit("tryDeleteLesson", lessonId)
}

</script>

<style scoped>
.lesson-wrapper {
//border: 2px solid red; width: 100%;
  flex: 1;
  overflow-y: auto;
  padding-right: 1rem;
}

.lesson-wrapper .no-lessons {
//border: 1px solid red; display: flex;
  align-items: center;
  margin-top: 1rem;
}

.lesson-wrapper .no-lessons .clm-2 {
//border: 1px solid red; height: 100%;
  display: flex;
  flex-direction: column;
}

.lesson-wrapper .no-lessons .clm-2 .refresh {
  font-size: 1.1rem;
  margin-top: 0.8rem;
  cursor: pointer;
}

.lesson-wrapper .no-lessons .clm-2 .refresh:hover {
  text-decoration: underline;
}

.lesson-wrapper .no-lessons i {
  font-size: 10rem;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #32a88a;
  margin-left: 4rem;
}

.lesson-wrapper .no-lessons p {
  font-size: 1.5rem;
  color: #727272;
}

.lesson-wrapper .header {
  font-size: 2rem;
  margin-bottom: 1.5rem;
  color: #727272;
}

.lesson-wrapper .lesson {
//border: 1px solid red; width: 100%;
  height: 5rem;
  margin-bottom: 1rem;
  background-color: white;
  border-radius: 1rem;
  display: flex;
  align-items: center;
  padding: 1rem 1.5rem;
  transition: 0.25s ease;
}

.lesson-wrapper .lesson .id {
//border: 1px solid red; background-color: #acd7ec;
  width: 2rem;
  height: 2rem;
  margin-right: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 0.5rem;
  color: white;
}

.lesson-wrapper .lesson .img {
//border: 1px solid orange; border-radius: 50%;
  width: 3rem;
  height: 3rem;
  margin-right: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-wrapper .lesson .img img {
  border-radius: 50%;
  height: 100%;
  width: 100%;
}

.lesson-wrapper .lesson .title {
//border: 1px solid purple; height: 100%;
  display: flex;
  flex: 1;
  justify-content: center;
  font-size: 1.1rem;
  color: #727272;
  flex-direction: column;
}

.lesson-wrapper .lesson .title .uniqid {
  font-size: 0.85rem;
  margin-top: 0.5rem;
  cursor: pointer;
}

.lesson-wrapper .lesson .title .uniqid:hover {
  text-decoration: underline;
}

.lesson-wrapper .lesson .edit {
//border: 1px solid green; height: 100%;
  width: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-wrapper .lesson .edit .btn {
//border: 1px solid green; width: 2rem;
  height: 2rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.25s ease;
  background-color: #84DCC6;
}

.lesson-wrapper .lesson .edit .btn:hover {
  background-color: #41d5ae;
  transition: 0.25s ease;
}

.lesson-wrapper .lesson .edit .btn i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: white;
}

.lesson-wrapper .lesson .delete {
//border: 1px solid green; height: 100%;
  width: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-wrapper .lesson .delete .btn {
//border: 1px solid green; width: 2.5rem;
  height: 2.5rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #DE7C7C;
  color: white;
  cursor: pointer;
  transition: 0.25s ease;
}

.lesson-wrapper .lesson .delete .btn:hover {
  background-color: #b95656;
  transition: 0.25s ease;
}

.lesson-wrapper .lesson .delete .btn i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
}
</style>