<script setup>

</script>

<template>
  <div class="root">
    <div class="logo">
      <img :src="require('/assets/images/logo1.svg')" alt="">
    </div>
    <div class="nav">
      <div class="inner">
        <a href="#">O nas</a>
        <a href="#">Dlaczego my?</a>
        <a href="#">Cennik</a>
      </div>
    </div>
    <div class="login-nav">
        <a href="/sign_in">Zaloguj się</a>
        <a class = "btn" href="/sign_up">Sbróbuj</a>
    </div>

  </div>
</template>

<style scoped>
.root{

  width: 100%;
  height: 85px;
  display: flex;
  align-items: center;
  padding: 2.5em;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
}
.logo{
  //border: 1px solid orange;
  width: 15%;
  height: 90px;
  display: flex;
  justify-content: left;
  align-items: center;
}
.logo img{
  width: 70%;
  height: auto;
}
.nav{
  //border: 1px solid red;
  height: 90px;
  width: 72%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.nav .inner{
  height: 90px;
  width: 28%;
  //border: 1px solid purple;
  display: flex;
  align-items: center;
  justify-content: space-between;
  color: white;
}
.login-nav{
  //border: 1px solid green;
  height: 90px;
  width: 16%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.login-nav .btn{
  font-size: 20px;
  font-weight: 600;
  //border: 2px solid #1a9158;
  background-color: #fefaf0;
  border-radius: 18px;
  padding: 10px 25px;
  color: #7d5afd;
}
.login-nav a{
  font-size: 18px;
  color: #ffffff;

}

</style>