<template>
  <div class="add-lesson-section-form">
    <form id="add-lesson-section-data" @submit.prevent="addLessonSection()">
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
      <button type="submit">Dodaj sekcję</button>
    </form>
  </div>
</template>

<script setup lang="js">

let title = ref('')
let difficulty = ref('1')
let description = ref('')
let img = ref('')
let imgData
let imgName = ref('')
let imgRealName

let props = defineProps({
  refreshSections: {
    type: Function
  }
})

onMounted(async () => {
  let difficultyHeader = document.getElementById('difficulty-header')
  let point1 = document.getElementById('pnt-1')

  difficultyHeader.innerText = 'Podstawowy'
  point1.style.backgroundColor = '#32A88A'
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
  } = await useFetch('http://localhost:8000/api/upload-img', {
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

async function addLessonSection() {
  if (!await handelImg()) {
    createError(402)
  } else {
    img.value = createImgPath(imgRealName)
    title.value = capitalize(title.value)
    description.value = capitalize(description.value)
    const {
      data: sectionAddData,
      error: sectionAddError,
      pending: sectionAddPending
    } = await useFetch('http://localhost:8000/api/add-lesson-section', {
          method: 'POST',
          body: {
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
    if (sectionAddData.value) {
      let addLessonSectionForm = document.getElementById('add-lesson-section-form')
      addLessonSectionForm.reset
      props.refreshSections()
      createError(100)
    }
    if (sectionAddError.value) {
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
      formError.innerText = 'Sekcja dodana pomyślnie'
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
.add-lesson-section-form {
//border: 1px solid red; width: 100%; height: 100%;
  padding-left: 3rem;
}

.add-lesson-section-form form {
  width: 70%;
//border: 1px solid purple; margin-top: 4rem;
}

.add-lesson-section-form form .form-error-sections {
  margin-left: 1rem;
  color: #DE7C7C;
  margin-bottom: 1.5rem;
  transition: 0.25s ease;
}

.add-lesson-section-form form label {
  color: #727272;
  padding-left: 1rem;
}

.add-lesson-section-form form input[type = text] {
  background-color: #D6EDFF;
  height: 3.5rem;
  border-radius: 1rem;
  margin-top: 0.5rem;
  margin-bottom: 2rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  color: #6d7bbc;
  font-size: 0.9rem;
}

.add-lesson-section-form form input[type = text]:focus {
  border: 2px solid #8B95C9;
}

.add-lesson-section-form form .difficulty-input {
//border: 1px solid green; margin-top: 1rem; height: auto;
  width: 100%;
  display: flex;
  align-items: center;
  margin-bottom: 2rem;
}

.add-lesson-section-form form .difficulty-input .panel {
  width: 38%;
  display: flex;
  justify-content: space-between;
}

.add-lesson-section-form form .difficulty-input .panel .point {
//border: 1px solid red; height: 2.5rem; width: 2.5rem;
  border-radius: 50%;
  cursor: pointer;
  background-color: #84DCC6;
}

.add-lesson-section-form form .difficulty-input .difficulty-header {
  color: #727272;
  margin-left: 2rem;
  font-size: 1.2rem;
}

.add-lesson-section-form form textarea {
  background-color: #D6EDFF;
  margin-top: 0.5rem;
  margin-bottom: 1rem;
  resize: none;
  border-radius: 1rem;
  height: 15rem;
  padding: 1.5rem;
  overflow-y: auto;
  color: #6d7bbc;
  font-size: 0.9rem;
}

.add-lesson-section-form form textarea:focus {
  border: 2px solid #8B95C9;
}

.add-lesson-section-form form input[type = file] {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.add-lesson-section-form form .row-img {
//border: 1px solid red; height: 4rem; display: flex;
  align-items: center;
}

.add-lesson-section-form form .row-img .img-name {
//border: 1px solid red; height: 100%; margin-left: 1rem;
  display: flex;
  align-items: center;
  color: #727272;

}

.add-lesson-section-form form .row-img .image-input {
  border-radius: 0.5rem;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 1rem;
  padding-bottom: 1rem;
  cursor: pointer;
  padding-right: 1rem;
  background-color: #84DCC6;
  color: white;
  transition: 0.25s ease;
}

.add-lesson-section-form form .row-img .image-input:hover {
  background-color: #32A88A;
  transition: 0.25s ease;
}

.add-lesson-section-form form button[type = submit] {
  border-radius: 0.5rem;
  margin-top: 3rem;
  padding-top: 2rem;
  padding-bottom: 2rem;
  background-color: #8B95C9;
  color: white;
  font-size: 1.2rem;
  width: 100%;
  transition: 0.25s ease;
}

.add-lesson-section-form form button[type = submit]:hover {
  background-color: #6D7BBC;
  transition: 0.25s ease;
}

</style>