<template>
  <div class="conf-content" v-if="loadStatus">
    <div class="conf-title">
      Выберите форму
    </div>
    <div class="slide-form">
      <SliderItem :forms="getFormList" @onChangeActiveForm="onChangeActiveForm"/>
      <div class="slide-card">
        <div class="slide-card-name">
          {{ getFormList[activeForm].name }}
        </div>
        <div class="slide-card-image">
          <img v-if="getFormList[activeForm].picture" :src="getFormList[activeForm].picture"
               :alt="getFormList[activeForm].name">
          <img v-else src="./../assets/no-image.png" alt="No image">
        </div>
        <div class="slide-card-description">
          <ul>
            <li><strong>Объем:</strong>{{ getFormList[activeForm].volume }}</li>
            <li><strong>Высота:</strong>{{ getFormList[activeForm].height }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SliderItem from "./SliderItem";

export default {
  components: {
    SliderItem
  },
  name: "FormList",
  data: () => ({
    activeForm: 0,
    allInfo: {
      onCheck: false,
      formId: 0,
    },
    orderInfo: {
      formName: '',
    }
  }),
  props: {
    formList: {
      type: Array,
    },
    loadStatus: {
      type: Boolean,
      default: false,
    },
    startPoint: {
      type: String,
    },
    formByPack: {
      type: Array,
    },
    checkSets: {
      type: Boolean,
    },
    dataBySets: {
      type: Object,
    }
  },
  methods: {
    onChangeActiveForm(data) {
      this.activeForm = data.activeForm;
      this.allInfo.onCheck = data.onCheck;
      this.allInfo.formId = Number(data.selectId);
      this.orderInfo.formName = this.getFormList[data.activeForm].name;
      this.$emit('getAllInfo', this.allInfo);
      this.$emit('getOrderInfo', this.orderInfo);
    }
  },
  computed: {
    getFormList() {
      if (!this.formList.length || this.formByPack === []) {
        return;
      }
      if (this.startPoint === 'PackingList' && !this.checkSets) {
        const newArr = [];
        this.formByPack.forEach(item => {
          newArr.push(...this.formList.filter((data) => data.id === item));
        })
        return newArr;
      }

      if (this.startPoint === 'PackingList' && this.checkSets) {
        const stockData = {...this.dataBySets.data.data};
        const formListBySets = [];
        stockData.setForms.forEach(item => {
          formListBySets.push(...this.formList.filter((data) => data.id === item));
        })
        return formListBySets;
      }

      return this.formList;
    }
  }
}
</script>

<style>
.slide-form {
  height: 370px;
  display: flex;
}

.slide-card {
  width: 600px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.slide-card-image {

}

.slide-card-name {
  height: 34px;
  font-weight: 400;
  font-size: 24px;
  line-height: 33px;
  color: #252525;
}

.slide-card-image img {
  max-height: 276px;
}

.slide-card-description {
  height: 60px;
  font-weight: 300;
  font-size: 15px;
  line-height: 24px;
  color: #252525;
}

.slide-card-description ul {
  margin: 0;
  padding: 0;
}

.slide-card-description ul li {
  list-style-type: none;
}

.slide-card-description strong {
  font-weight: 600;
  margin-right: 5px;
}
</style>
