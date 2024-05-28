<template>
  <div class="server-error">
    <div class="clm-1">
      <i class="fi fi-rr-not-found"></i>
    </div>
    <div class="clm-2">
      <p class="header-1">Błąd servera:
        <span class="header-1-2">Strona nie działa</span>
      </p>
      <p class="header-2">Coś poszło nie tak</p>
      <p class="header-3">Spróbuj odświerzyć stronę lub server.</p>
    </div>
  </div>
</template>
<script setup lang="js">

</script>

<style scoped>
.server-error {
//border: 1px solid purple; width: 100%;
  display: flex;
}

.server-error .clm-1 {
  width: 25%;
  font-size: 15rem;
  color: #727272;
  display: flex;
  justify-content: center;
}

.server-error .clm-2 {
  flex: 1;
}

.server-error .clm-2 .header-1 {
  font-size: 2.5rem;
  color: #DE7C7C;
  margin-bottom: 2rem;
}

.server-error .clm-2 .header-1-2 {
  font-size: 2.5rem;

  color: #727272;
}

.server-error .clm-2 .header-2 {
  font-size: 1.5rem;
  color: #727272;
  margin-bottom: 1rem;
}

.server-error .clm-2 .header-3 {
  font-size: 1rem;
  color: #727272;
}
</style>