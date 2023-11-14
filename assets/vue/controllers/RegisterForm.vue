

<template>
  <div class="root">
    <div class="form">
      <div class="clm1">
        <div class="inner">

          <p class = "header">Rejestracja</p>





          <form @submit.prevent="submitForm">
            <input v-model="email" type="email" placeholder="Email" required>
            <input v-model="password" type="password" placeholder="Password" required>
            <button type="submit">Zarejestruj się</button>
          </form>



        </div>
      </div>
      <div class="clm2">
        <div class="inner">
          <a href="/sign_in">Zaloguj się </a>

        </div>
      </div>
    </div>

  </div>
</template>
<script >
import axios from 'axios';
import {createRouter} from "vue-router";



export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    submitForm() {
      const formData = {
        email: this.email,
        password: this.password,
      };
      console.log(formData.email)
      console.log(this.$router)


      axios.post('/register', formData)
          .then(response => {
            // Обработка успешного ответа
            console.log(response.data);
            this.$router.push('/');
          })
          .catch(error => {
            // Обработка ошибки
            console.error(error);
          });
    },
  },
};
</script>

<style scoped>
.root{
  width: 100%;
  height: auto;
  display: flex;
  justify-content: center;
  margin-top: 150px;
}
.form{
//border: 1px solid red;
  width: 900px;
  height: 600px;
  display: flex;
  border-radius: 20px;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
}
.form .clm2{
//border: 1px solid red;
  width: 45%;
  height: 100%;
  background-color: #6aa876;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;

}
.form .clm2 .inner{
  //border: 1px solid black;
  width: 90%;
  height: 90%;
  display: flex;
  padding-top: 3em;
  flex-direction: column;
  align-items: center;

}
.form .clm1{
//border: 1px solid red;
  width: 55%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.form .clm1 .inner{
//border: 1px solid black;
  width: 90%;
  height: 90%;
  display: flex;
  padding-top: 3em;
  flex-direction: column;
  align-items: center;

}
.form .clm1 .inner .header{
  font-size: 30px;
  color: #6aa876;
  margin-bottom: 40px;
}
.form .clm1 .inner form{
  display: flex;
  flex-direction: column;
  width: 80%;
}
.form .clm1 .inner a{
  color: #62946c;
  margin-top: 30px;

}

.form .clm1 input{
  border: none;
  background-color: #efefef;
  height: 50px;
  margin-bottom: 30px;
  color: #70A179;
  font-size: 17px;

}
.form .clm1 input:focus-visible{
  border: none;
  background-color: #e3e3e3;

}

.form .clm1 button{
  margin-top: 30px;
  height: 50px;
  background-color: #6aa876;
  font-size: 18px;
}

</style>