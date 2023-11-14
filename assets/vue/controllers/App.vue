
<template>
  <div class="root">
    <div class="container">
      <header>
        <Home/>
      </header>
    </div>
  </div>
</template>

<script setup>
import  Home from "./Home.vue";
defineProps({
  items: String
});
</script>

<style scoped>
.root{
  width: 100%;
  background-color: #7d5afd;
  height: 820px;
}
.container{

}

</style>
