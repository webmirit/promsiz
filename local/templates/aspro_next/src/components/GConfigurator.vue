<template>
  <div class="VisualFilterApp" :class="[formColor[step]]" id="app">
    <div class="conf-header">
      Конфигуратор продукции ООО “Промсиз”
    </div>
    <div class="conf-body">
      <div class="preloader-box" v-if="preloader">
        <div class="preloader"></div>
      </div>
      <HeaderNav
          :topMenu="componentList.name"
          :step="step"
          @getNavIndex="getNavIndex"
          v-if="currentComponent !== 'OrderForm'"
      />
      <component
        :is="currentComponent"
        :step="step"
        :categories="getSortCategory"
        :formList="forms"
        :allFormList="formList"
        :techList="techList"
        :techs="techs.data"
        :patternsList="patternsList.data"
        :packTypeList="packTypeList"
        :packList="packList"
        :sets="sets.data"
        :sortTech="step !== 1 && currentComponent === 'TechList'"
        :loadStatus="loadStatus"
        :allSelected="allSelected"
        :cart="cart"
        :chooseSetsNumber="chooseSetsNumber"
        :startPoint="startPoint"
        :formByPack="formByPack.data"
        :checkSets="checkSets"
        :dataBySets="dataBySets"
        @activeSets="activeSets"
        @chooseSetsNum="chooseSetsNum"
        @getAllInfo="onGetAllInfo"
        @getOrderInfo="getOrderInfo"
        @getStep="getStep"
        @clearId="clearId"
        @clearInfo="clearInfo"
        @changeQuantity="changeQuantity"
        @dropProduct="dropProduct"
        @clearCart="clearCart"
        @getCategoryByPack="getCategoryByPack"
        @getCategoriesWithSets="getCategoriesWithSets"
      ></component>
      <div class="conf-nav-button" v-if="currentComponent !== 'OrderForm'">
        <span class="conf-btn" @click="prevStep()" v-if="step > 0">Назад</span>
        <span class="conf-btn" @click="nextStep()" v-if="btnNext"
              :class="{disabled : !buttonStatus}">Вперед</span>
        <span class="conf-btn" v-if="activeSetsBtn" @click="chooseSets()">Подобрать сет</span>
        <span class="conf-btn" v-if="btnCheckout" @click="addProduct()" :class="{disabled : currentComponent==='SetsList' && !buttonStatus}">Добавить в корзину</span>
      </div>
    </div>

    <div class="conf-order" :class="{active : orderInfo.category !== '' }" v-if="currentComponent !== 'OrderForm'">
      <span class="footer-title" v-if="orderInfo.category !== ''">
          Формируем заказ:
      </span>
      <ul class="product-ul" v-if="orderInfo.category !== ''">
        <li v-if="orderInfo.category">
          <span>Тип формы:</span>{{ orderInfo.category }}
        </li>
        <li v-if="orderInfo.name">
          <span>Форма:</span>{{ orderInfo.name }}
        </li>
        <li v-if="orderInfo.technology">
          <span>Технология:</span>{{ orderInfo.technology }}
        </li>
        <li v-if="orderInfo.pattern.length !== 0">
          <span>Узор:</span>
          <span v-for="(item, i) in orderInfo.pattern" :key="item.id">
            {{ item.name }} <span v-if="i + 1 !== orderInfo.pattern.length">, </span>
          </span>
        </li>
        <li v-if="orderInfo.package">
          <span>Упаковка:</span>{{ orderInfo.package }}
        </li>
      </ul>
    </div>
    <div class="conf-cart" v-if="currentComponent !== 'OrderForm' && cart.length > 0">
      <span class="footer-title">
          Ваша корзина:
      </span>
      <ul class="product-ul">
        <li v-for="(item, i) in cart" :key="item.id">
          <span>{{ i + 1 }}.</span>{{ item.category }} / Форма: {{ item.name }} / Узор: {{ item.pattern }} /
          {{ item.package }}
        </li>
      </ul>
      <span @click="goToCart" class="goToCart"><b>Перейти в корзину</b></span>
    </div>
  </div>
</template>

<script>

import StartMenu from './StartMenu.vue';
import TypeForm from "./TypeForm.vue";
import FormList from "./FormList";
import HeaderNav from "./HeaderNav";
import TechList from "./TechList";
import PatternList from "./PatternList";
import OrderForm from "./OrderForm";
import SetsList from "./SetsList";

