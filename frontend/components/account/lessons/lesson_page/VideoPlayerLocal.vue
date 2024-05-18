<template>
  <div class="video-container">
    <div class="video-container">
      <iframe
          :src="props.videoUrl"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
      ></iframe>
    </div>
  </div>
</template>
<script setup lang="js">

let props = defineProps({
  videoUrl:{
    type: String,
    required: true
  }
})

</script>

<style scoped>
.video-container {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 aspect ratio */
  height: 0;
  overflow: hidden;
  max-width: 100%;
  background: #000;
}

.video-container iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>