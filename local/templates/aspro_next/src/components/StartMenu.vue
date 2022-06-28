<template>
  <div class="conf-content">
    <div class="conf-title">
      С чего начнем?
    </div>

    <div class="slide-start">

      <div class="start-item" v-for="(item, i) in items" :key="i" :class="{active : i === activeIndex}"
           @click="itemCheck(i)">
        <img :src="item.image" :alt="item.title">
        <span>{{ item.title }}</span>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "StartMenu",
  data: () => ({
    items: [
      {image: require('../assets/start/start-tech.jpg'), title: 'Технология', name: 'Technology', id: 0},
      {image: require('../assets/start/start-form.jpg'), title: 'Вид формы', name: 'FormType', id: 1},
      {image: require('./../assets/start/start-pack.jpg'), title: 'Упаковка', name: 'Package', id: 2}
    ],
    activeIndex: '',
    techList: {
      components: [
        'StartMenu',
        'TechList',
        'TypeForm',
        'FormList',
        'PatternList',
        'PackingList',
        'OrderForm'
      ],
      name: [
        'Начало',
        'Технология',
        'Тип формы',
        'Форма',
        'Узор',
        'Упаковка',
      ]
    },
    formList: {
      components: [
        'StartMenu',
        'TypeForm',
        'FormList',
        'TechList',
        'PatternList',
        'PackingList',
        'OrderForm'
      ],
      name: [
        'Начало',
        'Тип формы',
        'Форма',
        'Технология',
        'Узор',
        'Упаковка',
      ]
    },
    packingList: {
      components: [
        'StartMenu',
        'PackingList',
        'TypeForm',
        'FormList',
        'TechList',
        'PatternList',
        'OrderForm'
      ],
      name: [
        'Начало',
        'Упаковка',
        'Тип формы',
        'Форма',
        'Технология',
        'Узор'
      ]
    },
    allInfo: {
      onCheck: false,
      selectComponentList: [],
      topMenu: [],
    },
  }),
  methods: {
    itemCheck(indexItem) {
      //Проверяем, выбран ли элемент и активируем кнопку Вперед
      if (this.activeIndex === indexItem) {
        this.activeIndex = '';
        this.allInfo.onCheck = false;
      } else {
        this.activeIndex = indexItem;
        this.allInfo.onCheck = true;
      }
      //Проверяем, какая начальная точка и в зависимости от этого, передаем список компонентов в переменную
      switch (this.items[indexItem].name) {
        case 'Technology':
          this.allInfo.selectComponentList = this.techList;
          break
        case 'FormType':
          this.allInfo.selectComponentList = this.formList;
          break
        case 'Package':
          this.allInfo.selectComponentList = this.packingList;
          break
      }
      //Передаем наверх состояние кнопки и список компонентов
      this.$emit('getAllInfo', this.allInfo);
    }
  }
}

</script>

<style scoped>

.slide-start {
  display: flex;
  justify-content: space-around;
  align-items: center;
  width: 100%;
  height: 100%;
  margin: 0 auto;
}

.start-item {
  display: flex;
  position: relative;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 250px;
  height: 250px;
  border: 2px solid #fff0;
  box-sizing: border-box;
  border-radius: 6px;
  cursor: pointer;
}

.start-item:hover {
  border: 2px solid #D9D9D9;
}

.start-item.active {
  border: 2px solid #D9D9D9;
}

.start-item img {
  max-width: 200px;
  max-height: 150px;
}

.start-item span {
  position: absolute;
  bottom: 5px;
  font-weight: 400;
  font-size: 18px;
  line-height: 25px;
  text-align: center;
}

</style>
