<template>
  <div class="achievement-form">
    <div class="header">
      <p>Dodaj osiągnięcie</p>
    </div>

    <form @submit.prevent="addAchievement" id="add-achievement-form" class="add-achievement-form">
      <p id="form-error-achievement" class="form-error-achievement"></p>
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
              id="achievement-lesson-id-input"
              placeholder="Wybierz zajęcie"
              v-model="achievementLessonId"
              disabled
          >
          <div id="btn-input" class="btn-input">
            <i id="unfold-icon" class="fi fi-br-angle-circle-down"></i>
          </div>
        </div>
        <div id="lessons-wrapper" class="lessons-wrapper">
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
        <label class="image-input" for="image-input">Wybierz obrazek</label>
        <p id='img-name' class="img-name"></p>
      </div>
      <input
          type="file"
          accept=".png, .jpg, .jpeg"
          id="image-input"
          @change="checkImgSize"
          required
      >
      <button type="submit">Dodaj osiągnięcie</button>
    </form>

  </div>
</template>
<script setup lang="js">
let achievementTitle = ref('')
let img = ref('')
let imgData
let imgName = ref('')
let imgRealName
let achievementLessonId = ref(null)


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
  let lessonsWrapper = document.getElementById('lessons-wrapper')
  let unfoldIcon = document.getElementById('unfold-icon')
  let lessonInput = document.getElementById('achievement-lesson-id-input')
  let btnInput = document.getElementById('btn-input')

  lessonsWrapper.style.display = 'block'
  unfoldIcon.className = 'fi fi-br-angle-circle-up'
  lessonInput.style.borderBottomLeftRadius = '0'
  btnInput.style.borderBottomRightRadius = '0'
}

function lessonSelect(lessonId) {
  let lessonsWrapper = document.getElementById('lessons-wrapper')
  let unfoldIcon = document.getElementById('unfold-icon')
  let lessonInput = document.getElementById('achievement-lesson-id-input')
  let btnInput = document.getElementById('btn-input')

  achievementLessonId.value = lessonId
  lessonsWrapper.style.display = 'none'
  unfoldIcon.className = 'fi fi-br-angle-circle-down'
  lessonInput.value = lessonId
  lessonInput.style.borderBottomLeftRadius = '0.5rem'
  btnInput.style.borderBottomRightRadius = '0.5rem'
}

function checkImgSize(event) {
  const file = event.target.files[0]
  let imgDataLocal = new FormData()
  imgDataLocal.append('image', file)
  console.warn('Size is ' + file.size)
  console.warn('Name is ' + file.name)
  if (file.size < 10600) {
    createError(400)
  } else {
    if (file.size > 5242880) {
      createError(401)
    } else {
      imgData = imgDataLocal
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
        body: imgData
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

function changeImgName(name) {
  let imgNameBlock = document.getElementById('img-name')
  imgNameBlock.innerText = name
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

async function addAchievement() {
  if (!await handelImg()) {
    createError(402)
  } else {
    img.value = createImgPath(imgRealName)
    achievementTitle.value = capitalize(achievementTitle.value)
    const {
      data: achievementAddData,
      error: achievementAddError,
      pending: achievementAddPending
    } = await useFetch('http://localhost:8000/api/add-achievement', {
          method: 'POST',
          body: {
            title: achievementTitle.value,
            img: img.value,
            lessonId: achievementLessonId.value
          },
        }
    )
    console.log('Img is ' + img.value)
    if (achievementAddData.value) {
      let addAchievementForm = document.getElementById('add-achievement-form')
      addAchievementForm.reset
      emit("refreshAchievements")
      console.log('REFRESHING')
      createError(100)
    }
    if (achievementAddError.value) {
      createError(500)
    }
  }
}

function createImgPath(name) {
  return '/_nuxt/assets/images/achievements/' + name
}

function createError(errorCode) {
  const formError = document.getElementById('form-error-achievement')
  switch (errorCode) {
    case 100:
      formError.style.visibility = 'visible'
      formError.style.color = 'green'
      formError.innerText = 'Osiągnięcie dodane pomyślnie'
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

</script>

<style scoped>
.achievement-form {
//border: 1px solid red; width: 100%;
  display: flex;
  flex-direction: column;
  height: 100%;
  overflow-y: auto;
  background-color: #eef6ff;
}

.achievement-form .header {
//border: 1px solid blue; height: 7rem;
  display: flex;
  align-items: center;
  padding: 1rem;
  color: white;
  font-size: 1.5rem;
  background-color: #6d7bbc;
}

.achievement-form form {
  margin: 1.5rem;
}

.achievement-form form .form-error-achievement {
  margin-left: 1rem;
  color: #DE7C7C;
  margin-bottom: 1.5rem;
  transition: 0.25s ease;
}

.achievement-form form label {
  color: #727272;
  padding-left: 0.9rem;

}

.achievement-form form .input-1 {
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

.achievement-form form input[type = file] {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.achievement-form form .row-img {
//border: 1px solid red; height: 3rem;
  display: flex;
  align-items: center;
  margin-top: 2rem;
  margin-left: 0;
}

.achievement-form form .row-img .achieve-img {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 3.5rem;
  width: 3.5rem;
  border-radius: 50%;
  margin-right: 1rem;
}

.achievement-form form .row-img .achieve-img img {
  border-radius: 50%;
  height: 100%;
  width: 100%;
  overflow: hidden;

}

.achievement-form form .row-img .img-name {
//border: 1px solid red; height: 100%; margin-left: 1rem;
  display: flex;
  align-items: center;
  color: #727272;

}

.achievement-form form .row-img .image-input {
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

.achievement-form form .row-img .image-input:hover {
  background-color: #84DCC6;
  transition: 0.25s ease;
}

.achievement-form form .lesson-input {
  display: flex;
  flex-direction: column;
  margin-top: 0.5rem;
}

.achievement-form form .lesson-input .row-1 {
  display: flex;
  height: 2.5rem;
  cursor: pointer;
}

.achievement-form form .lesson-input .row-1 .input-2 {
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

.achievement-form form .lesson-input .row-1 .input-2::placeholder {
  color: #6d7bbc;
}

.achievement-form form .lesson-input .row-1 .btn-input {
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

.achievement-form form .lesson-input .lessons-wrapper {
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

.achievement-form form .lesson-input .lessons-wrapper .lesson {
  height: 1.5rem;
  margin-bottom: 0.5rem;
//border: 1px solid red; display: flex;
  align-items: center;
  cursor: pointer;
}

.achievement-form form .lesson-input .lessons-wrapper .lesson:hover {
  text-decoration: underline;
}

.achievement-form form .lesson-input .lessons-wrapper .lesson .id {
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

.achievement-form form .lesson-input .lessons-wrapper .lesson .img {
  height: 1.5rem;
  width: 1.5rem;
  margin-right: 0.5rem;
}

.achievement-form form button[type = submit] {
  height: 4rem;
  margin-top: 3rem;
  width: 100%;
  border-radius: 0.5rem;
  background-color: #6d7bbc;
  color: white;
  transition: 0.15s ease;
}

.achievement-form form button[type = submit]:hover {
  background-color: #8B95C9;
  transition: 0.15s ease;
}
</style>