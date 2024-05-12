<template>
  <div class="header">
    <p id = "lessons-header">Wszystkie zajęcia</p>
    <div @click.prevent = "updateLessonWrapper()" class = "add-lesson-btn">
      <div class="btn-inner">
        <i id = "btn-lesson-icon" class="fi fi-ss-add"></i>
      </div>
    </div>
  </div>
<div id = "lessons-wrapper" class="lessons-wrapper">
  <template v-for = "lesson in lessonsData.lessons">
    <div class="lesson">
      <div class="id">
        <p >{{lesson.id}}</p>
      </div>
      <div class="img">
        <img :src="lesson.img" alt="">
      </div>
      <div class="inf">
        <p class = "title">{{lesson.title}}</p>
        <p class = "uniqid">@{{lesson.uniqid}}</p>
      </div>
    </div>
  </template>
</div>
  <div id = "add-lesson" class="add-lesson">
    <form @submit.prevent = "addLesson()" id = "add-lesson-form">
      <p id = "form-error" class = "form-error"></p>
      <label for="lesson-title-input">Nazwa</label>
      <div class="input-1">
        <input
            v-model = "title"
            type="text"
            id = "lesson-title-input"
            minlength="1"
            maxlength="30"
        >
      </div>
      <label for="lesson-description-input">Opis zajęcia</label>
      <div class="input-2">
        <textarea
            v-model = "description"
            id = "lesson-description-input"
            form = "add-lesson-form"
            minlength="1"
            maxlength="145"
        />
      </div>
      <label for="lesson-description-input">Sekcja</label>
      <div  @click.prevent = "openSectionOptions()" class="input-3">
        <input
            v-model = "sectionId"
            type="text"
            id = "lesson-section-input"
            placeholder="Wybierz sekcję"
            readonly
        >
        <div class="input-icon" id = "icon-input">
          <i id = "unfold-icon" class="fi fi-br-angle-circle-down"></i>
        </div>
      </div>
      <div class="input-3-sections" id = "section-options">
        <div v-if="!lessonSectionsData" class="sections-error">
          <p>Brak danych</p>
        </div>
        <div v-else class="sections-wrapper" >
          <template v-for = "section in lessonSectionsData.sections">
            <div @click.prevent = "selectSectionValue(section.id)" class="section">
              <p class = "id">{{section.id}}</p>
              <div class="img">
                <img :src="section.img" alt="">
              </div>
              <p class = "title">{{section.title}}</p>
            </div>
          </template>
        </div>
      </div>
      <button type = "submit">Dodaj zajęcie</button>
    </form>
  </div>
</template>

<script setup lang="js">
let title = ref('')
let description = ref('')
let sectionId = ref('')
const {pending: lessonsPending, data: lessonsData, error: lessonsError, refresh: refreshLessons} = await useFetch('http://localhost:8000/api/lessons')
const {pending: sectionsPending, data: lessonSectionsData, refresh: refreshLessonSections} = await useFetch('http://localhost:8000/api/lesson-sections')
if(lessonsError.value){
  console.log('!ERROR: Lessons fetch error is ')
  console.log(lessonsData)
}

