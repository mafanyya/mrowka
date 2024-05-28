<template>
  <div class="lesson-add-form">
    <p @click.prevent="test()" class="header">Dodawanie zajęcia</p>
    <form @submit.prevent="addLesson()" id="add-lesson-form">
      <p id="form-error" class="form-error"></p>
      <label for="lesson-title-input">Nazwa</label>
      <div class="input-1">
        <input
            form="add-lesson-form"
            v-model="title"
            type="text"
            id="lesson-title-input"
            minlength="1"
            maxlength="30"
        >
      </div>
      <label for="lesson-description-input">Opis zajęcia</label>
      <div class="input-2">
        <textarea
            v-model="description"
            id="lesson-description-input"
            form="add-lesson-form"
            minlength="1"
            maxlength="145"
        />
      </div>
      <label for="lesson-content-input">Konspekt zajęcia</label>
      <div class="input-2">
        <textarea
            v-model="lessonContent"
            id="lesson-content-input"
            form="add-lesson-form"
            minlength="1"
        />
      </div>
      <label for="lesson-url-input">Link do video</label>
      <div class="input-1">
        <input
            form="add-lesson-form"
            v-model="lessonUrl"
            type="text"
            id="lesson-url-input"
            minlength="1"
        >
      </div>
      <label for="lesson-description-input">Sekcja</label>
      <div class="input-3">
        <div class="section-id">
          <p>{{ sectionData.section[0].id }}</p>
        </div>
        <div class="section-img">
          <img :src="sectionData.section[0].img" alt="">
        </div>
        <div class="section-title">{{ sectionData.section[0].title }}</div>
      </div>
      <button type="submit">Dodaj zajęcie</button>
    </form>
  </div>
</template>

<script setup lang="js">
let props = defineProps({
  uniqId: {
    type: String
  }
})
let emit = defineEmits(['refreshLessons'])
const {
  data: sectionData,
  error: sectionError,
  refresh: refreshSection,
  pending: sectionPending
} = await useFetch('http://localhost:8000/api/section-by-uniqid', {
      method: 'POST',
      body: {
        uniqid: props.uniqId
      }
    }
)
if (sectionData.value) {
  console.log('SECTION IS ')
  console.log(sectionData.value.section[0])
}
let title = ref()
let description = ref()
let sectionId = ref(sectionData.value.section[0].id)
let lessonUrl = ref()
let lessonContent = ref()

async function addLesson() {
  title.value = convertTitle(title.value)
  const {
    data: lessonAddData,
    error: lessonAddError,
    pending: lessonAddPending
  } = await useFetch('http://localhost:8000/api/add-lesson', {
        method: 'POST',
        body: {
          title: title.value,
          description: description.value,
          lessonUrl: lessonUrl.value,
          lessonContent: lessonContent.value,
          sectionId: sectionId.value
        },
      }
  )
  console.log('Title is ' + title.value)
  console.log('Description is ' + description.value)
  console.log('SectionId is ' + sectionId.value)
  if (lessonAddData.value) {
    createError(100)
    let addForm = document.getElementById('add-lesson-form')
    addForm.reset()
    emit("refreshLessons")
  }
  if (lessonAddError.value) {
    createError(500)
    console.warn('ERROR: From addLesson function. Error is ')
    console.warn(lessonAddError.value)
  }
}

function convertTitle(title) {
  return title
      .split(/\s+/)
      .map(word => {

        if (word.length === 0) {
          return '';
        } else if (word[0] === word[0].toUpperCase()) {
          return word[0] + word.slice(1).toLowerCase();
        } else {
          return word.toLowerCase();
        }
      })
      .join(' ');
}

function createError(errorCode) {
  const formError = document.getElementById('form-error')
  switch (errorCode) {
    case 100:
      formError.style.visibility = 'visible'
      formError.style.color = 'green'
      formError.innerText = 'Zajęcie dodane pomyślnie'
      break
    case 400:
      formError.style.visibility = 'visible'
      formError.innerText = 'Nieprawidłowa nazwaa'
      break
    case 500:
      formError.style.visibility = 'visible'
      formError.innerText = 'Bląd servera'
      break
    default:
      formError.style.visibility = 'visible'
      formError.innerText = 'Nieznany bład ' + errorCode

  }
}
</script>
<style scoped>
.lesson-add-form {
//border: 1px solid red; width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  padding-top: 1rem;
  padding-right: 2rem;
  padding-left: 2rem;
  overflow-y: auto;
}

.lesson-add-form .header {
  margin-left: 1rem;
  color: #727272;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.lesson-add-form form {
//border: 1px solid red; width: 50%;
}

