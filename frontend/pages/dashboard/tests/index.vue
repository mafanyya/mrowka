<template>
  <div class="container">
    <div class="local-container">
      <DashboardNavBar/>
      <div class="main">
        <div class="clm-1">
          <TestSettingNavBar/>
          <TestsWrapper @edit-test = editTest :is-test-refresh = isTestRefresh />
        </div>
        <div id = "clm-form" class="clm-2">
          <EditTestForm :test-id = testId :question-id = questionId :answer-id = answerId @refresh-tests = refreshTests />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>

import DashboardNavBar from "~/components/account/DashboardNavBar.vue";
import TestsWrapper from "~/components/account/tests/TestsWrapper.vue";
import EditTestForm from "~/components/account/tests/EditTestForm.vue";
import TestSettingNavBar from "~/components/account/tests/TestSettingNavBar.vue";

definePageMeta({
  middleware: [
    function (to, from,) {
      const {data} = useAuth()
      if (!data.value) {
        return navigateTo('/')
      }
      if (data.value.user.isAdmin !== true){
        return navigateTo('/')
      }
    }
  ]
})

let testId = ref()
let questionId = ref()
let answerId = ref()
let isTestRefresh = ref()
function refreshTests(){
  console.log('REFRESH')
  isTestRefresh.value = !isTestRefresh.value
}
function editTest(id){
  testId.value = id
  console.log('Test id is' + testId.value)
}

</script>
<style scoped>

.local-container {
//border: 1px solid red;
  display: flex;
  width: 100%;
  height: 100%;

}

.local-container .main{
  //border: 1px solid green;
  display: flex;
  flex: 1;
}
.local-container .main .clm-1{
  //border: 1px solid orange;
  flex:1;
  display: flex;
  flex-direction: column;

}
.local-container .main .clm-2{
  //border: 1px solid orange;
  width: 35%;
  padding: 1.5rem;
}

</style>