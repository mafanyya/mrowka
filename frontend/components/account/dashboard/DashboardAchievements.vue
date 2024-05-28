<template>
  <div class="achievements">
    <div class="section">
      <div class="row">
        <p class="label"><i class="fi fi-rr-trophy-star"></i>Łącznie osiągnięć:</p>
        <p class="value-1">24
          <span class="value-1-2"></span>
        </p>
      </div>

    </div>
  </div>
</template>
<script setup lang="js">

</script>

<style scoped>
.achievements {
  width: 100%;

  display: flex;
  flex-direction: column;
}

.achievements .header {
  background-color: #f8f8f8;
  border-radius: 1rem;
  font-size: 2.5rem;
  margin-bottom: 2rem;
  color: #8B95C9;
  transition: 0.15s ease;
  padding: 1rem;
}

.achievements .header:hover {
  color: #6d7bbc;
  transition: 0.15s ease;
}

.achievements .header i {
  margin-right: 1rem;
  color: #6D7BBC;
}

.achievements .section {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.5rem;
  background-color: #f8f8f8;
  border-radius: 1rem;
  padding: 2rem 2rem 1rem;
}

.achievements .section .row {
//border: 1px solid red; display: flex;
  align-items: end;
  margin-bottom: 1.2rem;
}

.achievements .section .row .label {
  font-size: 1.2rem;
  color: #727272;
}

.achievements .section .row .label i {
  margin-right: 0.75rem;
  color: #32A88A;
  font-size: 1.5rem;
}

.achievements .section .row .value-1 {
//border: 1px solid red; margin-left: 1rem;
  color: #6d7bbc;
  font-size: 2rem;
}

.achievements .section .row .value-1-2 {
  font-size: 1.2rem;
  color: #727272;
}

.achievements .section .row-2 {
//border: 1px solid red; display: flex;
  align-items: end;
  margin-bottom: 2rem;
  margin-left: 1rem;
}

.achievements .section .row-2 .label {
  font-size: 1rem;
  color: #727272;
}

.achievements .section .row-2 .label i {
  margin-right: 0.5rem;
  color: #32A88A;
  font-size: 0.8rem;
}

.achievements .section .row-2 .value-1 {
//border: 1px solid red; margin-left: 1rem;
  color: #6d7bbc;
  font-size: 1.2rem;
}

.achievements .section .row-2 .value-1-2 {
  font-size: 1rem;
  color: #727272;
}
</style>