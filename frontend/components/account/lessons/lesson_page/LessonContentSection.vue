<template>
  <div class="lesson-content-section">
    <VideoPlayerLocal :video-url="props.lessonUrl"/>

    <div class="content-header">Konspekt lekcji</div>
    <div id="lesson-content" class="lesson-content">

    </div>
  </div>
</template>

<script setup lang="js">

import VideoPlayerLocal from "~/components/account/lessons/lesson_page/VideoPlayerLocal.vue";
import {onMounted} from "vue";

onMounted(() => {
  let lessonContent = document.getElementById('lesson-content')
  lessonContent.innerHTML = props.lessonContent
})
let props = defineProps({
  lessonUrl: {
    type: String
  },
  lessonContent: {}
})

let videoUrl = ref('https://www.youtube.com/watch?v=sByP3V1lK_M&ab_channel=%D0%9F%D1%80%D0%B5%D1%81%D1%82%D1%83%D0%BF%D0%BD%D1%8B%D0%B5%D1%83%D0%BC%D1%8B')

</script>

<style scoped>
.lesson-content-section {
  width: 100%;
  height: auto;
//border: 1px solid red; display: flex;
  flex-direction: column;
  border-radius: 1rem;
}

.lesson-content-section .content-header {
  font-size: 2rem;
  margin-top: 2rem;
  color: #727272;
  margin-bottom: 2rem;
}

.lesson-content-section .lesson-content .header-1 {
  color: blue;
  font-size: 2rem;
}
</style>