.lesson-add-form form .form-error {
  color: #DE7C7C;
  margin-left: 1rem;
  margin-bottom: 1rem;
}

.lesson-add-form form label {
  font-size: 1rem;
  color: #727272;
  margin-left: 1rem;
  margin-bottom: 1rem;
}

.lesson-add-form form .input-1 {
  height: 3rem;
  margin-bottom: 2rem;
}

.lesson-add-form form .input-1 input {
  background-color: #D6EDFF;
//border: 1px solid red; height: 3rem; width: 100%;
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  padding-left: 1rem;
  padding-right: 1rem;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  color: #6d7bbc;
}

.lesson-add-form form .input-1 input:focus {
  border: 2px solid #8B95C9;
}

.lesson-add-form form .input-2 {
  height: 7rem;
  margin-bottom: 2rem;
}

.lesson-add-form form .input-2 textarea {
  background-color: #D6EDFF;
//border: 1px solid red; height: 100%; width: 100%;
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  padding: 1rem;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  color: #6d7bbc;
  resize: none;
  line-height: 1.2rem;
}

.lesson-add-form form .input-2 textarea:focus {
  border: 2px solid #8B95C9;
}

.lesson-add-form form .input-3 {
  margin-top: 0.5rem;
  display: flex;
  height: 3rem;
  border-radius: 0.5rem;
  background-color: #D6EDFF;
  padding-left: 1rem;
  padding-right: 1rem;
  align-items: center;
  flex-wrap: wrap;
}

.lesson-add-form form .input-3 .section-id {
//border: 1px solid red; height: 1rem; width: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 0.5rem;
  color: #6d7bbc;
}

.lesson-add-form form .input-3 .section-img {
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lesson-add-form form .input-3 .section-img img {
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.lesson-add-form form .input-3 .section-title {
//border: 1px solid red; flex: 1; font-size: 0.9rem;
  margin-left: 0.5rem;
  display: flex;
  align-items: center;
  color: #6d7bbc;
  text-wrap: normal;
}

.lesson-add-form form .input-3 .input-icon {
  background-color: #D6EDFF;
  display: flex;
  flex: 1;
  border-top-right-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
  justify-content: center;
  align-items: center;
  color: #6d7bbc;
  cursor: pointer;
}

.lesson-add-form form .input-3 input {
  background-color: #D6EDFF;
//border: 1px solid red; height: 2.5rem; width: 85%;
  margin-bottom: 1rem;
  border-top-left-radius: 0.5rem;
  border-bottom-left-radius: 0.5rem;
  padding-left: 1rem;
  padding-right: 1rem;
  font-size: 0.9rem;
  color: #6d7bbc;
  cursor: pointer;
}

.lesson-add-form form .input-3-sections {
  height: 12rem;
//border: 1px solid red; background-color: #D6EDFF; border-bottom-left-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
  padding-left: 1rem;
  padding-right: 1rem;
  padding-top: 0.5rem;
  padding-bottom: 1rem;
  display: none;
}

.lesson-add-form form .input-3-sections .sections-wrapper {
//border: 1px solid red; height: 100%; overflow-y: auto;
  font-size: 0.9rem;
  color: #7886ba;
}

.lesson-add-form form .input-3-sections .sections-wrapper .section {
//border: 1px solid red; height: 1.5rem; margin-bottom: 0.5rem;
  cursor: pointer;
  display: flex;
  align-items: center;
}

.lesson-add-form form .input-3-sections .sections-wrapper .section .id {
  width: 1.2rem;
  height: 1.2rem;
  color: white;
  padding: 0.5rem;
  background-color: #7886ba;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 0.2rem;
  font-size: 0.8rem;
}

.lesson-add-form form .input-3-sections .sections-wrapper .section .img {
//border: 1px solid red; width: 6%; margin-right: 0.5rem;
  margin-left: 0.5rem;
}

.lesson-add-form form .input-3-sections .sections-wrapper .section .title {
  display: flex;
  overflow-wrap: normal;
}

.lesson-add-form form .input-3-sections .sections-wrapper .section:hover {
  background-color: #cae1f3;
}

.lesson-add-form form .input-1 input::placeholder {
  color: #6d7bbc;
}

.lesson-add-form form .input-2 input::placeholder {
  color: #6d7bbc;
}

.lesson-add-form form .input-3 input::placeholder {
  color: #6d7bbc;
}

.lesson-add-form form button[type = submit] {
//border: 1px solid red; width: 100%; height: 4rem;
  margin-top: 2rem;
  background-color: #8B95C9;
  border-radius: 0.5rem;
  color: white;
  transition: 0.20s ease;
}

.lesson-add-form form button[type = submit]:hover {
  background-color: #7886ba;
  transition: 0.20s ease;
}
</style>