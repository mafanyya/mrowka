<template>
  <p class="header">Usuń sekcję</p>
  <div class="section-delete-form">
    <p class="header-2">Uwaga!</p>
    <p class="header-3">Jeśli usuniesz sekcję zajęć, wszystkie zajęcia w sekcji zostaną całkowicie usunięte. </p>
    <p class="header-4">Nie można anulować tej akcji.</p>
    <p id="psw-error" class="error-label"></p>
    <button v-if="props.uniqId" @click.prevent=deleteSection() id="delete-btn" class="delete-btn">Usuń sekcję</button>
  </div>
</template>

<script setup lang="js">
let password = ref('')

let props = defineProps({
  uniqId: {
    type: String,
  }
})

async function deleteSection() {
  const {
    data: deleteSectionData,
    error: deleteSectionError
  } = await useFetch('http://localhost:8000/api/remove-lesson-section', {
        method: 'POST',
        body: {
          uniqId: props.uniqId
        }
      }
  )
  if (deleteSectionData.value) {
    console.log('Lesson section successfully deleted')
    console.log(deleteSectionData)
    createError(100)

    function navigate() {
      navigateTo('/dashboard/lessons')
    }
    setTimeout(navigate, 3000)
  }
  if (deleteSectionError.value) {
    console.log('Lesson section delete error is ')
    console.log(deleteSectionError)
    createError(500)
  }
}

function createError(errorCode) {
  const registerError = document.getElementById('psw-error')
  switch (errorCode) {
    case 100:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'green'
      registerError.innerText = 'Sekcja zajęć została pomyślnie usunięta'
      break
    case 500:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Bląd servera'
      break
    default:
      registerError.style.visibility = 'visible'
      registerError.style.color = 'red'
      registerError.innerText = 'Nieznany bład ' + errorCode
  }
}
</script>

<style scoped>
.header {
//border: 1px solid red; margin-bottom: 1rem;
  font-size: 2rem;
  color: #727272;
}

.section-delete-form {
//border: 1px solid red; height: 100%;
  width: 90%;
  display: flex;
  flex-direction: column;
}

.section-delete-form .error-label {
  color: #d15656;
  font-size: 0.9rem;
  margin-left: 1rem;
  margin-bottom: 2rem;
}

.section-delete-form .header-2 {
  font-size: 1.8rem;
  margin-top: 1rem;
  color: #DE7C7C;
}

.section-delete-form .header-3 {
  font-size: 1.1rem;
  margin-top: 1.5rem;
  line-height: 1.5rem;
  color: #727272;
}

.section-delete-form .header-4 {
  font-size: 1.1rem;
  margin-top: 1rem;
  margin-bottom: 2rem;
  color: #727272;
}

.section-delete-form .delete-btn {
//border: 1px solid red; width: 50%;
  height: 4.5rem;
  border-radius: 1rem;
  background-color: #DE7C7C;
  color: white;
  transition: 0.25s ease;
}

.section-delete-form .delete-btn:hover {
  background-color: #d15656;
  transition: 0.25s ease;
}

.section-delete-form .error-label {
  color: #d15656;
  font-size: 0.9rem;
  margin-left: 1rem;
}
</style>