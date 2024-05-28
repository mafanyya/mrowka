<template>
  <div class="difficulty-panel">
    <div class="row-1">
      <p>{{ updateRow1(props.index) }}</p>
    </div>
    <div class="row-2">
      <div class="point-wrapper">
        <div :id="'point-1-'+ props.id" class="point"></div>
        <div :id="'point-2-'+ props.id" class="point"></div>
        <div :id="'point-3-'+ props.id" class="point"></div>
        <div :id="'point-4-'+ props.id" class="point"></div>
      </div>
    </div>
  </div>
</template>
<script setup lang="js">
import {onMounted} from "vue";

let props = defineProps(
    {
      index: {
        type: Number
      },
      id: {
        type: Number
      }
    }
)
onMounted(() => {
  updateRow2(props.index)
})

function updateRow1(index) {
  switch (index) {
    case 1:
      return 'Podstawowy'
    case 2:
      return 'Elementarny'
    case 3:
      return 'Średni'
    case 4:
      return 'Średni+'
    default:
      console.log('ERROR: Difficulty panel error. Undefined index.')
      return 'Nieznany'

  }
}

function updateRow2(index) {
  let point1 = document.getElementById('point-1-' + props.id)
  let point2 = document.getElementById('point-2-' + props.id)
  let point3 = document.getElementById('point-3-' + props.id)
  let point4 = document.getElementById('point-4-' + props.id)

  switch (index) {
    case 1:
      point1.style.backgroundColor = '#32A88A'
      point2.style.backgroundColor = '#c5c5c5'
      point3.style.backgroundColor = '#c5c5c5'
      point4.style.backgroundColor = '#c5c5c5'
      console.log('INDEX IS 1')
      break
    case 2:
      point1.style.backgroundColor = '#32A88A'
      point2.style.backgroundColor = '#32A88A'
      point3.style.backgroundColor = '#c5c5c5'
      point4.style.backgroundColor = '#c5c5c5'
      console.log('INDEX IS 2')
      break
    case 3:
      point1.style.backgroundColor = '#32A88A'
      point2.style.backgroundColor = '#32A88A'
      point3.style.backgroundColor = '#32A88A'
      point4.style.backgroundColor = '#c5c5c5'
      console.log('INDEX IS 3')
      break
    case 4:
      point1.style.backgroundColor = '#32A88A'
      point2.style.backgroundColor = '#32A88A'
      point3.style.backgroundColor = '#32A88A'
      point4.style.backgroundColor = '#32A88A'
      console.log('INDEX IS 4')
      break
    default:
      console.log('ERROR: Difficulty panel error. Undefined index.')
      break
  }
}
</script>
<style scoped>
.difficulty-panel {
//border: 1px solid red; width: 100%; height: 100%;
  display: flex;
  flex-direction: column;
}

.difficulty-panel .row-1 {
//border: 1px solid red; height: 50%; display: flex;
  align-items: center;
  font-size: 0.8rem;
}

.difficulty-panel .row-2 {
//border: 1px solid red; height: 50%; display: flex;
}

.difficulty-panel .row-2 .point-wrapper {
  display: flex;
//border: 1px solid purple; align-items: center; width: 45%;
  justify-content: space-between;
}

.difficulty-panel .row-2 .point-wrapper .point {
//border: 1px solid green; background-color: #c5c5c5; height: 0.9rem;
  width: 0.9rem;
  border-radius: 50%;
}
</style>