export default {
  name: 'GConfigurator',
  components: {
    TypeForm,
    StartMenu,
    FormList,
    HeaderNav,
    TechList,
    PatternList,
    OrderForm,
    SetsList,
  },
  inject: ['apiClient'],
  props: {
    counterNav: {
      type: Number
    },
    categories: {
      type: Array,
    },
    techList: {
      type: Array,
    },
    formList: {
      type: Array,
    },
    packTypeList: {
      type: Array,
      default: () => [],
    },
    packList: {
      type: Array,
      default: () => [],
    }
  },
  data: () => ({
    startPoint: '',
    categoryByPack: Array,
    dataBySets: [],
    categoryBySets: [],
    formListBySets: [],
    step: 0,
    sortCategory: false,
    sortTech: false,
    preloader: false,
    loadStatus: false,
    activeComponentIndex: 0,
    NavIndex: 0,
    buttonStatus: false,
    selectList: 0,
    formColor: [
      't-color-one',
      't-color-two',
      't-color-three',
      't-color-four',
      't-color-five',
      't-color-six',
      't-color-seven',
      't-color-eight'
    ],
    forms: [],
    formByPack: [],
    techs: [],
    patternsList: [],
    sets: [],
    componentList: {
      components: [
        'StartMenu',
      ],
      name: [
        'Начало',
      ]
    },
    allSelected: {
      category: [],
      formId: [],
      techId: [],
      patternId: [],
    },
    orderInfo: {
      id: '',
      category: '',
      name: '',
      technology: '',
      pattern: [],
      package: '',
      packVolume: null,
      packWeight: null,
      packageType: null,
      packageNum: null,
      setsForm2: null,
      setsForm3: null,
    },
    cart: [],
    checkSets: false,
    chooseSetsNumber: null,
  }),
  methods: {
    getStep(step) {
      this.step = step;
    },
    //Кнопка вперед
    nextStep() {
      if (this.buttonStatus) {
        this.step++;
        this.buttonStatus = false;
        this.setActiveComponentIndex();
        if (this.step === 1) {
          this.startPoint = this.componentList.components[1];
        }
        if (this.currentComponent === 'FormList') {
          this.getCategory();
        }
        if (this.currentComponent === 'TechList' && this.step !== 1) {
          this.getTech();
        }
        if (this.currentComponent === 'PatternList') {
          this.getPattern();
        }
        if (this.currentComponent === 'PackingList' && this.step !== 1) {
          this.getSets();
        }
        if (this.currentComponent === 'PatternList' && this.startPoint === 'PackingList') {
          this.getSets();
        }
      }
    },
    //Кнопка назад
    prevStep() {
      this.clearId();
      if (this.currentComponent === 'PackingList') {
        this.checkSets = false;
      }
      if (this.currentComponent === 'SetsList') {
        let position = this.componentList.components.length - 2;
        this.componentList.components.splice(position, 1);
        this.componentList.name.splice(position, 1);
        this.checkSets = false;
      }

      if (this.startPoint === 'PackingList' && this.currentComponent === 'TechList') {
        this.getCategory()
      }
      this.step--;
      this.setActiveComponentIndex();
      this.clearId();
      this.buttonStatus = false;
    },
    //Получает и проверяет данные из компонентов
    onGetAllInfo(value) {
      this.buttonStatus = value.onCheck;
      if (typeof value.selectComponentList !== "undefined") {
        this.componentList = {};
        this.componentList = value.selectComponentList;
      }
      if (typeof value.formId !== "undefined") {
        this.allSelected.formId = value.formId;
      }
      if (typeof value.category !== "undefined") {
        this.allSelected.category = value.category;
      }
      if (typeof value.formId !== "undefined") {
        this.allSelected.formId = value.formId;
      }
      if (typeof value.techId !== "undefined") {
        this.allSelected.techId = value.techId;
      }
      if (typeof value.patternList !== "undefined") {
        this.allSelected.patternId = value.patternList;
      }
    },
    //Получает и проверяет данные из компонентов для формирования заказа
    getOrderInfo(value) {
      if (typeof value.formType !== "undefined") {
        this.orderInfo.category = value.formType;
      }
      if (typeof value.formName !== "undefined") {
        this.orderInfo.name = value.formName;
      }
      if (typeof value.techName !== "undefined") {
        this.orderInfo.technology = value.techName;
      }
      if (typeof value.patternsName !== "undefined") {
        this.orderInfo.pattern = value.patternsName;
      }
      if (typeof value.package !== "undefined") {
        this.orderInfo.package = value.package;
      }
      if (typeof value.packVolume !== "undefined") {
        this.orderInfo.packVolume = value.packVolume;
      }
      if (typeof value.packWeight !== "undefined") {
        this.orderInfo.packWeight = value.packWeight;
      }
      if (typeof value.packageType !== "undefined") {
        this.orderInfo.packageType = value.packageType;
      }
      if (typeof value.packageNum !== "undefined") {
        this.orderInfo.packageNum = value.packageNum;
      }
      if (typeof value.setsForm2 !== "undefined") {
        this.orderInfo.setsForm2 = value.setsForm2;
      }
      if (typeof value.setsForm3 !== "undefined") {
        this.orderInfo.setsForm3 = value.setsForm3;
      }
      if (typeof value.userName !== "undefined") {
        this.orderInfo.userName = value.userName;
      }
      if (typeof value.userPhone !== "undefined") {
        this.orderInfo.userPhone = value.userPhone;
      }
    },
    getNavIndex(value) {
      // if (value <= this.step) this.step = value;
      this.step = value;
      this.setActiveComponentIndex();
      this.clearId();
    },
    setActiveComponentIndex() {
      this.activeComponentIndex = this.componentList.components.indexOf(this.currentComponent);
    },
    clearId() {
      if (this.currentComponent === 'TypeForm') {
        this.orderInfo.category = '';
      }
      if (this.currentComponent === 'FormList') {
        this.allSelected.formId = [];
        this.orderInfo.name = '';
      }
      if (this.currentComponent === 'TechList') {
        this.allSelected.techId = [];
        this.orderInfo.technology = '';
      }
      if (this.currentComponent === 'PatternList') {
        this.allSelected.patternId = [];
        this.orderInfo.pattern = [];
      }
      if (this.currentComponent === 'StartMenu') {
        this.allSelected.formId = [];
        this.allSelected.category = [];
        this.allSelected.techId = [];
        this.allSelected.patternId = [];
        this.sortCategory = false;
        this.sortTech = false;
      }
    },
    //Очищаем выбранные товары
    clearInfo(value) {
      if (value) {
        this.allSelected.patternId = [];
        this.allSelected.techId = [];
        this.allSelected.formId = [];
        this.allSelected.category = [];
        this.orderInfo.pattern = [];
        this.orderInfo.category = '';
        this.orderInfo.name = '';
        this.orderInfo.technology = '';
        this.orderInfo.package = '';
        this.orderInfo.packVolume = '';
        this.orderInfo.packWeight = '';
      }
    },
    //Изменяем количество товара в заказе
    changeQuantity(data) {
      if (data.add) {
        this.cart.forEach((item, i) => {
          if (item.id === data.id) {
            this.cart[i].quantity += 1;
          }
        })
      } else {
        this.cart.forEach((item, i) => {
          if (item.id === data.id && this.cart[i].quantity > 1) {
            this.cart[i].quantity -= 1;
          }
        })
      }
    },
    //Добавляем товар в заказ
    addProduct() {
      if (this.currentComponent !== 'SetsList') {
        this.orderInfo.pattern.forEach((item) => {
          this.cart.push({...this.orderInfo, pattern: item.name, id: item.id, picture: item.picture, quantity: 1});
        })
        this.step++;
      } else {
        if (this.buttonStatus) {
          this.orderInfo.pattern.forEach((item) => {
            this.cart.push({...this.orderInfo, pattern: item.name, id: item.id, picture: item.picture, quantity: 1});
          })
          this.step++;
        }
      }
    },
    //Удаляем товар в заказе
    dropProduct(id) {
      this.cart.forEach((item, i) => {
        if (item.id === id) {
          this.cart.splice(i, 1);
        }
      })
    },
    //Очистка корзины
    clearCart(value) {
      if (value) {
        this.cart = [];
      }
    },
    //Когда выбирают сеты в упаковке
    activeSets(value) {
      this.checkSets = value;
    },
    chooseSets() {
      let position = this.componentList.components.length - 1;
      this.componentList.components.splice(position, 0, 'SetsList');
      this.componentList.name.splice(position, 0, 'Сеты');
      this.checkSets = false;
      this.step++;
    },
    chooseSetsNum(value) {
      this.chooseSetsNumber = value;
    },
    //Для перехода в корзину
    goToCart() {
      this.step = this.componentList.components.length - 1;
    },
    //Получаем категории, когда начинаем с упаковки
    getCategoryByPack(data) {
      if (this.startPoint === 'PackingList') {
        this.getCategoriesByPackSection({...data});
        this.sortCategory = true;
      }
    },
    sortCategoryBySets(){
      const stockData = this.dataBySets.data;
      this.categoryBySets = [];
      stockData.data.sections.forEach(item => {
        this.categoryBySets.push(...this.categories.filter((data) => data.id === item));
      });
      return this.categoryBySets;
    },
    //Запросы к базе
    async getCategory() {
      this.loadStatus = false;
      this.preloader = true;
      this.forms = [...await this.apiClient.getGladyeByCategory(this.allSelected.category)];
      if (this.startPoint === 'PackingList' && !this.checkSets) {
        let arr = await this.apiClient.getFormByProductSectionAndPack({productSectionId: this.allSelected.category, packSection: this.orderInfo.packageType, packCount: this.orderInfo.packageNum});
        this.formByPack = arr.data;
      }
      this.loadStatus = true;
      this.preloader = false;
    },
    async getTech() {
      this.loadStatus = false;
      this.preloader = true;
      this.techs = await this.apiClient.getProduct({...this.allSelected});
      this.loadStatus = true;
      this.preloader = false;
    },
    async getPattern() {
      this.loadStatus = false;
      this.preloader = true;
      this.patternsList = await this.apiClient.getProduct({...this.allSelected});
      this.loadStatus = true;
      this.preloader = false;
    },
    async getSets() {
      this.loadStatus = false;
      this.preloader = true;
      this.sets = await this.apiClient.getSets({formId: this.allSelected.formId});
      this.loadStatus = true;
      this.preloader = false;
    },
    async getCategoriesByPackSection(data) {
      this.categoryByPack = await this.apiClient.getCategoriesByPackSection(data);
    },
    async getCategoriesWithSets(data) {
      this.dataBySets = await this.apiClient.getCategoriesWithSets(data);
    }
  },
  computed: {
    getSortCategory() {
      if (this.startPoint === 'PackingList' && this.checkSets) {
        return this.sortCategoryBySets()
      }
      if (this.sortCategory) {
        let obj = {...this.categoryByPack['data']}
        return obj.data;
      } else {
        return this.categories;
      }
    },
    currentComponent() {
      return this.componentList.components[this.step];
    },
    btnNext() {
      if (this.step === this.componentList.components.length - 2) {
        return false;
      }
      if (this.startPoint === 'TypeForm' && this.step === this.componentList.components.length - 2) {
        return false;
      }
      return true;

    },
    btnCheckout() {
      if (this.currentComponent === 'SetsList') {
        return true;
      }
      if(this.currentComponent === 'PackingList' && !this.checkSets && this.startPoint !== 'PackingList') {
        return true;
      }
      if (this.currentComponent === 'PatternList' && this.startPoint === 'PackingList' && !this.checkSets) {
        return true;
      }
      return false;

    },
    activeSetsBtn() {
      if (this.startPoint !== 'PackingList' && this.checkSets) {
        return true;
      }
      if (this.startPoint === 'PackingList' && this.checkSets && this.currentComponent === 'PatternList') {
        return true;
      }
      return false;
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
/*Новые стили*/
:root {
  --color-one: #A284AF;
  --color-two: #8B81D8;
  --color-three: #5CB5E2;
  --color-four: #82BB26;
  --color-five: #FFCC00;
  --color-six: #F49800;
  --color-seven: #E6330E;
  --color-eight: #E6330E;
}

.VisualFilterApp {
  background-color: #fff;
  width: 1250px;
  margin: 0 auto;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/*template fix*/
.VisualFilterApp ul li::before {
  display: none;
}

.VisualFilterApp ol li, .VisualFilterApp ul li {
  padding-left: 0 !important;
}

.left_block {
  display: none;
}

.right_block.wide_ {
  width: 100% !important;
}

#headerfixed.fixed {
  display: none !important;
}

/*template fix*/
/*Buttons*/
.conf-btn {
  padding: 6px 45px;
  background: #FFFFFF;
  border: 3px solid;
  box-sizing: border-box;
  border-radius: 6px;
  font-weight: 400;
  font-size: 16px;
  line-height: 22px;
  text-align: center;
  color: #434242;
  cursor: pointer;
  margin: 0 15px;
  transition: 400ms;
}

.conf-btn:hover {
  color: #fff;
  transition: 400ms;
}

/*Buttons*/
.conf-header {
  padding: 20px 0 10px 50px;
  font-style: normal;
  font-weight: 300;
  font-size: 28px;
  line-height: 38px;
  border-bottom: 4px solid rgba(234, 234, 234, 0.75);
}

.conf-body {
  height: 550px;
  padding: 0 50px;
  position: relative;
}

.conf-title {
  width: max-content;
  height: 40px;
  display: flex;
  align-items: flex-end;
  font-weight: 400;
  font-size: 20px;
  line-height: 27px;
  border-bottom: 3px solid;
  box-sizing: border-box;
}

.conf-content {
  width: 1150px;
  height: 410px;
}

.conf-nav-button {
  height: 65px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.conf-order {
  position: relative;
  padding: 15px 120px;
  font-weight: 300;
  font-size: 20px;
  line-height: 33px;
}

.product-ul {
  margin: 20px;
}

.conf-order.active {
  margin: 15px 0 30px 0;
}

.conf-order:before {
  content: "";
  position: absolute;
  width: 1150px;
  height: 4px;
  background: linear-gradient(to right, #A284AF, #8B81D8, #5CB5E2, #AFD374, #FFDE5C, #F5AE5C, #EF7C65);;
  top: 0;
  left: 50%;
  transform: translate(-50%, -50%);
}

.conf-order.active:after {
  content: "";
  position: absolute;
  width: 1150px;
  height: 4px;
  background: linear-gradient(to right, #A284AF, #8B81D8, #5CB5E2, #AFD374, #FFDE5C, #F5AE5C, #EF7C65);;
  bottom: 0;
  left: 50%;
  transform: translate(-50%, -50%);
}

.conf-cart {
  padding: 15px 120px;
  background: #F3F3F3;
  font-weight: 300;
  font-size: 20px;
  line-height: 33px;
}

.footer-title {
  font-weight: 400;
  font-size: 24px;
}

.product-ul li {
  list-style-type: none;
}

.product-ul li span:first-child {
  margin-right: 5px;
  font-weight: 400;
}

.goToCart {
  cursor: pointer;
}

/*Цвета*/
.t-color-one .conf-title, .t-color-one .conf-btn {
  border-color: var(--color-one);
}

.t-color-two .conf-title, .t-color-two .conf-btn {
  border-color: var(--color-two);
}

.t-color-three .conf-title, .t-color-three .conf-btn {
  border-color: var(--color-three);
}

.t-color-four .conf-title, .t-color-four .conf-btn {
  border-color: var(--color-four);
}

.t-color-five .conf-title, .t-color-five .conf-btn {
  border-color: var(--color-five);
}

.t-color-six .conf-title, .t-color-six .conf-btn {
  border-color: var(--color-six);
}

.t-color-seven .conf-title, .t-color-seven .conf-btn {
  border-color: var(--color-seven);
}

.t-color-eight .conf-title, .t-color-eight .conf-btn {
  border-color: var(--color-eight);
}

.t-color-one .conf-btn:hover {
  background: var(--color-one);
}

.t-color-two .conf-btn:hover {
  background: var(--color-two);
}

.t-color-three .conf-btn:hover {
  background: var(--color-three);
}

.t-color-four .conf-btn:hover {
  background: var(--color-four);
}

.t-color-five .conf-btn:hover {
  background: var(--color-five);
}

.t-color-six .conf-btn:hover {
  background: var(--color-six);
}

.t-color-seven .conf-btn:hover {
  background: var(--color-seven);
}

.t-color-eight .conf-btn:hover {
  background: var(--color-eight);
}

.preloader-box {
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  top: 0;
  left: 0;
  width: 100%;
  height: 550px;
  background-color: #fff;
  z-index: 9999;
}

.preloader {
  color: #172c78;
  font-size: 90px;
  text-indent: -9999em;
  overflow: hidden;
  width: 1em;
  height: 1em;
  border-radius: 50%;
  margin: 72px auto;
  position: relative;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load6 1.7s infinite ease;
  animation: load6 1.7s infinite ease;
}

@-webkit-keyframes load6 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  5%,
  95% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  10%,
  59% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em, -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
  }
  20% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em, -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em, -0.749em -0.34em 0 -0.477em;
  }
  38% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em, -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em, -0.82em -0.09em 0 -0.477em;
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
}

@keyframes load6 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  5%,
  95% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  10%,
  59% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em, -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
  }
  20% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em, -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em, -0.749em -0.34em 0 -0.477em;
  }
  38% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em, -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em, -0.82em -0.09em 0 -0.477em;
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
}

.t-color-one .preloader {
  color: var(--color-one);
}

.t-color-two .preloader {
  color: var(--color-two);
}

.t-color-three .preloader {
  color: var(--color-three);
}

.t-color-four .preloader {
  color: var(--color-four);
}

.t-color-five .preloader {
  color: var(--color-five);
}

.t-color-six .preloader {
  color: var(--color-six);
}

.t-color-seven .preloader {
  color: var(--color-seven);
}

.t-color-eight .preloader {
  color: var(--color-eight);
}

</style>
