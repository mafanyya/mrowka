<script setup>

</script>

<template>
<div class="root">
  <div class="section-1">
    <div class="inner">
      <h1>Kurs polskiego dla Dzieci</h1>
      <h2>Zapewnij swojemu Dziecku najlepszy start</h2>
      <h3>Wystarczy tylko 20 minut dziennie, i dziecko mówi po polsku płynnie i z pewnością siebie!</h3>
      <a href="/sign_up">Spróbuj za darmo</a>
    </div>


  </div>
  <div class="section-2">
    <img :src="require('/assets/images/ant2.svg')" alt="">

  </div>

</div>
</template>

<style scoped>
.root{
  height: 710px;
  display: flex;
  margin-top: 20px;
}
.section-1{
  border: none;
  width: 40%;
  display: flex;
  align-items: center;
  justify-content: center;



}
.section-1 .inner{
  //border: 1px solid black;
  width:90%;
  height: 90%;
}
.section-1 h1{
  color: #effd37;
  font-size: 75px;
}
.section-1 h2{
  color: #fae614;
  font-size: 35px;
  margin-top: 10px;
}
.section-1 h3{
  color: #fefaf0;
  font-size: 25px;
  margin-top: 10px;
  margin-bottom: 65px;
}
.section-1 a{
  font-size: 30px;
  font-weight: 600;
  border: none;
  border-radius: 20px;
  color: #fa8f13;
  background-color: #fefaf0;
  padding: 30px;

}
.section-2{

  width: 60%;
}
.section-2 img{
  width: 100%;
  height: 100%;
}

</style>