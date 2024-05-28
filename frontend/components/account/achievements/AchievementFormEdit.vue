<template>
  <div class="achievement-form-edit">
    <div class="header">
      <p>Edytuj osiągnięcie</p>
    </div>
    <form @submit.prevent="editAchievement" id="edit-achievement-form" class="edit-achievement-form">
      <p id="form-error-achievement-edit" class="form-error-achievement"></p>
      <label for="achievement-title-input">Nazwa</label>
      <input
          class="input-1"
          type="text"
          id="achievement-title-input"
          v-model="achievementTitle"
          maxlength="35"
          minlength="1"
          required
      >
      <label>Zajęcie</label>
      <div class="lesson-input">
        <div @click.prevent="unfoldLessons()" class="row-1">
          <input
              class="input-2"
              type="text"
              id="achievement-lesson-id-input-edit"
              placeholder="Wybierz zajęcie"
              v-model="achievementLessonId"
              required
              disabled
          >
          <div id="btn-input-edit" class="btn-input">
            <i id="unfold-icon-edit" class="fi fi-br-angle-circle-down"></i>
          </div>
        </div>
        <div id="lessons-wrapper-edit" class="lessons-wrapper">
          <template v-for="lesson in lessonsData.lessons">
            <div @click.prevent="lessonSelect(lesson.id)" class="lesson">
              <p class="id">{{ lesson.id }}</p>
              <div class="img">
                <img :src="lesson.img" alt="">
              </div>
              <p class=title>{{ lesson.title }}</p>
            </div>
          </template>
        </div>
      </div>
      <div class="row-img">
        <div @click.prevent="test()" v-if="props.achievement" class="achieve-img">
          <img :src="img" alt="">
        </div>
        <label class="image-input" for="image-input-edit">Wybierz obrazek</label>
        <p id='img-name-edit' class="img-name-edit"></p>
      </div>
      <input
          type="file"
          accept=".png, .jpg, .jpeg"
          id="image-input-edit"
          @change="checkImgSize"
      >
      <button type="submit">Edytuj osiągnięcie</button>
    </form>

  </div>
</template>
<script setup lang="js">

let props = defineProps({
  achievement: {
    type: Object
  }
})

let achievementId = ref
let achievementTitle = ref()
let img = ref()
let achievementLessonId = ref()

let imgData = ref()
let imgName = ref('')
let imgRealName


watch(() => props.achievement, () => {
  achievementId.value = props.achievement.id
  achievementTitle.value = props.achievement.title
  img.value = props.achievement.img
  achievementLessonId.value = props.achievement.lessonId
})


let emit = defineEmits(["refreshAchievements"])
const {
  pending: lessonsPending,
  data: lessonsData,
  error: lessonsError,
  refresh: refreshLessons
} = await useFetch('http://localhost:8000/api/lessons')
if (lessonsError.value) {
  console.log('!ERROR: Lessons fetch error is ')
  console.log(lessonsError.value)
}
if (lessonsData.value) {
  console.log('Lessons fetch data is ')
  console.log(lessonsData.value)
}

function unfoldLessons() {
  let lessonsWrapper = document.getElementById('lessons-wrapper-edit')
  let unfoldIcon = document.getElementById('unfold-icon-edit')
  let lessonInput = document.getElementById('achievement-lesson-id-input-edit')
  let btnInput = document.getElementById('btn-input-edit')

  lessonsWrapper.style.display = 'block'
  unfoldIcon.className = 'fi fi-br-angle-circle-up'
  lessonInput.style.borderBottomLeftRadius = '0'
  btnInput.style.borderBottomRightRadius = '0'
}

function lessonSelect(lessonId) {
  let lessonsWrapper = document.getElementById('lessons-wrapper-edit')
  let unfoldIcon = document.getElementById('unfold-icon-edit')
  let lessonInput = document.getElementById('achievement-lesson-id-input-edit')
  let btnInput = document.getElementById('btn-input-edit')

  achievementLessonId.value = lessonId
  lessonsWrapper.style.display = 'none'
  unfoldIcon.className = 'fi fi-br-angle-circle-down'
  lessonInput.value = lessonId
  lessonInput.style.borderBottomLeftRadius = '0.5rem'
  btnInput.style.borderBottomRightRadius = '0.5rem'
}

function changeImgName(name) {
  let imgNameBlock = document.getElementById('img-name-edit')
  imgNameBlock.innerText = name
}

