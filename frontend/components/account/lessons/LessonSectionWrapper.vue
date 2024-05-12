<template>
  <div class="lesson-sections-wrapper">
    <template v-for="lessonSection in props.lessonSections.sections">
      <NuxtLink :to="'/dashboard/lessons/section/' + lessonSection.uniqid">
      <div class="lesson-section">
        <div class="clm-1">
          <div class="description">
            <p class="section-title">{{ lessonSection.title }}</p>
            <p class="section-description">{{ lessonSection.description }}</p>
          </div>
          <div class="panel">
            <DifficultyPanel :index="lessonSection['difficulty']" :id="lessonSection.id"/>
          </div>
        </div>
        <div class="clm-2">
          <div class="row-1">
            <div class="img">
              <img :src="lessonSection.img" alt="">
            </div>
          </div>
          <div class="row-2" v-if="lessonSectionRef[lessonSection.id] !== undefined">
            <p>Zajęć: {{ lessonSectionRef[lessonSection.id] }}</p>
            <NuxtLink :to="'/dashboard/lessons/section/' + lessonSection.uniqid">
            <button class="play-btn">
              <i class="fi fi-sr-calendar-lines"></i>
            </button>
            </NuxtLink>
          </div>
        </div>
      </div>
        </NuxtLink>
    </template>
  </div>
</template>

<script setup lang="js">
import DifficultyPanel from "~/components/account/lessons/DifficultyPanel.vue";

let props = defineProps({
  lessonSections: {
    type: Object
  },
  lessonSectionsPending: {
    type: Boolean
  },
  refreshLessonSections: {
    type: Function
  }
})

const lessonSectionRef = ref({});

onMounted(async () => {
  for (const section of props.lessonSections.sections) {
    const lessonsCount = await getLessonsBySection(section.id);
    lessonSectionRef.value[section.id] = lessonsCount;
  }
})

async function getLessonsBySection(id) {
  const {
    data: getLessonsBySectionData,
    error: getLessonsBySectionError
  } = await useFetch('http://localhost:8000/api/lessons-by-section', {
        method: 'POST',
        body: {
          id: id
        },
      }
  )
  if (getLessonsBySectionData.value) {
    return getLessonsBySectionData.value.lessonsCount
  }
  if (getLessonsBySectionError.value) {
    console.log("Error from getLessonsBySection is ")
    console.log(getLessonsBySectionError)
  }
}
</script>

<style scoped>
.test-hello{
  display: block;
}

.lesson-sections-wrapper {
//border: 3px solid purple;
  width: 100%;
  height: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  overflow-y: scroll;
  padding: 2rem 2rem 7rem;
}

.lesson-sections-wrapper  a{
  //border: 1px solid red;
  width: 46%;
  height: 20rem;
  margin: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;

}
.lesson-sections-wrapper .lesson-section {
//border: 1px solid red;
  width: 100%;
  background-color: #f8f8f8;
  border-radius: 1em;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  padding: 1.5rem;
  display: flex;
  height: 100%;
}

.lesson-sections-wrapper .lesson-section .clm-1 {
//border: 1px solid grey;
  width: 50%;
  display: flex;
  flex-direction: column;
}

.lesson-sections-wrapper .lesson-section .clm-1 .description {
//border: 1px solid grey;
  width: 100%;
  height: 80%;
  overflow: hidden;
}

.lesson-sections-wrapper .lesson-section .clm-1 .description .section-title {
  font-size: 1.5rem;
  margin-bottom: 2rem;
  color: #8B95C9;
}

.lesson-sections-wrapper .lesson-section .clm-1 .description .section-description {
  font-size: 0.8rem;
  color: #727272;
  line-height: 1.1rem;
  //padding-bottom: 1rem;

}

.lesson-sections-wrapper .lesson-section .clm-1 .panel {
//border: 1px solid grey;
  width: 100%;
  height: 18%;
  display: flex;
  flex-direction: column;
  margin-top: 1rem;
}

.lesson-sections-wrapper .lesson-section .clm-2 {
//border: 1px solid grey;
  width: 50%;
  display: flex;
  flex-direction: column;
  margin-left: 0.5rem;

}

.lesson-sections-wrapper .lesson-section .clm-2 .row-1 {
  height: 80%;
//border: 1px solid grey;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-sections-wrapper .lesson-section .clm-2 .row-1 .img {
//border: 1px solid red;
  width: 10rem;
  height: 10rem;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  border-radius: 0.5rem;
}

.lesson-sections-wrapper .lesson-section .clm-2 .row-1 .img img {
  height: 100%;
  width: 100%;
}

.lesson-sections-wrapper .lesson-section .clm-2 .row-2 {
  height: 20%;
//border: 1px solid grey;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: #727272;
}
.lesson-sections-wrapper .lesson-section .clm-2 .row-2 a{
  //border: 1px solid red;
  height: 100%;
  padding: 0;
  margin: 0;

}

.lesson-sections-wrapper .lesson-section .clm-2 .row-2 .play-btn {
//border: 1px solid red;
  height: 3rem;
  width: 3rem;
  border-radius: 50%;
  color: white;
  background-color: #84DCC6;
  transition: 0.25s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.3rem;
}
.lesson-sections-wrapper .lesson-section .clm-2 .row-2 .play-btn i{
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-sections-wrapper .lesson-section .clm-2 .row-2 .play-btn:hover {
  background-color: #32A88A;
  transition: 0.25s ease;
}

</style>