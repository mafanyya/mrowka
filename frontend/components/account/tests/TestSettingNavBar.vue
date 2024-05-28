<template>
  <div class="test-settings-nav-bar">
    <div class="clm-1">
      <p id="set-bar-header">Testy</p>
    </div>
  </div>
</template>
<script setup lang="js">
let isFormOpen = false
let emit = defineEmits(['isForm', 'refresh'])
let props = defineProps(['isPending'])

</script>

<style scoped>
.test-settings-nav-bar {
//border: 1px solid red; width: 100%; height: 5rem;
  display: flex;
  margin-top: 1rem;
  padding: 1rem 3rem;
  margin-bottom: 1rem;
}

.test-settings-nav-bar .clm-1 {
//border: 1px solid red; width: 60%; display: flex;
  align-items: center;
  font-size: 3rem;
  color: #6d7bbc;
}

.test-settings-nav-bar .clm-2 {
//border: 1px solid red; display: flex; flex: 1;
  justify-content: end;
  align-items: center;
}

.test-settings-nav-bar .clm-2 .refresh-title {
  color: #727272;
  font-size: 1.1rem;
  margin-right: 1rem;
}

.test-settings-nav-bar .clm-2 .btn-1 {
  border-radius: 50%;
//border: 1px solid red; width: 5em; height: 5em;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.25s ease;
}

.test-settings-nav-bar .clm-2 .btn-1 i {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.2rem;
  color: #6d7bbc;
  transition: 1s ease;
}

.test-settings-nav-bar .clm-2 .btn-1 i:hover {
  transition: 1s ease;
  transform: rotate(90deg);
}

.test-settings-nav-bar .clm-2 .btn-2 {
  border-radius: 50%;
  background: #32A88A;
  width: 5em;
  height: 5em;
  margin-left: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.25s ease;
}

.test-settings-nav-bar .clm-2 .btn-2 i {
  display: flex;
  justify-content: center;
  align-items: center;
}

.test-settings-nav-bar .clm-2 .btn-2:hover {
  background: #239076;
  transition: 0.25s ease;
}

.test-settings-nav-bar .clm-2 .btn-inner-2 {
  border: 2px solid white;
  border-radius: 50%;
  width: 4.5em;
  height: 4.5em;
  display: flex;
  align-items: center;
  justify-content: center;
}

.test-settings-nav-bar .clm-2 .btn-inner-2 i {
  font-size: 2.2rem;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>