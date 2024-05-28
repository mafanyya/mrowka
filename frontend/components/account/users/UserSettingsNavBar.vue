<template>
  <div class="user-settings-nav-bar">
    <div class="clm-1">
      <p>Użytkownicy</p>
    </div>
    <div class="clm-2">
      <NuxtLink to="/">
        <div class='btn-1'>
          <div class="btn-inner-1">
            <img src="../../../assets/images/icons/cross-small.svg" alt="">
          </div>
        </div>
      </NuxtLink>
      <NuxtLink to="/dashboard/users/add">
        <div class='btn-2'>
          <div class="btn-inner-2">
            <i class="fi fi-sr-user-add"></i>
          </div>
        </div>
      </NuxtLink>
    </div>
  </div>
</template>

<script setup lang="js">
</script>

<style scoped>
.user-settings-nav-bar {
//border: 1px solid orange; width: 100%; height: 5rem;
  display: flex;
  padding: 1em 3em;
  background-color: transparent;
}

.user-settings-nav-bar .clm-1 {
  width: 70%;
  display: flex;
  align-items: center;
  font-size: 3rem;
  color: #6d7bbc;
}

.user-settings-nav-bar .clm-2 {
  width: 30%;
  display: flex;
  justify-content: end;
  align-items: center;
}

.user-settings-nav-bar .clm-2 .btn-1 {
  border-radius: 50%;
  background: #6d7bbc;
  width: 5em;
  height: 5em;
  display: flex;
  align-items: center;
  justify-content: center;
  visibility: hidden;
}

.user-settings-nav-bar .clm-2 .btn-2 {
  border-radius: 50%;
  background: #32A88A;
  width: 5em;
  height: 5em;
  margin-left: 1.5em;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.user-settings-nav-bar .clm-2 .btn-2:hover {
  background: #239076;
}

.user-settings-nav-bar .clm-2 .btn-inner-1 {
  border: 2px solid white;
  border-radius: 50%;
  width: 4.5em;
  height: 4.5em;
  display: flex;
  align-items: center;
  justify-content: center;
}

.user-settings-nav-bar .clm-2 .btn-inner-2 {
  border: 2px solid white;
  border-radius: 50%;
  width: 4.5em;
  height: 4.5em;
  display: flex;
  align-items: center;
  justify-content: center;
  padding-left: 0.3em;
}

.user-settings-nav-bar .clm-2 .btn-inner-1 img {
  width: 55%;
  height: 55%;
}

.user-settings-nav-bar .clm-2 .btn-inner-2 i {
  font-size: 2.2rem;
  color: white;
}
</style>