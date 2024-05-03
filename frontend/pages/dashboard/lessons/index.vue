<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="clm-1">
          <LessonSettingsNavBar/>
          <LessonSectionWrapper/>
        </div>
        <div class="clm-2">
          <LessonsWrapper/>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import LessonSectionWrapper from "~/components/account/lessons/LessonSectionWrapper.vue";

const data = useAuth()
const {status, refresh, signOut} = useAuth()
// const email = data.data.value.user.email
// const name = data.data.value.user.name
// const avatar = data.data.value.user.avatar
import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import LessonSettingsNavBar from "~/components/account/lessons/LessonSettingsNavBar.vue";
import LessonsWrapper from "~/components/account/lessons/LessonsWrapper.vue";

function logOut() {
  signOut()
  navigateTo("/", {external: true})
}
</script>
<style scoped>
.local-container {
  //border: 1px solid red;
  display: flex;
  width: 100%;
  height: 100%;
  overflow-y: hidden;
}

.local-container .main{
  //border: 1px solid green;
  display: flex;
  flex: 1;
}
.local-container .main .clm-1{
  width: 65%;
}
.local-container .main .clm-2{
  display: flex;
  flex: 1;
  //border: 1px solid red;
}
</style>