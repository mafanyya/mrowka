<template>
  <div class="progress-bar">
    <div class="header">
      <p>Bezpieczeństwo hasła</p>
      <i class="fi fi-sr-info"
         data-info="Hasło musi zawierać co najmniej 8 znaków,  tym jedną cyfrę (0-9), jedną wielką literę (A-Z), jedną małą literę (a-z) oraz jeden znak specjalny (!@#$%^&*)."></i>
    </div>
    <div id="progress-bar" class="bar">
      <div id="progress-inner" class="inner" @click.prevent="test()"></div>
    </div>
  </div>
</template>
<script setup lang="js">
import {onMounted} from "vue";

let props = defineProps({
  progress: {
    type: Number
  }
})
onMounted(() => {
  updateProgressBar(props.progress)
})
watch(() => props.progress, (newValue) => {
  updateProgressBar(newValue)
})

function updateProgressBar(progress) {
  let inner = document.getElementById('progress-inner')
  let progressBar = document.getElementById('progress-bar')
  console.log(inner)
  if (progress === 0) {
    inner.style.width = '0%'
    inner.style.backgroundColor = '#CD4122'
    progressBar.style.backgroundColor = '#D6EDFF'
    inner.style.borderBottomRightRadius = '0'
    inner.style.borderTopRightRadius = '0'
  } else if (progress === 25) {
    inner.style.width = '25%'
    inner.style.backgroundColor = '#CD4122'
    progressBar.style.backgroundColor = '#DE7C7C'
    inner.style.borderBottomRightRadius = '0'
    inner.style.borderTopRightRadius = '0'
  } else if (progress === 50) {
    inner.style.width = '50%'
    inner.style.backgroundColor = '#E2D02A'
    progressBar.style.backgroundColor = '#EBED7F'
    inner.style.borderBottomRightRadius = '0'
    inner.style.borderTopRightRadius = '0'
  } else if (progress === 75) {
    inner.style.width = '75%'
    inner.style.backgroundColor = '#7FCD1A'
    progressBar.style.backgroundColor = '#ADE564'
    inner.style.borderBottomRightRadius = '0'
    inner.style.borderTopRightRadius = '0'
  } else if (progress === 100) {
    inner.style.width = '100%'
    inner.style.backgroundColor = '#32A88A'
    progressBar.style.backgroundColor = '#84DCC6'
    inner.style.borderBottomRightRadius = '1rem'
    inner.style.borderTopRightRadius = '1rem'
  }
}

</script>
<style scoped>
.progress-bar {
//border: 1px solid red; width: 100%; display: flex;
  flex-direction: column;
  height: 3rem;
  margin-bottom: 2rem;
//align-items: center; justify-content: center; //padding-right: 1rem; //padding-left: 1rem;
}

.progress-bar .header {
//border: 1px solid red; color: #727272; font-size: 0.9rem;
  margin-left: 1rem;
  margin-bottom: 0.5rem;
  display: flex;
  align-items: center;
}

.progress-bar .header i {
  margin-left: 0.5rem;
  color: #3778b0;
  font-size: 1.3rem;
  position: relative;
}

.progress-bar .header i::after {
  content: attr(data-info);
  position: absolute;
  width: 18rem;
  top: 100%;
  left: 50%;
  line-height: 1rem;
  transform: translateX(-50%);
  background-color: #8B95C9;
  color: #fff;
  padding: 1rem;
  border-radius: 1rem;
  font-size: 0.9rem;
  font-style: normal;
  white-space: normal;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
}

.progress-bar .header i:hover::after {
  opacity: 1;
}

.progress-bar .bar {
//border: 1px solid green; background-color: #84DCC6; width: 100%;
  height: 1rem;
  display: flex;
  border-radius: 1rem;
}

.progress-bar .bar .inner {
  width: 75%;
  height: 100%;
  background-color: #32A88A;
  transition: width .2s ease;
  border-radius: 1rem 0 0 1rem;
}


</style>