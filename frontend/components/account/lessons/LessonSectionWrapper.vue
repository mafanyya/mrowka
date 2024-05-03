
<template>

  <div class="lesson-sections-wrapper">

    <template v-for = "lessonSection in lessonSections.sections">
     <div class="lesson-section">
        <div class="clm-1">
          <div class="description">
            <p class = "section-title">{{lessonSection.title}}</p>
            <p class = "section-description">{{lessonSection.description}}</p>
          </div>
          <div class="panel">
            <DifficultyPanel :index = "lessonSection['difficulty']" :id = "lessonSection.id"/>
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
           <button class = "play-btn">
             <i class="fi fi-sr-calendar-lines"></i>
           </button>
         </div>
       </div>
     </div>
    </template>
  </div>
</template>

<script setup lang="ts">
import DifficultyPanel from "~/components/account/lessons/DifficultyPanel.vue";

const {pending, data: lessonSections, refresh: refreshLessonSections} = await useFetch('http://localhost:8000/api/lesson-sections')
console.log(lessonSections.value)

const lessonSectionRef = ref({});

onMounted(async () => {
  console.log(lessonSections.value.sections)
  for (const section of lessonSections.value.sections) {
    console.log('Section is: ' + section)
    console.log('Section id is: ' + section.id)
    const lessonsCount = await getLessonsBySection(section.id);
    lessonSectionRef.value[section.id] = lessonsCount;
  }
});
async function getLessonsBySection(id){
  console.log("ID FROM fetch is " + id)
   const {data: getLessonsBySectionData, error: getLessonsBySectionError} = await useFetch('http://localhost:8000/api/lessons-by-section', {
         method: 'POST',
         body: {
           id: id
         },
       }
   )
   if(getLessonsBySectionData.value){
     console.log('GET LESSONS DATA IS ')
     console.log(getLessonsBySectionData.value.lessonsCount)
     return getLessonsBySectionData.value.lessonsCount
   }
   if(getLessonsBySectionError.value){
     console.log("Error from getLessonsBySection is ")
     console.log(getLessonsBySectionError)

   }
 }
</script>

<style scoped>
.lesson-sections-wrapper{
  //border: 3px solid purple;
  width: 100%;
  height: 100%;
  display: flex;
  flex-wrap: wrap;
  padding: 2rem;
  justify-content: center;
  overflow-y: scroll;
  padding-bottom: 7rem;
}
.lesson-sections-wrapper .lesson-section{
  //border: 1px solid red;
  width: 46%;
  height: 20rem;
  margin: 1rem;
  background-color: #f8f8f8;
  border-radius: 1em;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  padding: 1.5rem;
  display: flex;
}
.lesson-sections-wrapper .lesson-section .clm-1{
  //border: 1px solid grey;
  width: 50%;
  display: flex;
  flex-direction: column;
}
.lesson-sections-wrapper .lesson-section .clm-1 .description{
  //border: 1px solid grey;
  width: 100%;
  height: 80%;
}
.lesson-sections-wrapper .lesson-section .clm-1 .description .section-title{
  font-size: 1.5rem;
  margin-bottom: 2rem;
  color: #8B95C9
;
}
.lesson-sections-wrapper .lesson-section .clm-1 .description .section-description{
  font-size: 0.8rem;
  color: #727272;
  line-height: 1.1rem;
}
.lesson-sections-wrapper .lesson-section .clm-1 .panel{
  //border: 1px solid grey;
  width: 100%;
  height: 20%;
  display: flex;
  flex-direction: column;
}

.lesson-sections-wrapper .lesson-section .clm-2{
  //border: 1px solid grey;
  width: 50%;
  display: flex;
  flex-direction: column;
  margin-left: 0.5rem;

}
.lesson-sections-wrapper .lesson-section .clm-2 .row-1{
  height: 80%;
  //border: 1px solid grey;
  display: flex;
  align-items: center;
  justify-content: center;
}
.lesson-sections-wrapper .lesson-section .clm-2 .row-1 .img{
  //border: 1px solid red;
  width: 10rem;
  height: 10rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.lesson-sections-wrapper .lesson-section .clm-2 .row-1 .img img{
  height: 85%;
  width: 85%;

}

.lesson-sections-wrapper .lesson-section .clm-2 .row-2{
  height: 20%;
  //border: 1px solid grey;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: #727272;
}
.lesson-sections-wrapper .lesson-section .clm-2 .row-2 .play-btn{
  //border: 1px solid red;
  height: 3rem;
  width: 3rem;
  border-radius: 50%;
  margin-left: 1rem;
  color: white;
  background-color: #84DCC6;
  transition: 0.25s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.3rem;
}
.lesson-sections-wrapper .lesson-section .clm-2 .row-2 .play-btn:hover{
  background-color: #32A88A;
  transition: 0.25s ease;
}

</style>