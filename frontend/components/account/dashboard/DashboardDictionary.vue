<template>
  <div class="dictionary">
    <div class="section">
      <div class="row">
        <p class="label"><i class="fi fi-rr-memo-pad"></i>Łącznie słów :</p>
        <p class="value-1">50
          <span class="value-1-2"></span>
        </p>
      </div>

    </div>
  </div>
</template>
<script setup lang="js">

</script>

<style scoped>
.dictionary {
  width: 100%;

  display: flex;
  flex-direction: column;
}

.dictionary .header {
  background-color: #6d7bbc;
  border-radius: 1rem;
  font-size: 2.5rem;
  margin-bottom: 2rem;
  color: white;
  transition: 0.15s ease;
  padding: 1rem;
}

.dictionary .header:hover {
  background-color: #8B95C9;
  transition: 0.15s ease;
}

.dictionary .header i {
  margin-right: 1rem;
  color: #6D7BBC;
}

.dictionary .section {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.5rem;
  background-color: #f8f8f8;
  border-radius: 1rem;
  padding: 2rem 2rem 1rem;
}

.dictionary .section .row {
//border: 1px solid red; display: flex;
  align-items: end;
  margin-bottom: 1.2rem;
}

.dictionary .section .row .label {
  font-size: 1.2rem;
  color: #727272;
}

.dictionary .section .row .label i {
  margin-right: 0.75rem;
  color: #32A88A;
  font-size: 1.5rem;
}

.dictionary .section .row .value-1 {
//border: 1px solid red; margin-left: 1rem;
  color: #6d7bbc;
  font-size: 2rem;
}

.dictionary .section .row .value-1-2 {
  font-size: 1.2rem;
  color: #727272;
}

.dictionary .section .row-2 {
//border: 1px solid red; display: flex;
  align-items: end;
  margin-bottom: 2rem;
  margin-left: 1rem;
}

.dictionary .section .row-2 .label {
  font-size: 1rem;
  color: #727272;
}

.dictionary .section .row-2 .label i {
  margin-right: 0.5rem;
  color: #32A88A;
  font-size: 0.8rem;
}

.dictionary .section .row-2 .value-1 {
//border: 1px solid red; margin-left: 1rem;
  color: #6d7bbc;
  font-size: 1.2rem;
}

.dictionary .section .row-2 .value-1-2 {
  font-size: 1rem;
  color: #727272;
}
</style>