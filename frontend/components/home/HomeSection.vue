<template>
  <div class="home-section">
    <div class="row-1">
      <div class="clm-1">
        <div class="img-1">
          <img src="@/assets/images/book1.png" alt="">
        </div>
      </div>
      <div class="clm-2">
        <p class="header-1">Zacznij nauczanie polskiego z radością!</p>
        <p class="header-2">Odkryj magię języka</p>
        <p class="header-3">To idealne miejsce, by zacząć naukę języka.
          Interaktywne lekcje i ćwiczenia sprawiają, że nauka staje się przyjemnością.
          Dołącz do nas i pozwól dziecku odkrywać piękno języka polskiego!</p>
      </div>
    </div>
    <div class="row-2">
      <AchievementSection img="/_nuxt/assets/images/calender.png" title="Zawsze na czasie"
                          sub-title="Aktualne materiały dostosowane do najnowszych standardów edukacyjnych."/>
      <div class="image-divide-1">
        <img src="@/assets/images/points1.png" alt="">
      </div>
      <AchievementSection img="/_nuxt/assets/images/clock.png" title="Szybko i łatwo"
                          sub-title="Intuicyjne lekcje, które dzieci mogą śledzić w swoim tempie"/>
      <div class="image-divide-2">
        <img src="@/assets/images/points2.png" alt="">
      </div>
      <AchievementSection img="/_nuxt/assets/images/goal.png" title="Specjalnie dla dzieci"
                          sub-title="Programy stworzone z myślą o najmłodszych uczniach."/>
      <div class="image-divide-3">
        <img src="@/assets/images/points1.png" alt="">
      </div>
      <AchievementSection img="/_nuxt/assets/images/goal-list.png" title="Osiągnaj suksesów"
                          sub-title="Pomagamy osiągać językowe sukcesy na każdym kroku."/>

    </div>
  </div>
</template>

<script setup lang="js">

import AchievementSection from "~/components/home/AchievementSection.vue";
</script>

<style scoped>
.home-section {
//border: 1px solid red; width: 100%;
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
  justify-content: center;
}

.home-section .row-1 .clm-2 .header-1 {
  font-size: 3.5rem;
//border: 1px solid green; margin-bottom: 2.5rem;
  color: #32a88a;
  width: 90%;
  line-height: 4rem;
  font-weight: 400;
  font-family: 'Bree Serif', serif;
}

.home-section .row-1 .clm-2 .header-2 {
  font-size: 2rem;
//border: 1px solid green; margin-bottom: 1.5rem;
  color: #6d7bbc;
}

.home-section .row-1 .clm-2 .header-3 {
  font-size: 1.5rem;
//border: 1px solid green; width: 70%;
  color: #8B95C9;
  line-height: 2rem;
}

.home-section .row-2 {
//border: 1px solid red; height: 26rem;
  padding: 3rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.home-section .row-2 .image-divide-1 {
//border: 1px solid red; height: 5rem;
  width: 7rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: rotate(-5deg);
}

.home-section .row-2 .image-divide-2 {
//border: 1px solid red; height: 5rem;
  width: 7rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.home-section .row-2 .image-divide-3 {
//border: 1px solid red; height: 5rem;
  width: 7rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: rotate(10deg);
}

.home-section .row-2 .image-divide img {
  width: 100%;
}

.home-section .row-3 {
  border: 1px solid red;
  height: 40rem;
}
</style>