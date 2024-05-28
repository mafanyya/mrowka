<template>
  <div class="footer">
    <p>&copy; {{ currentYear }} Mrówka.</p>
    <p>Made by Maryia Pahoda</p>
  </div>
</template>
<script setup lang="js">
let currentYear = new Date().getFullYear()
</script>

<style scoped>
.footer {
//border: 1px solid red; width: 100%;
  height: 5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  color: #727272;
}

.footer p {
  margin-bottom: 0.5rem;
}
</style>