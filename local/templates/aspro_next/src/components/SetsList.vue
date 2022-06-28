<template>
  <div class="conf-content">
    <div class="conf-title">
      Выберите сет
    </div>
    <div class="slide-form">
      <SliderItem
        :forms="sortSetsForSlider"
        @onChangeActiveForm="changeActiveForm"
      />
      <div class="slide-card sets">
        <div class="sets-left">
          <span>{{ sortSetsList[activeForm].name }}</span>
          <img :src="sortSetsList[activeForm].photoWithForm" :alt="sortSetsList[activeForm].name">
        </div>
        <div class="sets-right">
          <div class="sets-info">
            <div v-if="sortSetsList[activeForm].form !== null">
              <span>Форма 1:</span>
              <span>Форма: {{ getFormOneInfo[0].name }}</span>
              <span>Объем: {{ getFormOneInfo[0].volume }} мл</span>
              <span>Высота: {{ getFormOneInfo[0].height }} мм</span>
            </div>
            <div v-if="sortSetsList[activeForm].formForSet !== null">
              <span>Форма 2:</span>
              <span>Форма: {{ getFormTwoInfo[0].name }}</span>
              <span>Объем: {{ getFormTwoInfo[0].volume }} мл</span>
              <span>Высота: {{ getFormTwoInfo[0].height }} мм</span>
            </div>
            <div v-if="sortSetsList[activeForm].formForSet2 !== null">
              <span>Форма 3:</span>
              <span>Форма: {{ getFormThreeInfo[0].name }}</span>
              <span>Объем: {{ getFormThreeInfo[0].volume }} мл</span>
              <span>Высота: {{ getFormThreeInfo[0].height }} мм</span>
            </div>
          </div>
          <div class="sets-image">
            <img v-if="activePackSlide === 1" :src="sortSetsList[activeForm].photoOpenedForm"
                 alt="sortSetsList[activeForm].name" rel="preload">
            <img v-if="activePackSlide === 2" :src="sortSetsList[activeForm].photoClosedForm"
                 alt="sortSetsList[activeForm].name" rel="preload">
            <div class="sets-image_nav prev" @click="slidePackPrev" v-if="activePackSlide === 2">
              <img src="./../assets/arrow-prev.svg" alt="nav-prev" rel="preload">
            </div>
            <div class="sets-image_nav next" @click="slidePackNext" v-if="activePackSlide === 1">
              <img src="./../assets/arrow-next.svg" alt="nav-next" rel="preload">
            </div>
            <div class="dots-nav">
              <span :class="{active : activePackSlide===1}" @click="slidePackPrev"></span>
              <span :class="{active : activePackSlide===2}" @click="slidePackNext"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SliderItem from "./SliderItem";

export default {
  name: "SetsList",
  components: {
    SliderItem
  },
  data: () => ({
    activeForm: 0,
    activePackSlide: 1,
    allInfo: {
      onCheck: false,
    },
    orderInfo: {
      package: '',
      packVolume: 0,
      packWeight: 0,
      setsForm2: null,
      setsForm3: null,
    },
  }),
  props: {
    allFormList: {
      type: Array,
    },
    techList: {
      type: Array,
    },
    sets: {
      type: Object,
    },
    chooseSetsNumber: {
      type: Number,
    },
    allSelected: {
      type: Object,
    },
    startPoint: {
      type: String,
    }
  },
  methods: {
    changeActiveForm(data) {
      this.activeForm = data.activeForm;
      this.allInfo.onCheck = data.onCheck;
      this.orderInfo.package = 'Сет' + ' / ' + this.sortSetsList[this.activeForm].setCount + 'шт.';
      this.orderInfo.packVolume = this.sortSetsList[this.activeForm].setVolume;
      this.orderInfo.packWeight = this.sortSetsList[this.activeForm].setWeight;
      if (this.getFormTwoInfo !== null) {
        this.orderInfo.setsForm2 = this.getFormTwoInfo[0].name;
      }
      if (this.getFormThreeInfo !== null) {
        this.orderInfo.setsForm3 = this.getFormThreeInfo[0].name;
      }
      this.$emit('getAllInfo', this.allInfo);
      this.$emit('getOrderInfo', this.orderInfo);
    },
    slidePackNext() {
      if (this.activePackSlide !== 2) {
        this.activePackSlide = 2
      }
    },
    slidePackPrev() {
      if (this.activePackSlide !== 1) {
        this.activePackSlide = 1
      }
    }
  },
  computed: {
    sortSetsList() {
      if(this.startPoint === 'PackingList') {
        return this.sets.data.filter((item) => item.setCount === this.chooseSetsNumber && item.form === this.allSelected.formId);
      }
      return this.sets.data.filter((item) => item.setCount === this.chooseSetsNumber);
    },
    sortSetsForSlider() {
      return this.sortSetsList.map((item) => {
        let obj = {id: item.id, picture: item.photoWithForm}
        return obj
      })
    },
    getFormOneInfo() {
      if (this.sortSetsList[this.activeForm].form !== null) {
        return this.allFormList.filter((item) => item.id === this.sortSetsList[this.activeForm].form)
      } else {
        return null;
      }
    },
    getFormTwoInfo() {
      if (this.sortSetsList[this.activeForm].formForSet !== null) {
        return this.allFormList.filter((item) => {
          return item.id === this.sortSetsList[this.activeForm].formForSet
        })
      } else {
        return null;
      }
    },
    getFormThreeInfo() {
      if (this.sortSetsList[this.activeForm].formForSet2 !== null) {
        return this.allFormList.filter((item) => item.id === this.sortSetsList[this.activeForm].formForSet2)
      } else {
        return null;
      }
    }
  }
}
</script>

<style>

.slide-card.sets {
  flex-direction: row;
}

.sets-left {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 200px;
  height: 370px;
}

.sets-left span {
  font-weight: 400;
  font-size: 20px;
  line-height: 119.68%;
  color: #252525;
}

.sets-left img {
  max-width: 190px;
  margin-top: 20px;
}

.sets-right {
  width: 400px;
  height: 370px;
  box-sizing: border-box;
  padding-left: 10px;
}

.sets-info {
  display: flex;
  justify-content: flex-end;
}

.sets-info div {
  display: flex;
  flex-direction: column;
  margin-right: 10px;
}

.sets-info div:last-child {
  margin-right: 0px;
}

.sets-info div span {
  font-weight: 300;
  font-size: 16px;
  line-height: 22px;
  color: #252525;
}

.sets-info div span:first-child {
  font-weight: 400;
  font-size: 16px;
  line-height: 22px;
  color: #252525;
}

.sets-image {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  height: 280px;
}

.sets-image img {
  max-width: 290px;
  width: 100%;
  max-height: 100%;
}

.sets-image_nav {
  cursor: pointer;
}

.sets-image_nav.next {
  position: absolute;
  right: 10px;
  top: 45%;
}

.sets-image_nav.prev {
  position: absolute;
  left: 10px;
  top: 45%;
}

.dots-nav {
  position: absolute;
  bottom: 0;
}

.dots-nav span {
  content: "";
  position: absolute;
  width: 8px;
  height: 8px;
  background: #C4C4C4;
  border-radius: 50px;
  transition: 200ms;
  cursor: pointer;
}

.dots-nav span.active {
  width: 10px;
  height: 10px;
  background: #E6330E;
  transition: 200ms;
}

.dots-nav span:first-child {
  left: -8px;
}

.dots-nav span:last-child {
  left: 8px;
}

</style>
