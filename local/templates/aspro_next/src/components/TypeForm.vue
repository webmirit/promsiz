<template>
  <div class="conf-content">
    <div class="conf-title">
      Выберите тип формы
    </div>
    <div class="slide-type-form">
      <div class="slide-type-form_item" v-for="(item, i) in categories" :key="i" :class="{active : i === activeIndex}"
           @click="itemCheck(i)">
        <img :src="item.picture" :alt="item.name">
        <span>{{ item.name }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TypeForm",
  data: () => ({
    activeIndex: '',
    allInfo: {
      onCheck: false,
      formId: 0,
    },
    orderInfo: {
      formType: '',
    }
  }),
  props: {
    categories: {
      type: Array,
      default: function () {
        return [{id: 0, picture: '/upload/iblock/00a/00a552db5efbf8fd5adf032e7b2157a7.jpg', name: 'default'}];
      }
    }
  },
  methods: {
    itemCheck(index) {
      if (this.activeIndex === index) {
        this.activeIndex = '';
        this.allInfo.onCheck = false;
      } else {
        this.activeIndex = index;
        this.allInfo.category = this.categories[index].id;
        this.orderInfo.formType = this.categories[index].name;
        this.allInfo.onCheck = true;
      }
      this.$emit('getAllInfo', this.allInfo);
      this.$emit('getOrderInfo', this.orderInfo);
    }
  }
}
</script>

<style>
.slide-type-form {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  width: 100%;
  height: 340px;
  padding: 0 10px;
  margin: 20px 0;
  box-sizing: border-box;
  overflow-y: scroll;
}

.slide-type-form::-webkit-scrollbar {
  width: 5px;
}

.slide-type-form::-webkit-scrollbar-track {
  background-color: #eaeaeabf;
  border-radius: 4px;
}

.slide-type-form::-webkit-scrollbar-thumb {
  background-color: #A284AF;
  border-radius: 4px;
}

.slide-type-form_item {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 145px;
  width: 14%;
  border: 2px solid #d9d9d900;
  border-radius: 3px;
  transition: 400ms;
  cursor: pointer;
  padding: 5px;
  box-sizing: border-box;
}

.slide-type-form_item.active, .slide-type-form_item:hover {
  border: 2px solid #D9D9D9;
  border-radius: 3px;
  transition: 400ms;
}

.slide-type-form_item img {
  width: 85px;
  height: 85px;
}

.slide-type-form_item {
  text-align: center;
}
</style>
