<template>
  <div class="slide-block">
    <div class="slide-list">
      <div class="slide-item" :class="{active : item.id === forms[allInfo.activeForm].id}"
           v-for="(item, i) in sortArray" :key="i" @click="itemFormClick(i, item.id)">
        <img :src="imageSrc(item)" :alt="item.name || ''">
        <span v-if="!item.pattern && item.name">{{ item.name }}</span>
        <span v-else-if="item.pattern">{{ item.pattern }}</span>
        <div class="slide-item_checkbox" v-if="checkbox">
          <input type="checkbox" :id="item.id" :value="item.id" @change="setCheckedId(item.id, item.pattern, imageSrc(item))">
        </div>
      </div>
    </div>
    <div class="slide-nav">
      <div class="slide-nav-next" @click="nextFormView()" v-if="activeButton">
        <img src="./../assets/arrow-down.svg" alt="nav-next">
      </div>
      <div class="slide-nav-prev" @click="prevFormView()" v-if="activeButton">
        <img src="./../assets/arrow-up.svg" alt="nav-prev">
      </div>
    </div>
  </div>

</template>

<script>
export default {
  name: "SliderItem",
  data: () => ({
    activeIndex: 0,
    startIndexForm: 0,
    stopIndexForm: 6,
    allInfo: {
      onCheck: false,
      activeForm: 0,
      selectPattern: [],
      selectId: [],
    },
    orderInfo: {
      id: 0,
      patternsName: [],
    }
  }),
  props: {
    forms: {
      type: Array,
    },
    checkbox: {
      type: Boolean,
    }
  },
  methods: {
    itemFormClick(i, id) {
      // if (!this.checkbox) {
      //    //Находит индекс элемента в массиве
      // }
      this.setActiveIndex(id);
      this.itemFormActive(i, id); //Делает выбранный элемент активным
    },
    setActiveIndex(id) {
      this.allInfo.activeForm = this.forms.findIndex(form => form.id === id);
    },
    setCheckedId(id, name, picture) {
      //Для чекбоксов. Проверяет, был ли ранее выбран элемент. Если нет, добавляет в массив, иначе удаляет из него.
      let index = this.allInfo.selectPattern.indexOf(id);
      if (index === -1) {
        this.allInfo.selectPattern.push(id);
        this.orderInfo.patternsName.push({id: id, name: name, picture: picture});
      } else {
        this.allInfo.selectPattern.splice(index, 1);
        this.orderInfo.patternsName.splice(index, 1);
      }
      //Если массив выбранных чекбокосов не нулевой, то активирует кнопку Вперед
      if (!this.allInfo.selectPattern.length) {
        this.allInfo.onCheck = false;
      } else {
        this.allInfo.onCheck = true;
      }
      //Передает наверх состояние кнопки и id выбранных узоров.
      this.$emit('onChangeActiveForm', this.allInfo);
      this.$emit('onChangePatternsList', this.orderInfo);
    },
    itemFormActive(i, id) {
      this.activeIndex = i;
      //Проверяет, не используют ли на форме чекбоксы. Если нет, то при нажатии на элемент активирует кнопку
      if (this.checkbox !== true) {
        this.allInfo.onCheck = true;
      }
      this.allInfo.selectId = id;
      //Передает наверх состояние кнопки Вперед и id выбранного элемента
      this.$emit('onChangeActiveForm', this.allInfo);
    },
    nextFormView() {
      if (this.stopIndexForm < this.forms.length) {
        this.startIndexForm += 6;
        this.stopIndexForm += 6;
        this.activeIndex = '';
      }
    },
    prevFormView() {
      if (this.startIndexForm > 0) {
        this.startIndexForm -= 6;
        this.stopIndexForm -= 6;
        this.activeIndex = '';
      }
    },
    imageSrc(item) {
      if (!item.previewPicture) {
        if (item.picture !== null) {
          return item.picture;
        }
        return require('./../assets/no-image.png');

      } else {
        if (item.previewPicture !== true) {
          return item.previewPicture;
        }
        return require('./../assets/no-image.png');
      }
    }
  },
  computed: {
    sortArray() {
      return this.forms.slice(this.startIndexForm, this.stopIndexForm);
    },
    activeButton() {
      if (this.forms.length > 6) {
        return true;
      } else {
        return false;
      }
    },
    checkSelected() {
      return this.forms.filter(({id}) => this.allInfo.selectId.includes(parseInt(id)));
    }
  }
}
</script>

<style>
/*slide-list*/
.slide-block {
  display: flex;
  flex-direction: column;
  width: 550px;
  padding: 0 20px;
  box-sizing: border-box;
}

.slide-list {
  height: 340px;
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  align-items: flex-start;
  padding: 10px;
}

.slide-item {
  display: flex;
  position: relative;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 160px;
  height: 160px;
  text-align: center;
  border: 2px solid #d9d9d900;
  border-radius: 3px;
  box-sizing: border-box;
  transition: 400ms;
  cursor: pointer;
}

.slide-item:hover, .slide-item.active {
  border: 2px solid #D9D9D9;
  border-radius: 3px;
  transition: 400ms;
}

.slide-item_checkbox {
  position: absolute;
  right: 7px;
  bottom: 0;
}

.slide-item img {
  max-width: 120px;
}

.slide-item span {
  font-weight: 300;
  font-size: 12px;
  line-height: 17px;
  color: #000000;
}

.slide-nav {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40px;
}

.slide-nav .slide-nav-next, .slide-nav .slide-nav-prev {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  cursor: pointer;
  margin: 0 5px;
}

.slide-nav .slide-nav-next img, .slide-nav .slide-nav-prev img {
  opacity: 0.5;
  transition: 300ms;
}

.slide-nav .slide-nav-next:hover img, .slide-nav .slide-nav-prev:hover img {
  opacity: 1;
  transition: 300ms;
}

/*slide-list*/
</style>