function checkImgSize(event) {
  console.log('hello')
  const file = event.target.files[0]
  let imgDataLocal = new FormData()
  imgDataLocal.append('image', file)
  console.log("IMG DATA LOCAL IS ")
  console.log(imgDataLocal)
  console.warn('Size is ' + file.size + imgDataLocal)
  console.warn('Name is ' + file.name)
  if (file.size < 10600) {
    createError(400)
  } else {
    if (file.size > 5242880) {
      createError(401)
    } else {
      imgData.value = imgDataLocal
      if (file.name.length < 10) {
        imgName = file.name
        console.log(imgName)
        changeImgName(imgName)
      } else {
        let dotIndex = file.name.lastIndexOf('.');
        if (dotIndex !== -1 && dotIndex > 10) {
          imgName = file.name.slice(0, 10) + '..' + file.name.slice(dotIndex);
          console.log(imgName)
          changeImgName(imgName)
        } else {
          imgName = file.name
          console.log(imgName)
          changeImgName(imgName)
        }
      }
    }
  }
}

async function handelImg() {
  const {
    data: imgUploadData,
    error: imgUploadError,
    pending: imgUploadPending
  } = await useFetch('http://localhost:8000/api/upload-img-achievement', {
        method: 'POST',
        body: imgData.value
      }
  )
  if (imgUploadData.value) {
    console.warn('Data from imgUploadDAta is ')
    console.warn(imgUploadData.value)
    if (imgUploadData.value.data) {
      console.warn(imgUploadData.value.data)
      imgRealName = imgUploadData.value.imgName
      return true
    }
    if (imgUploadData.value.error) {
      console.warn(imgUploadData.value.error)
      return false
    }
  }
  if (imgUploadError.value) {
    console.warn(imgUploadError.value)
    return false
  }
}


function capitalize(sentence) {
  const sentences = sentence.split(/([.!?])/);
  const capitalizedSentences = sentences.map((sentence, index) => {
    if (index % 2 === 0) {
      return sentence.charAt(0).toUpperCase() + sentence.slice(1);
    } else {
      return sentence;
    }
  });
  return capitalizedSentences.join('');
}

async function editAchievement() {
  console.log('EDIT')
  if (imgData.value && !await handelImg()) {
    createError(402)
  } else {
    if (imgData.value) {
      console.log('hi')
      img.value = createImgPath(imgRealName)
    }
    achievementTitle.value = capitalize(achievementTitle.value)
    const {
      data: achievementEditData,
      error: achievementEditError,
      pending: achievementEditPending
    } = await useFetch('http://localhost:8000/api/achievement-edit', {
          method: 'POST',
          body: {
            id: achievementId.value,
            title: achievementTitle.value,
            img: img.value,
            lessonId: achievementLessonId.value
          },
        }
    )
    console.log('Img is ' + img.value)
    if (achievementEditData.value) {
      let addAchievementForm = document.getElementById('edit-achievement-form')
      addAchievementForm.reset
      emit("refreshAchievements")
      console.log('REFRESHING')
      createError(100)
    }
    if (achievementEditError.value) {
      createError(500)
    }
  }
}

function createImgPath(name) {
  return '/_nuxt/assets/images/achievements/' + name
}

