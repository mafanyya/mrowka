<template>
  <div class="tests">
    <div class="section">
      <div class="row">
        <p class = "label"> <i class="fi fi-rs-rules"></i>Łącznie testów :</p>
        <p v-if = "testsStatistics" class = "value-1">{{testsStatistics.testsCount}}
          <span class = "value-1-2"></span>
        </p>
        <p v-else class = "value-1">0</p>
      </div>

    </div>
  </div>
</template>
<script setup lang="js">
const {
  data: testsStatistics,
  refresh: refreshTestStatistics,
  pending: testsStatisticsPending
} = await useFetch('http://localhost:8000/api/tests-count')

</script>

<style scoped>
.tests{
  width:100%;

  display: flex;
  flex-direction: column;
}
.tests .header{
  background-color: #f8f8f8;
  border-radius: 1rem;
  font-size: 2.5rem;
  margin-bottom: 2rem;
  color: #8B95C9;
  transition: 0.15s ease;
  padding: 1rem;
}
.tests .header:hover {
  color: #6d7bbc;
  transition: 0.15s ease;
}

.tests .header i{
  margin-right: 1rem;
  color: #6D7BBC;
}
.tests .section {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.5rem;
  background-color: #f8f8f8;
  border-radius: 1rem;
  padding: 2rem 2rem 1rem;
}
.tests .section .row{
//border: 1px solid red;
  display: flex;
  align-items: end;
  margin-bottom: 1.2rem;
}
.tests .section .row .label{
  font-size: 1.2rem;
  color: #727272;
}
.tests .section .row .label i{
  margin-right: 0.75rem;
  color: #32A88A;
  font-size: 1.5rem;
}
.tests .section .row .value-1{
//border: 1px solid red;
  margin-left: 1rem;
  color: #6d7bbc;
  font-size: 2rem;
}
.tests .section .row .value-1-2{
  font-size: 1.2rem;
  color: #727272;
}
.tests .section .row-2{
//border: 1px solid red;
  display: flex;
  align-items: end;
  margin-bottom: 2rem;
  margin-left: 1rem;
}
.tests .section .row-2 .label{
  font-size: 1rem;
  color: #727272;
}
.tests .section .row-2 .label i{
  margin-right: 0.5rem;
  color: #32A88A;
  font-size: 0.8rem;
}
.tests .section .row-2 .value-1{
//border: 1px solid red;
  margin-left: 1rem;
  color: #6d7bbc;
  font-size: 1.2rem;
}
.tests .section .row-2 .value-1-2{
  font-size: 1rem;
  color: #727272;
}
</style>