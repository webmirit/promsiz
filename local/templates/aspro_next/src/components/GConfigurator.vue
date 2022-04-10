<template>
  <div class="VisualFilterApp" id="app">
    <div class="header">
      <div class="header-title">
        Конфигуратор продукции ООО “Промсиз”
      </div>
      <div class="header-nav">
        <div class="header-nav">
          <ul>
            <li :class="{active: counter === 0}">Начало</li>
            <li :class="{active: counter === 1}">Тип формы</li>
            <li :class="{active: counter === 2}">Форма</li>
            <li :class="{active: counter === 3}">Технология</li>
            <li :class="{active: counter === 4}">Узор</li>
            <li :class="{active: counter === 5}">Упаковка</li>
          </ul>
        </div>
      </div>
    </div>

    <StartMenu v-if="counter === 0" @checkActiveItem="activeNextButton"/>
    <TypeForm v-if="counter === 1" @checkActiveItem="activeNextButton"/>
    <FormList v-if="counter === 2"/>
    <div class="nav">
      <span class="btn" @click="counter--" v-if="counter > 0">Назад</span>
      <span class="btn" @click="nextStep()" v-if="counter < 5" :class="{disabled : !checkStart}">Вперед</span>
      <span class="btn" v-if="counter === 5">Оформить</span>
    </div>
  </div>
</template>

<script>

import StartMenu from './StartMenu.vue';
import TypeForm from "./TypeForm.vue";
import FormList from "./FormList";

export default {
  name: 'GConfigurator',
  components: {
    TypeForm,
    StartMenu,
    FormList
  },
  data: () => ({
    counter: 0,
    checkStart: false,
  }),
  methods: {
    activeNextButton(value) {
      this.checkStart = value;
    },
    nextStep(){
      console.log(this.checkStart);
      if (this.checkStart) this.counter++;
      this.checkStart = false;
    }
  }
}
</script>

<style>
#app {
  /*font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;*/
}

@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');


body {
  padding: 0;
  margin: 0;
  background-color: azure;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  font-family: 'Roboto', sans-serif;
}

.VisualFilterApp {
  margin: 50px 0;
}

.VisualFilterApp {
  width: 1000px;
  height: 600px;
  background-color: #fff;
  padding: 20px 25px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.btn {
  background-color: #172B77;
  color: #fff;
  padding: 5px 20px;
  transition: 400ms;
  cursor: pointer;
}

.btn:hover {
  background-color: #0e1a49;
  transition: 400ms;
}

.btn.disabled {
  background-color: #2a2b2f;
  transition: 400ms;
  cursor: default;
}

.header {
  background-color: #172B77;
}

.header-title {
  color: #ffffff;
  font-size: 18px;
  text-align: center;
  padding: 8px 0;
}

.header-nav {
  background-color: #C4C4C4;
}

.header-nav ul {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
}

.header-nav li {
  list-style-type: none;
  padding: 5px 15px;
}

.header-nav li.active {
  background-color: #172B77;
  color: #fff;
}


.nav {
  display: flex;
  justify-content: end;
}

.nav span {
  margin: 0 10px;
}

.nav span:last-child {
  margin-right: 0px;
}


</style>
