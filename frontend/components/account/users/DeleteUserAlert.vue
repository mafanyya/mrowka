<template>
<div class="test-container">

</div>

</template>
<script setup lang="js">
const {pending, data: users, refresh: refreshUsers} = await useFetch('http://localhost:8000/api/users')
</script>

<style scoped>

</style>