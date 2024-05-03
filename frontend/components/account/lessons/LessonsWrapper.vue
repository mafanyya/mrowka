<template>
<div class="lessons-wrapper">
  <div class="header">
    <p>Wszystkie zajęcia</p>
  </div>
  <template v-for = "lesson in lessonsData.lessons">
    <div class="lesson">
      <div class="id">
        <p >{{lesson.id}}</p>
      </div>
      <div class="img">
        <img :src="lesson.img" alt="">
      </div>
      <div class="inf">
        <p class = "title">{{lesson.title}}</p>
        <p class = "uniqid">@{{lesson.uniqid}}</p>

      </div>


    </div>
  </template>
</div>
</template>

<script setup lang="js">
const {pending, data: lessonsData, error: lessonsError, refresh: refreshLessons} = await useFetch('http://localhost:8000/api/lessons')
if(lessonsError.value){
  console.log('!ERROR: Lessons fetch error is ')
  console.log(lessonsData)
}
</script>

<style scoped>
.lessons-wrapper{
  border: 1px solid green;
  width: 100%;
  height: 100%;
  overflow-y: scroll;

}

.lessons-wrapper .header{
  background-color: #6d7bbc;
  display: flex;
  height: 6rem;
  width: 100%;
  align-items: center;
  padding-left: 1rem;
  font-size: 1.5rem;
  color: white;
  position: sticky;
}
.lessons-wrapper .lesson{
  //border: 1px solid red;
  height: 4.5rem;
  margin-top: 1rem;
  margin-right: 1rem;
  margin-left: 1rem;
  background-color: #f8f8f8;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  border-radius: 1rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  display: flex;
  align-items: center;
}
.lessons-wrapper .lesson .id{
  font-size: 1.2rem;
  color: white;
  //border: 1px solid red;
  background-color: #84DCC6;
  height: 2rem;
  width: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 0.5rem;
}
.lessons-wrapper .lesson .inf{
  //border: 1px solid red;
  height: 2.5rem;
  margin-left: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.lessons-wrapper .lesson .inf .title{
  font-size: 1.1rem;
  color: #727272;
}
.lessons-wrapper .lesson .inf .uniqid{
  font-size: 0.8rem;
  color: #727272;
}
.lessons-wrapper .lesson .img{
  //border: 1px solid red;
  height: 3rem;
  width: 3rem;
  margin-left: 1.5rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.lessons-wrapper .lesson .img img{
  width: 90%;
  height: 90%;

}
</style>