<template>
<div class="settings-nav-bar">
  <div class="clm-1">
    <p>Użytkownicy</p>
  </div>
  <div class="clm-2">
    <NuxtLink to = "/">
      <div class = 'btn-1'>
        <div class="btn-inner-1">
          <img src="../../../assets/images/icons/cross-small.svg" alt="">
        </div>
      </div>
    </NuxtLink>
    <NuxtLink to = "/">
      <div class = 'btn-2'>
        <div class="btn-inner-2">
          <img src="../../../assets/images/icons/user-add.svg" alt="">
        </div>
      </div>
    </NuxtLink>
  </div>
</div>
</template>

<script setup lang="ts"></script>

<style scoped>
.settings-nav-bar{
  //border: 1px solid orange;
  width: 100%;
  height: 5em;
  display: flex;
  padding-left: 3em;
  padding-right: 3em;
  padding-bottom: 1em;
  background-color: transparent;
}
.settings-nav-bar .clm-1{
  width: 70%;
  display: flex;
  align-items: center;
  font-size: 2.5em;
  color: #6d7bbc;
}
.settings-nav-bar .clm-2{
  width: 30%;
  display: flex;
  justify-content: end;
  align-items: center;
}
.settings-nav-bar .clm-2 .btn-1{
  border-radius: 50%;
  background: #6d7bbc;
  width: 5em;
  height: 5em;
  display: flex;
  align-items: center;
  justify-content: center;
  visibility: hidden;
}
.settings-nav-bar .clm-2 .btn-2{
  border-radius: 50%;
  background: #5aba5a;
  width: 5em;
  height: 5em;
  margin-left: 1.5em;
  display: flex;
  align-items: center;
  justify-content: center;
}
.settings-nav-bar .clm-2 .btn-inner-1{
  border: 2px solid white;
  border-radius: 50%;
  width: 4.5em;
  height: 4.5em;
  display: flex;
  align-items: center;
  justify-content: center;
}

.settings-nav-bar .clm-2 .btn-inner-2{
  border: 2px solid white;
  border-radius: 50%;
  width: 4.5em;
  height: 4.5em;
  display: flex;
  align-items: center;
  justify-content: center;
  padding-left: 0.3em;
}
.settings-nav-bar .clm-2 .btn-inner-1 img{
  width: 55%;
  height: 55%;
}
.settings-nav-bar .clm-2 .btn-inner-2 img{
  width: 55%;
  height: 55%;
}
</style>