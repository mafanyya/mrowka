<template>
  <div class="lesson-edit-form">
    <p @click.prevent="test()" class="header">Edytowanie zajęcia</p>
    <template v-if="lessonData">
      <form @submit.prevent="editLesson()" id="add-lesson-form">
        <p id="form-error" class="form-error"></p>
        <label for="lesson-title-input">Nazwa</label>
        <div class="input-1">
          <input
              v-model="title"
              type="text"
              id="lesson-title-input"
              minlength="1"
              maxlength="50"
          >
        </div>
        <label for="lesson-description-input">Opis zajęcia</label>
        <div class="input-2">
        <textarea
            v-model="description"
            id="lesson-description-input"
            form="add-lesson-form"
            minlength="1"
            maxlength="255"
        />
        </div>
        <label for="lesson-description-input">Sekcja</label>
        <div @click.prevent="openSectionOptions()" class="input-3">
          <input
              v-model="sectionId"
              type="text"
              id="lesson-section-input"
              placeholder="Wybierz sekcję"
              readonly
          >
          <div class="input-icon" id="icon-input">
            <i id="unfold-icon" class="fi fi-br-angle-circle-down"></i>
          </div>
        </div>
        <div class="input-3-sections" id="section-options">
          <div v-if="!lessonSectionsData" class="sections-error">
            <p>Brak danych</p>
          </div>
          <div v-else class="sections-wrapper">
            <template v-for="section in lessonSectionsData.sections">
              <div @click.prevent="selectSectionValue(section.id)" class="section">
                <p class="id">{{ section.id }}</p>
                <div class="img">
                  <img :src="section.img" alt="">
                </div>
                <p class="title">{{ section.title }}</p>
              </div>
            </template>
          </div>
        </div>
        <button type="submit">Edytuj zajęcie</button>
      </form>
    </template>
  </div>
</template>

<script setup lang="js">
let props = defineProps({
  lessonId: {
    type: Number
  }
})
let emit = defineEmits(['refreshLessons'])
const {
  pending: sectionsPending,
  data: lessonSectionsData,
  refresh: refreshLessonSections
} = await useFetch('http://localhost:8000/api/lesson-sections')

const {
  data: lessonData,
  error: lessonError,
  refresh: refreshLesson,
  pending: lessonPending
} = await useFetch('http://localhost:8000/api/lesson-by-id', {
      method: 'POST',
      body: {
        id: props.lessonId
      }
    }
)

if (lessonData.value) {
  console.log("Lesson data is ")
  console.log(lessonData.value.lesson.title)
}
if (lessonError.value) {
  console.warn("ERROR: Error from lessonError is ")
  console.warn(lessonError.value)
}

let title = ref(lessonData.value.lesson.title)
let description = ref(lessonData.value.lesson.description)
let sectionId = ref(lessonData.value.lesson.lessonSection)

