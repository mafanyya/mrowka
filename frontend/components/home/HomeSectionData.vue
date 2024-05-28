<template>
  <div class="home-section">
    <div class="row-1">
      <div class="clm-1">
        <div class="img-1">
          <img src="@/assets/images/astronaut.png" alt="">
        </div>
      </div>
      <div class="clm-2">
        <p class="header-1">Cześć, {{ props.userName }}!</p>
        <p class="header-2">Witaj w świecie języka polskiego!</p>

      </div>
    </div>
  </div>
</template>

<script setup lang="js">
let props = defineProps({
  userName: {
    type: String
  }
})
</script>

<style scoped>
.home-section {
//border: 1px solid red; margin-top: 1rem;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.home-section .row-1 {
//border: 1px solid red; height: 40rem;
  display: flex;
}

.home-section .row-1 .clm-1 {
//border: 1px solid green; width: 45%;
  display: flex;
  align-items: center;
  justify-content: center;

}

.home-section .row-1 .clm-1 .img-1 {
//border: 1px solid grey; display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
}

.home-section .row-1 .clm-1 .img-1 img {
  transform: rotate(-10deg);
  width: 100%;
  height: 100%;
}

.home-section .row-1 .clm-2 {
//border: 1px solid green; width: 55%;
  display: flex;
  flex-direction: column;
  padding: 3rem;
//justify-content: center;


}

.home-section .row-1 .clm-2 .header-1 {
  font-size: 4rem;
//border: 1px solid green; margin-bottom: 2.5rem;
  color: #32a88a;
  width: 90%;
  line-height: 4rem;
  font-weight: 400;
  font-family: 'Bree Serif', serif;
  transform: rotate(-10deg);
  margin-top: 5rem;
}

.home-section .row-1 .clm-2 .header-2 {
  font-size: 2.5rem;
//border: 1px solid green; margin-bottom: 1.5rem;
  color: #6d7bbc;
  transform: rotate(-10deg);
}

.home-section .row-1 .clm-2 .header-3 {
  font-size: 1.5rem;
//border: 1px solid green; width: 70%;
  color: #8B95C9;
  line-height: 2rem;
}
</style>