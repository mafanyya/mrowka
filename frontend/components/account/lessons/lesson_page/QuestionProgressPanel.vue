<template>
<div class="question-progress-panel">
 <div id = "point-1" class="point"></div>
  <div id = "point-2" class="point"></div>
  <div id = "point-3" class="point"></div>
  <div id = "point-4" class="point"></div>
  <div id = "point-5" class="point"></div>
</div>
</template>

<script setup lang="js">
import {onMounted} from "vue";

let props = defineProps({
  questionNumber: {
    type: Number
  },
  isQuestionTrue:
      {
        type: Boolean
      },
  isRefreshPanel:
      {
        type: Boolean
      }
})

onMounted(() => {
  let point1 = document.getElementById('point-1')
  let point2 = document.getElementById('point-2')
  let point3 = document.getElementById('point-3')
  let point4 = document.getElementById('point-4')
  let point5 = document.getElementById('point-5')

  point1.style.backgroundColor = '#D6EDFF'
  point2.style.backgroundColor = '#D6EDFF'
  point3.style.backgroundColor = '#D6EDFF'
  point4.style.backgroundColor = '#D6EDFF'
  point5.style.backgroundColor = '#D6EDFF'
})
watch(() => props.questionNumber, (newValue) => {
  updateProgressPanel(props.questionNumber, props.isQuestionTrue, props.isRefreshPanel)
})

function updateProgressPanel(questionNumber, isQuestionTrue, isRefreshPanel){
  if(questionNumber === 0){
    let point1 = document.getElementById('point-1')
    let point2 = document.getElementById('point-2')
    let point3 = document.getElementById('point-3')
    let point4 = document.getElementById('point-4')
    let point5 = document.getElementById('point-5')

    point1.style.backgroundColor = '#D6EDFF'
    point2.style.backgroundColor = '#D6EDFF'
    point3.style.backgroundColor = '#D6EDFF'
    point4.style.backgroundColor = '#D6EDFF'
    point5.style.backgroundColor = '#D6EDFF'
  }else{
    let point = document.getElementById('point-' + questionNumber)
    switch(isQuestionTrue){
      case true:
        point.style.backgroundColor = '#32A88A'
        break
      case false:
        point.style.backgroundColor = '#DE7C7C'
        break
      default:
        console.warn('ERROR: Error from switch isQuestionTrue. IsQuestionTrue is ' + isQuestionTrue)
        break
    }
  }
}

</script>

<style scoped>
.question-progress-panel{
  width: 100%;
  height: 100%;
  //border: 1px solid red;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.question-progress-panel .point{
  //border: 1px solid blue;
  height: 1rem;
  width: 18%;
  background-color: #D6EDFF;
  border-radius: 0.5rem;
}
</style>