async function editLesson() {
  title.value = convertTitle(title.value)
  const {
    data: lessonEditData,
    error: lessonEditError,
    pending: lessonEditPending
  } = await useFetch('http://localhost:8000/api/edit-lesson', {
        method: 'POST',
        body: {
          id: props.lessonId,
          title: title.value,
          description: description.value,
          sectionId: sectionId.value
        },
      }
  )
  console.log('Title is ' + title.value)
  console.log('Description is ' + description.value)
  console.log('SectionId is ' + sectionId.value)
  if (lessonEditData.value) {
    createError(100)
    emit("refreshLessons")
  }
  if (lessonEditError.value) {
    createError(500)
    console.warn('ERROR: From addLesson function. Error is ')
    console.warn(lessonEditError.value)
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
      formError.innerText = 'Zajęcie zmienione pomyślnie'
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

let isSectionSettingsOpen = false

function openSectionOptions() {
  let lessonSectionInput = document.getElementById('lesson-section-input')
  let unfoldIcon = document.getElementById('unfold-icon')
  let iconInput = document.getElementById('icon-input')
  let sectionOptions = document.getElementById('section-options')

  if (!isSectionSettingsOpen) {
    unfoldIcon.className = 'fi fi-br-angle-circle-up'
    iconInput.style.borderBottomRightRadius = '0'
    lessonSectionInput.style.borderBottomLeftRadius = '0'
    sectionOptions.style.display = 'flex'
    isSectionSettingsOpen = !isSectionSettingsOpen
  } else {
    unfoldIcon.className = 'fi fi-br-angle-circle-down'
    iconInput.style.borderBottomRightRadius = '0.5rem'
    lessonSectionInput.style.borderBottomLeftRadius = '0.5rem'
    sectionOptions.style.display = 'none'
    isSectionSettingsOpen = !isSectionSettingsOpen
  }
}

function selectSectionValue(id) {
  let lessonSectionInput = document.getElementById('lesson-section-input')
  let unfoldIcon = document.getElementById('unfold-icon')
  let iconInput = document.getElementById('icon-input')
  let sectionOptions = document.getElementById('section-options')

  unfoldIcon.className = 'fi fi-br-angle-circle-down'
  iconInput.style.borderBottomRightRadius = '0.5rem'
  lessonSectionInput.style.borderBottomLeftRadius = '0.5rem'
  sectionOptions.style.display = 'none'
  isSectionSettingsOpen = !isSectionSettingsOpen
  lessonSectionInput.value = id
  sectionId.value = id
}

</script>
<style scoped>
.lesson-edit-form {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  padding-top: 1rem;
  padding-right: 2rem;
  padding-left: 2rem;
}

.lesson-edit-form .header {
  margin-left: 1rem;
  color: #727272;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.lesson-edit-form form {
//border: 1px solid red; width: 50%;
}

.lesson-edit-form form .form-error {
  color: #DE7C7C;
  margin-left: 1rem;
  margin-bottom: 1rem;
}

.lesson-edit-form form label {
  font-size: 1rem;
  color: #727272;
  margin-left: 1rem;
  margin-bottom: 1rem;
}

.lesson-edit-form form .input-1 {
  height: 3rem;
  margin-bottom: 2rem;
}

.lesson-edit-form form .input-1 input {
  background-color: #D6EDFF;
//border: 1px solid red; height: 3rem;
  width: 100%;
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  padding-left: 1rem;
  padding-right: 1rem;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  color: #6d7bbc;
}

.lesson-edit-form form .input-1 input:focus {
  border: 2px solid #8B95C9;
}

.lesson-edit-form form .input-2 {
  height: 7rem;
  margin-bottom: 2rem;
}

.lesson-edit-form form .input-2 textarea {
  background-color: #D6EDFF;
//border: 1px solid red; height: 100%;
  width: 100%;
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  padding: 1rem;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  color: #6d7bbc;
  resize: none;
  line-height: 1.2rem;
}

.lesson-edit-form form .input-2 textarea:focus {
  border: 2px solid #8B95C9;
}

.lesson-edit-form form .input-3 {
  margin-top: 0.5rem;
  display: flex;
  height: 2.5rem;
  cursor: pointer;

}

.lesson-edit-form form .input-3 .input-icon {
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

.lesson-edit-form form .input-3 input {
  background-color: #D6EDFF;
//border: 1px solid red; height: 2.5rem;
  width: 85%;
  margin-bottom: 1rem;
  border-top-left-radius: 0.5rem;
  border-bottom-left-radius: 0.5rem;
  padding-left: 1rem;
  padding-right: 1rem;
  font-size: 0.9rem;
  color: #6d7bbc;
  cursor: pointer;
}

.lesson-edit-form form .input-3-sections {
  height: 12rem;
//border: 1px solid red; background-color: #D6EDFF;
  border-bottom-left-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
  padding: 0.5rem 1rem 1rem;
  display: none;
}

.lesson-edit-form form .input-3-sections .sections-wrapper {
//border: 1px solid red; height: 100%;
  overflow-y: auto;
  font-size: 0.9rem;
  color: #7886ba;
}

.lesson-edit-form form .input-3-sections .sections-wrapper .section {
//border: 1px solid red; height: 1.5rem;
  margin-bottom: 0.5rem;
  cursor: pointer;
  display: flex;
  align-items: center;
}

.lesson-edit-form form .input-3-sections .sections-wrapper .section .id {
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

.lesson-edit-form form .input-3-sections .sections-wrapper .section .img {
//border: 1px solid red; width: 6%;
  margin-right: 0.5rem;
  margin-left: 0.5rem;
}

.lesson-edit-form form .input-3-sections .sections-wrapper .section .title {
  display: flex;
  overflow-wrap: normal;
}

.lesson-edit-form form .input-3-sections .sections-wrapper .section:hover {
  background-color: #cae1f3;
}

.lesson-edit-form form .input-1 input::placeholder {
  color: #6d7bbc;
}

.lesson-edit-form form .input-2 input::placeholder {
  color: #6d7bbc;
}

.lesson-edit-form form .input-3 input::placeholder {
  color: #6d7bbc;
}

.lesson-edit-form form button[type = submit] {
//border: 1px solid red; width: 100%;
  height: 4rem;
  margin-top: 2rem;
  background-color: #8B95C9;
  border-radius: 0.5rem;
  color: white;
  transition: 0.20s ease;
}
</style>