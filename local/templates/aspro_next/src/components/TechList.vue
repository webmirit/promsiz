<template>
  <div class="conf-content" v-if="loadStatus || !sortTech">
    <div class="conf-title">
      Выберите технологию
    </div>
    <div class="slide-form">
      <SliderItem v-if="sortTech" :forms="getTechIcon" @onChangeActiveForm="changeActiveForm"/>
      <SliderItem v-else :forms="techList" @onChangeActiveForm="changeActiveForm"/>
      <div class="slide-card" v-if="sortTech">
        <div class="slide-card-name">
          Технология {{ getTechIcon[activeForm].code }} {{ getTechIcon[activeForm].shortDescription }}
        </div>
        <div class="slide-card-image">
          <img v-if="getTechInfo[0].picture" :src="getTechInfo[0].picture" :alt="getTechInfo[0].name">
          <img v-else src="./../assets/no-image.png" alt="No image">
        </div>
        <div class="slide-card-description">
          {{ getTechIcon[activeForm].description }}
        </div>
      </div>
      <div class="slide-card" v-else>
        <div class="slide-card-name">
          Технология {{ techList[activeForm].code }} {{ techList[activeForm].shortDescription }}
        </div>
        <div class="slide-card-image">
          <img :src="techList[activeForm].detailPicture" :alt="techList[activeForm].name">
        </div>
        <div class="slide-card-description">
          {{ techList[activeForm].description }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SliderItem from "./SliderItem";

export default {
  name: "TechList",
  components: {
    SliderItem
  },
  data() {
    return {
      activeForm: 0,
      activeIndex: 0,
      startIndexForm: 0,
      stopIndexForm: 6,
      techIconList: [],
      allInfo: {
        onCheck: false,
        techId: 0,
      },
      orderInfo: {
        techName: '',
      }
    }
  },
  props: {
    techList: {
      type: Array,
    },
    techs: {
      type: Object,
      default: () => {
        return {};
      }
    },
    sortTech: {
      type: Boolean,
      default: false,
    },
    loadStatus: {
      type: Boolean,
      default: false,
    },
    allSelected: {
      type: Object,
    }
  },
  methods: {
    changeActiveForm(data) {
      this.activeForm = data.activeForm;
      this.allInfo.onCheck = data.onCheck;
      this.allInfo.techId = Number(data.selectId);
      if (this.sortTech) {
        this.orderInfo.techName = this.getTechIcon[this.activeForm].code + ' ' + this.getTechIcon[this.activeForm].shortDescription;
      } else {
        this.orderInfo.techName = this.techList[this.activeForm].code + ' ' + this.techList[this.activeForm].shortDescription;
      }
      this.$emit('getAllInfo', this.allInfo);
      this.$emit('getOrderInfo', this.orderInfo);
    }
  },
  computed: {
    getTechIcon() {
      if (this.sortTech) {
        if (!this.techList.length && !this.techs.data.length) {
          return;
        }
        const techs = this.techs;
        const techList = this.techList;
        const firstSort = techs.data.map(({technology}) => Number(technology));
        return techList.filter(({id}) => firstSort.includes(parseInt(id)));
      } else {
        return [];
      }

    },
    getTechInfo() {
      if (this.sortTech) {
        return this.techs.data.filter(item => item.technology === this.getTechIcon[this.activeForm].id);
      } else {
        return [];
      }
    }
  }
}
</script>

<style>

</style>
