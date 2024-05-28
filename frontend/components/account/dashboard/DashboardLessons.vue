<template>
  <div class="lessons">
    <NuxtLink to = "/dashboard/users">
      <p class = "header"><i class="fi fi-rr-book-bookmark"></i>Zajęcia</p>
    </NuxtLink>
    <div class="section">
      <div class="row">
        <p class = "label"> <i class="fi fi-rr-books"></i>Łącznie sekcje zajęć:</p>
        <p v-if = "lessonStatistics" class = "value-1">{{lessonStatistics.sectionsCount}}
          <span class = "value-1-2"></span>
        </p>
        <p v-else class = "value-1">0</p>
      </div>
      <div class="row">
        <p class = "label"> <i class="fi fi-rr-book"></i>Łącznie zajęć:</p>
        <p v-if = "lessonStatistics" class = "value-1">{{lessonStatistics.lessonsCount}}
          <span class = "value-1-2"></span>
        </p>
        <p v-else class = "value-1">0</p>
      </div>
    </div>
  </div>
</template>
<script setup lang="js">
const {
  data: lessonStatistics,
  refresh: refreshLessonStatistics,
  pending: lessonStatisticsPending
} = await useFetch('http://localhost:8000/api/lessons-count')

</script>

<style scoped>
.lessons{
  width:100%;

  display: flex;
  flex-direction: column;
}
.lessons .header{
  background-color: #32A88A;
  border-radius: 1rem;
  font-size: 2.5rem;
  margin-bottom: 2rem;
  color: white;
  transition: 0.15s ease;
  padding: 1.5rem;
}


.lessons .header i{
  margin-right: 1rem;
  color: white;
}
.lessons .section {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.5rem;
  background-color: #f8f8f8;
  border-radius: 1rem;
  padding: 2rem 2rem 1rem;
}
.lessons .section .row{
//border: 1px solid red;
  display: flex;
  align-items: end;
  margin-bottom: 1.2rem;
}
.lessons .section .row .label{
  font-size: 1.2rem;
  color: #727272;
}
.lessons .section .row .label i{
  margin-right: 0.75rem;
  color: #32A88A;
  font-size: 1.5rem;
  align-items: center;
}
.lessons .section .row .value-1{
//border: 1px solid red;
  margin-left: 1rem;
  color: #6d7bbc;
  font-size: 2rem;
}
.lessons .section .row .value-1-2{
  font-size: 1.2rem;
  color: #727272;
}
.lessons .section .row-2{
//border: 1px solid red;
  display: flex;
  align-items: end;
  margin-bottom: 2rem;
  margin-left: 1rem;
}
.lessons .section .row-2 .label{
  font-size: 1rem;
  color: #727272;
}
.lessons .section .row-2 .label i{
  margin-right: 0.5rem;
  color: #32A88A;
  font-size: 0.8rem;
}
.lessons .section .row-2 .value-1{
//border: 1px solid red;
  margin-left: 1rem;
  color: #6d7bbc;
  font-size: 1.2rem;
}
.lessons .section .row-2 .value-1-2{
  font-size: 1rem;
  color: #727272;
}

</style>