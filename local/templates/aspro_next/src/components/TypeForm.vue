<template>
  <div>
    <div class="type-form-list">
      <div class="type-form-item" v-for="(item, i) in items" :key="i" :class="{active : i === activeIndex}" @click="itemCheck(i)">
        <img :src="item.image" :alt="item.title">
        <span>{{ item.title }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TypeForm",
  data: () => ({
    items: [
      {image: require('../assets/formType/bludcza.jpg'), title: 'Блюдца'},
      {image: require('../assets/formType/bokal-brendy.jpg'), title: 'Бокалы для бренди'},
      {image: require('../assets/formType/bokal-dlya-vina.jpg'), title: 'Бокалы для вина'},
      {image: require('../assets/formType/bokal-dlya-shampanskogo.jpg'), title: 'Бокалы для шампанского'},
      {image: require('../assets/formType/rymki.jpg'), title: 'Рюмки'},
      {image: require('../assets/formType/vazy.jpg'), title: 'Вазы'},
      {image: require('../assets/formType/banki.jpg'), title: 'Банки'},
      {image: require('../assets/formType/grafiny-nabory.jpg'), title: 'Графины/Наборы'},
      {image: require('../assets/formType/kramanki.jpg'), title: 'Креманки/Мартини'},
      {image: require('../assets/formType/kruzhki.jpg'), title: 'Кружки/Чашки'},
      {image: require('../assets/formType/kuvhiny-nabory.jpg'), title: 'Кувшины/Наборы'},
      {image: require('../assets/formType/limonniczy.jpg'), title: 'Лимонницы/Пепельницы'},
      {image: require('../assets/formType/nabory-12.jpg'), title: 'Наборы 12 предметов'},
      {image: require('../assets/formType/nabory-s-barnoy-stoykoy.jpg'), title: 'Наборы с барной стойкой'},
      {image: require('../assets/formType/posuda-dlya-piva.jpg'), title: 'Посуда для пива'},
      {image: require('../assets/formType/salatniky.jpg'), title: 'Салатники'},
      {image: require('../assets/formType/stakany-dlya-wisky.jpg'), title: 'Стаканы для виски'},
      {image: require('../assets/formType/stakany-dlya-kokteylya.jpg'), title: 'Стаканы для коктейля'},
      {image: require('../assets/formType/stakany-dlya-chaya.jpg'), title: 'Стаканы для чая'},
      {image: require('../assets/formType/stopki.jpg'), title: 'Стопки'},
      {image: require('../assets/formType/chaynie-nabory.jpg'), title: 'Чайные наборы с блюдцем'}
    ],
    onCheck: false,
    activeIndex: ''
  }),
  methods: {
    itemCheck(indexItem) {
      if (this.activeIndex === indexItem) {
        this.activeIndex = '';
        this.onCheck = false;
      } else {
        this.activeIndex = indexItem;
        this.onCheck = true;
      }
      this.$emit('checkActiveItem', this.onCheck);
    }
  }
}
</script>

<style scoped>
.type-form-list {
  display: flex;
  max-height: 400px;
  flex-wrap: wrap;
  overflow-y: scroll;
}

.type-form-item {
  width: 150px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 20px 0;
  border: 2px solid #fff0;
  border-radius: 20px;
  transition: 400ms;
  cursor: pointer;
}

.type-form-item.active {
  border: 2px solid #172B77;
  transition: 400ms;
}

.type-form-item img {
  max-width: 80px;
}

.type-form-item span {
  max-width: 80%;
}
</style>