async function addLesson(){
      title.value = convertTitle(title.value)
      const {data: lessonAddData, error: lessonAddError, pending: lessonAddPending} = await useFetch('http://localhost:8000/api/add-lesson', {
            method: 'POST',
            body: {
              title: title.value,
              description: description.value,
              sectionId: sectionId.value
            },
          }
      )
      let addForm = document.getElementById('add-lesson-form')
      addForm.reset()

      console.log('Title is '+ title.value)
      console.log('Description is '+ description.value)
      console.log('SectionId is '+ sectionId.value)
      if(lessonAddData.value){
        createError(100)
      }
      if(lessonAddError.value){
        createError(500)
        console.warn('ERROR: From addLesson function. Error is ')
        console.warn(lessonAddError.value)
      }
}
function convertTitle(title){
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

function createError(errorCode){
  const formError =  document.getElementById('form-error')
  switch (errorCode){
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

let isLessonFormOpen = false
onMounted(async () => {
  let lessonsWrapper = document.getElementById('lessons-wrapper')
  let addLesson = document.getElementById('add-lesson')
  let btnLessonIcon = document.getElementById('btn-lesson-icon')
  let wrapperHeader = document.getElementById('lessons-header')
  wrapperHeader.innerText = 'Wszystkie zajęcia'
  btnLessonIcon.className = 'fi fi-ss-add'
  lessonsWrapper.style.display = 'block'
  addLesson.style.display = 'none'
  isLessonFormOpen = false
});

function updateLessonWrapper(){
  let lessonsWrapper = document.getElementById('lessons-wrapper')
  let addLesson = document.getElementById('add-lesson')
  let btnLessonIcon = document.getElementById('btn-lesson-icon')
  let wrapperHeader = document.getElementById('lessons-header')

  if (isLessonFormOpen === false){
    wrapperHeader.innerText = 'Dodaj zajęcie'
    btnLessonIcon.className = 'fi fi-sr-memo-pad'
    lessonsWrapper.style.display = 'none'
    addLesson.style.display = 'flex'
    isLessonFormOpen = true
  }else{
    wrapperHeader.innerText = 'Wszystkie zajęcia'
    btnLessonIcon.className = 'fi fi-ss-add'
    lessonsWrapper.style.display = 'block'
    addLesson.style.display = 'none'
    isLessonFormOpen = false
  }
}
let isSectionSettingsOpen = false

function openSectionOptions(){
  let lessonSectionInput = document.getElementById('lesson-section-input')
  let unfoldIcon = document.getElementById('unfold-icon')
  let iconInput = document.getElementById('icon-input')
  let sectionOptions = document.getElementById('section-options')

  if(!isSectionSettingsOpen){
    unfoldIcon.className = 'fi fi-br-angle-circle-up'
    iconInput.style.borderBottomRightRadius = '0'
    lessonSectionInput.style.borderBottomLeftRadius = '0'
    sectionOptions.style.display = 'flex'
    isSectionSettingsOpen = !isSectionSettingsOpen
  }else{
    unfoldIcon.className = 'fi fi-br-angle-circle-down'
    iconInput.style.borderBottomRightRadius = '0.5rem'
    lessonSectionInput.style.borderBottomLeftRadius = '0.5rem'
    sectionOptions.style.display = 'none'
    isSectionSettingsOpen = !isSectionSettingsOpen
  }
}
function selectSectionValue(id){
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
.lessons-wrapper{
  //border: 1px solid green;
  width: 100%;
  height: 100%;
  overflow-y: scroll;
  display: block;


}
.add-lesson{
//border: 1px solid red;
  width: 100%;
  height: 100%;
  display: none;
  padding-top: 2rem;
  padding-right: 2rem;
  padding-left: 2rem;
}
.add-lesson form{
  //border: 1px solid red;
  width: 100%;
}
.add-lesson form .form-error{
  color: #DE7C7C;
  margin-left: 1rem;
  margin-bottom: 1rem;
}
.add-lesson form label{
  font-size: 1rem;
  color: #727272;
  margin-left: 1rem;
  margin-bottom: 1rem;

}
.add-lesson form  .input-1{
  height: 2.5rem;
  margin-bottom: 2rem;
}
.add-lesson form  .input-1 input{
  background-color: #D6EDFF;
  //border: 1px solid red;
  height: 2.5rem;
  width: 100%;
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  padding-left: 1rem;
  padding-right: 1rem;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  color: #6d7bbc;
}
.add-lesson form  .input-1 input:focus{
  border: 2px solid #8B95C9;
}
.add-lesson form  .input-2{
  height: 7rem;
  margin-bottom: 2rem;
}
.add-lesson form  .input-2 textarea{
  background-color: #D6EDFF;
//border: 1px solid red;
  height: 100%;
  width: 100%;
  margin-bottom: 1rem;
  border-radius: 0.5rem;
  padding: 1rem;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  color: #6d7bbc;
  resize: none;
}
.add-lesson form  .input-2 textarea:focus{
  border: 2px solid #8B95C9;
}
.add-lesson form  .input-3{
  margin-top: 0.5rem;
  display: flex;
  height: 2.5rem;
  cursor: pointer;

}
.add-lesson form  .input-3 .input-icon{
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
.add-lesson form  .input-3 input{
  background-color: #D6EDFF;
  //border: 1px solid red;
  height: 2.5rem;
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
.add-lesson form  .input-3-sections{
  height: 12rem;
  //border: 1px solid red;
  background-color: #D6EDFF;
  border-bottom-left-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
  padding-left: 1rem;
  padding-right: 1rem;
  padding-top: 0.5rem;
  padding-bottom: 1rem;
  display: none;
}
.add-lesson form  .input-3-sections .sections-wrapper{
  //border: 1px solid red;
  height: 100%;
  overflow-y: auto;
  font-size: 0.9rem;
  color: #7886ba;

}
.add-lesson form  .input-3-sections .sections-wrapper .section{
  //border: 1px solid red;
  height: 1.5rem;
  margin-bottom: 0.5rem;
  cursor: pointer;
  display: flex;
  align-items: center;
}
.add-lesson form  .input-3-sections .sections-wrapper .section .id{
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
.add-lesson form  .input-3-sections .sections-wrapper .section .img{
//border: 1px solid red;
  width: 6%;
  margin-right: 0.5rem;
  margin-left: 0.5rem;
}
.add-lesson form  .input-3-sections .sections-wrapper .section .title{
  display: flex;
  overflow-wrap: normal;
}

.add-lesson form  .input-3-sections .sections-wrapper .section:hover{
  background-color: #cae1f3;
}
.add-lesson form  .input-1 input::placeholder{
  color: #6d7bbc;
}
.add-lesson form  .input-2 input::placeholder{
  color: #6d7bbc;
}
.add-lesson form  .input-3 input::placeholder{
  color: #6d7bbc;
}
.add-lesson form button[type = submit]{
//border: 1px solid red;
  width: 100%;
  height: 4rem;
  margin-top: 2rem;
  background-color: #8B95C9;
  border-radius: 0.5rem;
  color: white;
  transition: 0.20s ease;
}

.header{
  background-color: #6d7bbc;
  display: flex;
  height: 6rem;
  width: 100%;
  align-items: center;
  padding-left: 1rem;
  font-size: 1.5rem;
  color: white;
  position: sticky;
  justify-content: space-between;
  padding-right: 1rem;
}

.header .add-lesson-btn{
  background-color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 4rem;
  width: 4rem;
  border-radius: 50%;
  cursor: pointer;
  transition: 0.25s ease;
}
.header .add-lesson-btn:hover{
  background-color: #e6e6e6;
  transition: 0.25s ease;
}

.header .add-lesson-btn .btn-inner{
  border: 2px solid #6D7BBC;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 3rem;
  width: 3rem;
  border-radius: 50%;
  color: #6D7BBC;
}

.header .add-lesson-btn .btn-inner i{
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.7rem;
}
.lessons-wrapper .lesson{
  //border: 1px solid red;
  height: 4.5rem;
  margin-top: 1rem;
  margin-right: 1rem;
  margin-left: 1rem;
  background-color: #f8f8f8;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  border-radius: 1rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  display: flex;
  align-items: center;
}
.lessons-wrapper .lesson .id{
  font-size: 1.2rem;
  color: white;
  //border: 1px solid red;
  background-color: #84DCC6;
  height: 2rem;
  width: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 0.5rem;
}
.lessons-wrapper .lesson .inf{
  //border: 1px solid red;
  height: 2.5rem;
  margin-left: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.lessons-wrapper .lesson .inf .title{
  font-size: 1.1rem;
  color: #727272;
}
.lessons-wrapper .lesson .inf .uniqid{
  font-size: 0.8rem;
  color: #727272;
}
.lessons-wrapper .lesson .img{
  //border: 1px solid red;
  height: 3rem;
  width: 3rem;
  margin-left: 1.5rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.lessons-wrapper .lesson .img img{
  width: 90%;
  height: 90%;

}
</style>