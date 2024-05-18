<template>
  <div class="section-edit-form">
    <p class="header">Edytowanie zajęcia</p>
    <template v-if="sectionData">
      <form id="add-lesson-section-data" @submit.prevent="editLessonSection()">
        <p id="form-error-sections" class="form-error-sections"></p>
        <label for="title-input">Nazwa</label>
        <input
            type="text"
            v-model="title"
            id="title-input"
            maxlength="30"
            minlength="1"
            required
        >
        <label>Trudność</label>
        <div class="difficulty-input">
          <div class="panel">
            <div @click.prevent="selectDifficulty(1)" class="point" id="pnt-1"></div>
            <div @click.prevent="selectDifficulty(2)" class="point" id="pnt-2"></div>
            <div @click.prevent="selectDifficulty(3)" class="point" id="pnt-3"></div>
            <div @click.prevent="selectDifficulty(4)" class="point" id="pnt-4"></div>
          </div>
          <p id="difficulty-header" class="difficulty-header"></p>
        </div>
        <label for="description-input">Opis</label>
        <textarea
            id='description-input'
            v-model="description"
            rows=5
            form="add-lesson-section-data"
            maxlength="145"
            minlength="1"
            required
        />
        <div class="row-img">
          <div class="section-img">
            <img :src="sectionData.section[0].img" alt="">
          </div>
          <label class="image-input" for="image-input">Wybierz obrazek</label>
          <p id='img-name' class="img-name"></p>
        </div>
        <input
            type="file"
            accept=".png, .jpg, .jpeg"
            id="image-input"
            @change="checkImgSize"
        >
        <button type="submit">Edytuj sekcję</button>
      </form>
    </template>
  </div>
</template>

<script setup lang="js">

let props = defineProps({
  uniqId: {
    type: String
  }
})
let emit = defineEmits(['refreshLessonSection'])

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
let id = ref(sectionData.value.section[0].id)
let title = ref(sectionData.value.section[0].title)
let difficulty = ref(sectionData.value.section[0].difficulty)
let description = ref(sectionData.value.section[0].description)
let img = ref(sectionData.value.section[0].img)
let imgData
let imgName = ref('')
let imgRealName

onMounted(async () => {
  let pnt1 = document.getElementById('pnt-1')
  let pnt2 = document.getElementById('pnt-2')
  let pnt3 = document.getElementById('pnt-3')
  let pnt4 = document.getElementById('pnt-4')
  let difficultyHeader = document.getElementById('difficulty-header')

  switch (sectionData.value.section[0].difficulty) {
    case 1:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#84DCC6'
      pnt3.style.backgroundColor = '#84DCC6'
      pnt4.style.backgroundColor = '#84DCC6'
      difficultyHeader.innerText = 'Podstawowy'
      break
    case 2:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#32A88A'
      pnt3.style.backgroundColor = '#84DCC6'
      pnt4.style.backgroundColor = '#84DCC6'
      difficultyHeader.innerText = 'Elementarny'
      break
    case 3:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#32A88A'
      pnt3.style.backgroundColor = '#32A88A'
      pnt4.style.backgroundColor = '#84DCC6'
      difficultyHeader.innerText = 'Średni'
      break
    case 4:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#32A88A'
      pnt3.style.backgroundColor = '#32A88A'
      pnt4.style.backgroundColor = '#32A88A'
      difficultyHeader.innerText = 'Średni+'
      break
    default:
      pnt1.style.backgroundColor = '#84DCC6'
      pnt2.style.backgroundColor = '#84DCC6'
      pnt3.style.backgroundColor = '#84DCC6'
      pnt4.style.backgroundColor = '#84DCC6'
      difficultyHeader.innerText = 'Nieznany'
      break
  }
});

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

