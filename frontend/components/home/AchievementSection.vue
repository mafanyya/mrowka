<template>
  <div class="achievement-section">
    <div class="img">
      <img :src="props.img" alt="">
    </div>
    <div class="title">
      <p>{{props.title}}</p>
    </div>
    <div class="sub-title">
      <p>{{props.subTitle}}</p>
      </div>
  </div>
</template>

<script setup lang="js">
let props = defineProps({
  img:{
    type: String
  },
  title:{
    type: String
  },
  subTitle:{
    type: String
  }
})
</script>


<style scoped>
.achievement-section{
  //border: 1px solid red;
  width: 20rem;
  display: flex;
  flex-direction: column;
}
.achievement-section .img{
  //border: 1px solid red;
  height: 15rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.achievement-section .img img{
  height: 100%;

}
.achievement-section .title{
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: #32A88A;
  height: 3rem;
}
.achievement-section .sub-title{
  margin-top: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  color: #727272;
  line-height: 1.2rem;
  text-align: center;
  height: 2rem;
}
</style>