function createError(errorCode) {
  const formError = document.getElementById('form-error-achievement-edit')
  switch (errorCode) {
    case 100:
      formError.style.visibility = 'visible'
      formError.style.color = 'green'
      formError.innerText = 'Osiągnięcie zmienione pomyślnie'
      break
    case 400:
      formError.style.visibility = 'visible'
      formError.innerText = 'Obrazek jest za mały (min: 150Kb).'
      break
    case 401:
      formError.style.visibility = 'visible'
      formError.innerText = 'Obrazek jest za duży (max: 5Mb).'
      break
    case 402:
      formError.style.visibility = 'visible'
      formError.innerText = 'Bląd servera: Problem z przesyłaniem obrazka.'
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

function test() {
  console.log('IMG DATA IS ')
  console.log(imgData.value)
}

</script>

<style scoped>
.achievement-form-edit {
//border: 1px solid red; width: 100%;
  display: none;
  flex-direction: column;
  height: 100%;
  overflow-y: auto;
  background-color: #eef6ff;
}

.achievement-form-edit .header {
//border: 1px solid blue; height: 7rem;
  display: flex;
  align-items: center;
  padding: 1rem;
  color: white;
  font-size: 1.5rem;
  background-color: #6d7bbc;
}

.achievement-form-edit form {
  margin: 1.5rem;
}

.achievement-form-edit form .form-error-achievement {
  margin-left: 1rem;
  color: #DE7C7C;
  margin-bottom: 1.5rem;
  transition: 0.25s ease;
}

.achievement-form-edit form label {
  color: #727272;
  padding-left: 0.9rem;

}

.achievement-form-edit form .input-1 {
  background-color: #D6EDFF;
  border-radius: 0.5rem;
  height: 2.5rem;
  margin-top: 0.5rem;
  margin-bottom: 2rem;
  padding-left: 1rem;
  padding-right: 1rem;
  font-size: 0.9rem;
  color: #6d7bbc;
}

.achievement-form-edit form input[type = file] {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.achievement-form-edit form .row-img {
//border: 1px solid red; height: 3rem;
  display: flex;
  align-items: center;
  margin-top: 2rem;
  margin-left: 0;
}

.achievement-form-edit form .row-img .achieve-img {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 3.5rem;
  width: 3.5rem;
  border-radius: 50%;
  margin-right: 1rem;
}

.achievement-form-edit form .row-img .achieve-img img {
  border-radius: 50%;
  height: 100%;
  width: 100%;
  overflow: hidden;

}

.achievement-form-edit form .row-img .img-name-edit {
//border: 1px solid red; height: 100%; margin-left: 1rem;
  display: flex;
  align-items: center;
  color: #727272;

}

.achievement-form-edit form .row-img .image-input {
  border-radius: 0.5rem;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 1rem;
  padding-bottom: 1rem;
  cursor: pointer;
  padding-right: 1rem;
  background-color: #32a88a;
  color: white;
  transition: 0.25s ease;
}

.achievement-form-edit form .row-img .image-input:hover {
  background-color: #84DCC6;
  transition: 0.25s ease;
}

.achievement-form-edit form .lesson-input {
  display: flex;
  flex-direction: column;
  margin-top: 0.5rem;
}

.achievement-form-edit form .lesson-input .row-1 {
  display: flex;
  height: 2.5rem;
  cursor: pointer;
}

.achievement-form-edit form .lesson-input .row-1 .input-2 {
  background-color: #D6EDFF;
  width: 85%;
  height: 100%;
  border-top-left-radius: 0.5rem;
  border-bottom-left-radius: 0.5rem;
  display: flex;
  align-items: center;
  color: #6d7bbc;
  font-size: 0.9rem;
  padding-left: 1rem;
}

.achievement-form-edit form .lesson-input .row-1 .input-2::placeholder {
  color: #6d7bbc;
}

.achievement-form-edit form .lesson-input .row-1 .btn-input {
  background-color: #D6EDFF;
  flex: 1;
  height: 100%;
  border-top-right-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6d7bbc;
}

.achievement-form-edit form .lesson-input .lessons-wrapper {
  background-color: #D6EDFF;
  height: 7rem;
  color: #6d7bbc;
  font-size: 0.9rem;
  border-bottom-left-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
  flex-direction: column;
  padding: 1rem;
  overflow-y: auto;
  display: none;
}

.achievement-form-edit form .lesson-input .lessons-wrapper .lesson {
  height: 1.5rem;
  margin-bottom: 0.5rem;
//border: 1px solid red; display: flex;
  align-items: center;
  cursor: pointer;
}

.achievement-form-edit form .lesson-input .lessons-wrapper .lesson:hover {
  text-decoration: underline;
}

.achievement-form-edit form .lesson-input .lessons-wrapper .lesson .id {
  height: 1.25rem;
  width: 1.25rem;
  background-color: #6d7bbc;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  border-radius: 0.25rem;
  margin-right: 0.5rem;
  font-size: 0.8rem;
}

.achievement-form-edit form .lesson-input .lessons-wrapper .lesson .img {
  height: 1.5rem;
  width: 1.5rem;
  margin-right: 0.5rem;
}

.achievement-form-edit form button[type = submit] {
  height: 4rem;
  margin-top: 3rem;
  width: 100%;
  border-radius: 0.5rem;
  background-color: #6d7bbc;
  color: white;
  transition: 0.15s ease;
}

.achievement-form-edit form button[type = submit]:hover {
  background-color: #8B95C9;
  transition: 0.15s ease;
}
</style>