function checkImgSize(event) {
  const file = event.target.files[0]
  let imgDataLocal = new FormData()
  imgDataLocal.append('image', file)
  console.warn('Size is ' + file.size)
  console.warn('Name is ' + file.name)
  if (file.size < 153600) {
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

function changeImgName(name) {
  let imgNameBlock = document.getElementById('img-name')
  imgNameBlock.innerText = name
}

async function handelImg() {
  const {
    data: imgUploadData,
    error: imgUploadError,
    pending: imgUploadPending
  } = await useFetch('http://localhost:8000/api/upload-section-img', {
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

async function editLessonSection() {
  console.log('EDIT SECTION')
  if (imgData && !await handelImg()) {
    createError(402)
  } else {
    if (imgData) {
      img.value = createImgPath(imgRealName)
    }
    title.value = capitalize(title.value)
    description.value = capitalize(description.value)
    const {
      data: sectionEditData,
      error: sectionEditError,
      pending: sectionEditPending
    } = await useFetch('http://localhost:8000/api/edit-lesson-section', {
          method: 'POST',
          body: {
            id: id.value,
            title: title.value,
            difficulty: difficulty.value,
            description: description.value,
            img: img.value
          },
        }
    )
    console.log('Title is ' + title.value)
    console.log('Difficulty is ' + difficulty.value)
    console.log('Description is ' + description.value)
    console.log('Img is ' + img.value)
    if (sectionEditData.value) {
      emit("refreshLessonSection")
      createError(100)
    }
    if (sectionEditError.value) {
      createError(500)
    }
  }
}

function createImgPath(name) {
  return '/_nuxt/assets/images/sections/' + name
}

function selectDifficulty(id) {
  let pnt1 = document.getElementById('pnt-1')
  let pnt2 = document.getElementById('pnt-2')
  let pnt3 = document.getElementById('pnt-3')
  let pnt4 = document.getElementById('pnt-4')
  let difficultyHeader = document.getElementById('difficulty-header')
  switch (id) {
    case 1:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#84DCC6'
      pnt3.style.backgroundColor = '#84DCC6'
      pnt4.style.backgroundColor = '#84DCC6'
      difficultyHeader.innerText = 'Podstawowy'
      difficulty.value = id
      break
    case 2:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#32A88A'
      pnt3.style.backgroundColor = '#84DCC6'
      pnt4.style.backgroundColor = '#84DCC6'
      difficultyHeader.innerText = 'Elementarny'
      difficulty.value = id
      break
    case 3:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#32A88A'
      pnt3.style.backgroundColor = '#32A88A'
      pnt4.style.backgroundColor = '#84DCC6'
      difficultyHeader.innerText = 'Średni'
      difficulty.value = id
      break
    case 4:
      pnt1.style.backgroundColor = '#32A88A'
      pnt2.style.backgroundColor = '#32A88A'
      pnt3.style.backgroundColor = '#32A88A'
      pnt4.style.backgroundColor = '#32A88A'
      difficultyHeader.innerText = 'Średni+'
      difficulty.value = id
      break
    default:
      console.warn('Undefined value (id) in selectDifficulty switch. Value (id) is ' + id)
      break
  }
}

function createError(errorCode) {
  const formError = document.getElementById('form-error-sections')
  switch (errorCode) {
    case 100:
      formError.style.visibility = 'visible'
      formError.style.color = 'green'
      formError.innerText = 'Sekcja zmieniona pomyślnie'
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
.section-edit-form {
//border: 1px solid red; width: 100%;
  height: 100%;
  padding-left: 2rem;
  margin-top: 1rem;
}

.section-edit-form .header {
  margin-left: 1rem;
  color: #727272;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.section-edit-form form {
  width: 50%;
//border: 1px solid purple;
}

.section-edit-form form .form-error-sections {
  margin-left: 1rem;
  color: #DE7C7C;
  margin-bottom: 1.5rem;
  transition: 0.25s ease;
}

.section-edit-form form label {
  color: #727272;
  padding-left: 1rem;
  font-size: 1rem;
}

.section-edit-form form input[type = text] {
  background-color: #D6EDFF;
  height: 3.5rem;
  border-radius: 0.5rem;
  margin-top: 0.5rem;
  margin-bottom: 2rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  color: #6d7bbc;
  font-size: 0.9rem;
}

.section-edit-form form input[type = text]:focus {
  border: 2px solid #8B95C9;
}

.section-edit-form form .difficulty-input {
//border: 1px solid green; margin-top: 1rem;
  height: auto;
  width: 100%;
  display: flex;
  align-items: center;
  margin-bottom: 2rem;
}

.section-edit-form form .difficulty-input .panel {
//border: 1px solid green; width: 30%;
  display: flex;
  justify-content: space-between;
}

.section-edit-form form .difficulty-input .panel .point {
//border: 1px solid red; height: 1.5rem;
  width: 1.5rem;
  border-radius: 50%;
  cursor: pointer;
  background-color: #84DCC6;
}

.section-edit-form form .difficulty-input .difficulty-header {
  color: #727272;
  margin-left: 1rem;
  font-size: 1rem;
}

.section-edit-form form textarea {
  background-color: #D6EDFF;
  margin-top: 0.5rem;
  margin-bottom: 2rem;
  resize: none;
  border-radius: 0.5rem;
  height: 8rem;
  padding: 1.5rem;
  overflow-y: auto;
  color: #6d7bbc;
  font-size: 0.9rem;
  line-height: 1.2rem;
}

.section-edit-form form textarea:focus {
  border: 2px solid #8B95C9;
}

.section-edit-form form input[type = file] {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.section-edit-form form .row-img {
  margin-bottom: 2rem;
  height: 4rem;
  display: flex;
  align-items: center;
}

.section-edit-form form .row-img .section-img {
  height: 3rem;
  width: 3rem;
  margin-right: 1rem;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.section-edit-form form .row-img .section-img img {
  height: 100%;
  width: 100%;
  border-radius: 50%;
}

.section-edit-form form .row-img .img-name {
//border: 1px solid red; height: 100%;
  margin-left: 1rem;
  display: flex;
  align-items: center;
  color: #727272;
}

.section-edit-form form .row-img .image-input {
  border-radius: 0.5rem;
  height: 80%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 1rem;
  padding-bottom: 1rem;
  cursor: pointer;
  padding-right: 1rem;
  background-color: #84DCC6;
  color: white;
  transition: 0.10s ease;
}

.section-edit-form form .row-img .image-input:hover {
  background-color: #3ecea8;
  transition: 0.10s ease;
}

.section-edit-form form button[type = submit] {
  border-radius: 0.5rem;
  margin-top: 1rem;
  padding-top: 1rem;
  padding-bottom: 1rem;
  background-color: #8B95C9;
  color: white;
  font-size: 1rem;
  width: 70%;
  transition: 0.25s ease;
}

.section-edit-form form button[type = submit]:hover {
  background-color: #6D7BBC;
  transition: 0.25s ease;
}

</style>