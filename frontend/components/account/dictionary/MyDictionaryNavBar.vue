<template>
  <div class="dictionary-settings-nav-bar">
    <div class="clm-1">
      <p>Mój słownik</p>
    </div>
  </div>
</template>
<script setup lang="js">
let btnStatus = false
const emit = defineEmits(['updateForm'])
const prop = defineProps(['isPending'])

function addWord() {
  let btnIcon = document.getElementById('btn-icon')
  if (btnStatus === false) {
    emit('updateForm', true)
    btnIcon.className = 'fi fi-sr-memo-pad'
    btnStatus = !btnStatus
  } else {
    emit('updateForm', false)
    btnIcon.className = 'fi fi-sr-add'
    btnStatus = !btnStatus
  }
}

</script>

<style scoped>
.dictionary-settings-nav-bar {
//border: 1px solid red; width: 100%; height: 5rem;
  display: flex;
  margin-top: 1rem;
  padding: 3rem 3rem;
}

.dictionary-settings-nav-bar .clm-1 {
//border: 1px solid red; width: 70%; display: flex;
  align-items: center;
  font-size: 3rem;
  color: #6d7bbc;
}

.dictionary-settings-nav-bar .clm-2 {
//border: 1px solid red; width: 30%; display: flex;
  justify-content: end;
  align-items: center;
}

.dictionary-settings-nav-bar .clm-2 .btn-2 {
  border-radius: 50%;
  background: #32A88A;
  width: 5rem;
  height: 5rem;
  margin-left: 1.5em;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.25s ease;
}

.dictionary-settings-nav-bar .clm-2 .btn-2:hover {
  background: #239076;
  transition: 0.25s ease;
}

.dictionary-settings-nav-bar .clm-2 .btn-inner-2 {
  border: 2px solid white;
  border-radius: 50%;
  width: 4.5em;
  height: 4.5em;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dictionary-settings-nav-bar .clm-2 .btn-inner-2 i {
  font-size: 2.2rem;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>