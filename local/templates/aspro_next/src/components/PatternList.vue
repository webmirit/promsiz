<template>
  <div class="conf-content" v-if="loadStatus">
    <div class="conf-title">
      Выберите узор
    </div>
    <div class="slide-form">
      <SliderItem
        :forms="patternsList.data"
        :checkbox="enableCheckbox"
        @onChangeActiveForm="changeActiveForm"
        @onChangePatternsList="onChangePatternsList"
      />
      <div class="slide-card">
        <div class="slide-card-image">
          <img v-if="patternsList.data[activeForm].previewPicture !== true"
               :src="patternsList.data[activeForm].previewPicture" :alt="patternsList.data[activeForm].name">
          <img v-else src="./../assets/no-image.png" alt="No image">
        </div>
        <div class="slide-card-name">
          Узор: {{ patternsList.data[activeForm].pattern }}
        </div>
        <div class="slide-card-description">

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SliderItem from "./SliderItem";

export default {
  name: "PatternList",
  components: {
    SliderItem
  },
  data: () => ({
    disabledItem: false,
    activeForm: 0,
    activeIndex: 0,
    onCheck: true,
    startIndexForm: 0,
    stopIndexForm: 6,
    patternsImage: [],
    enableCheckbox: true,
    allInfo: {
      onCheck: false,
      patternList: [],
    },
    orderInfo: {
      patternsName: [],
    }
  }),
  props: {
    patternsList: {
      type: Object,
    },
    loadStatus: {
      type: Boolean,
      default: false,
    }
  },
  methods: {
    changeActiveForm(data) {
      this.activeForm = data.activeForm;
      this.allInfo.onCheck = data.onCheck;
      this.allInfo.patternList = data.selectPattern;
      this.$emit('getAllInfo', this.allInfo);
    },
    onChangePatternsList(data) {
      this.orderInfo.patternsName = data.patternsName;
      this.$emit('getOrderInfo', this.orderInfo);
    }
  },
  computed: {
    getProductName() {
      return this.patternsList.data[this.activeForm].name;
    }
  }
}
</script>

<style>

</style>
