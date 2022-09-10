<template>
  <div class="conf-content" v-if="loadStatus || step === 1">
    <div class="conf-title">
      Выберите тип упаковки
    </div>
    <div class="slide-form">
      <div class="pac-options">
        <div class="pac-type">
          <div class="pac-title">
            Тип упаковки:
          </div>
          <ul class="pac-type-list">
            <li v-for="(item, i) in sortPackTypeList" :key="i" @click="setActivePackType(item.id, item.name)"
                :class="{ active : item.id === activePackType }">
              {{ item.name }}
            </li>
<!--            <li v-if="checkSets" @click="clickOnSets()" :class="{ active : activeSets }">-->
<!--              Сеты-->
<!--            </li>-->
          </ul>
        </div>
        <div class="pac-quantity">
          <div class="pac-title">
            Количество:
          </div>
          <ul class="pac-quantity-list" v-if="!activeSets">
            <li v-for="(item, i) in getPackNumber" :key="i" :class="{ active : i === activeNum }"
                @click="setActiveNum(i)">
              {{ item.count }}
            </li>
          </ul>
          <ul class="pac-quantity-list" v-else>
            <li v-for="(item, i) in getSetsNumber" :key="i" :class="{active : i === activeSetsNum}"
                @click="setSetsNum(item, i)">
              {{ item }}
            </li>
          </ul>
        </div>
      </div>
      <div class="pac-info" v-if="!activeSets">
        <img :src="getPackImage" alt="" rel="preload">
      </div>
      <div class="pac-info" v-else>
        <img src="./../assets/packjsets.jpg" alt="Сеты" rel="preload">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PackingList",
  data: () => ({
    activePackType: 0,
    activePackTypeName: '',
    activePackId: 0,
    activeNum: 0,
    activeNumName: 0,
    activeSets: false,
    activeNumSets: 0,
    allInfo: {
      onCheck: false,
    },
    orderInfo: {
      package: '',
      packVolume: 0,
      packWeight: 0,
      packageType: null,
      packageNum: null,
    },
    defaultPackTypeList: [
      {
        id: 101,
        name: 'Открытая'
      },
      {
        id: 102,
        name: 'Закрытая'
      },
      {
        id: 103,
        name: 'Сервис лайн'
      },
    ],
    defaultPackList: [
      {
        id: 201,
        type: 101,
        count: 1,
        picture: require('../assets/package/open/o-1.jpg'),
      },
      {
        id: 202,
        type: 101,
        count: 2,
        picture: require('../assets/package/open/o-2.jpg'),
      },
      {
        id: 206,
        type: 101,
        count: 6,
        picture: require('../assets/package/open/o-6.jpg'),
      },
      {
        id: 211,
        type: 102,
        count: 1,
        picture: require('../assets/package/close/c-1.jpg'),
      },
      {
        id: 212,
        type: 102,
        count: 2,
        picture: require('../assets/package/close/c-2.jpg'),
      },
      {
        id: 214,
        type: 102,
        count: 4,
        picture: require('../assets/package/close/c-4.jpg'),
      },
      {
        id: 216,
        type: 102,
        count: 6,
        picture: require('../assets/package/close/c-6.png'),
      },
      {
        id: 226,
        type: 103,
        count: 6,
        picture: require('../assets/package/service/s-12.jpg'),
      },
      {
        id: 2212,
        type: 103,
        count: 12,
        picture: require('../assets/package/service/s-12.jpg'),
      },
      {
        id: 2224,
        type: 103,
        count: 24,
        picture: require('../assets/package/service/s-24.jpg'),
      },
    ],
    defaultSetsList: [3, 6, 7, 12, 18],
    defaultPackPic: [
      {
        id: 201,
        picture: require('../assets/startpack/openpack.jpg'),
      },
      {
        id: 202,
        picture: require('../assets/startpack/closepack.jpg'),
      },
      {
        id: 203,
        picture: require('../assets/startpack/gofrapack.jpg'),
      },
    ],
    activeSetsNum: 0,
  }),
  props: {
    packTypeList: {
      type: Array,
      default: () => [],
    },
    packList: {
      type: Array,
      default: () => [],
    },
    allSelected: {
      type: Object,
    },
    sets: {
      type: Object,
    },
    loadStatus: {
      type: Boolean,
      default: false,
    },
    step: {
      type: Number,
    },
  },
  methods: {
    setActivePackType(id, name) {
      this.activeSets = false;
      this.activePackType = id;
      this.activePackTypeName = '';
      this.activePackTypeName = name;
      this.activeNum = 0;
      this.activeNumName = '';
      this.activeNumName = this.getPackNumber[this.activeNum].count;
      this.orderInfo.packVolume = this.getPackNumber[this.activeNum].volume;
      this.orderInfo.packWeight = this.getPackNumber[this.activeNum].weight;
      this.orderInfo.package = this.activePackTypeName + ' / ' + this.getPackNumber[this.activeNum].count + 'шт.';
      this.orderInfo.packageType = this.activePackType;
      this.orderInfo.packageNum = this.activeNumName;
      this.activeSets = false;
      if (this.step === 1) {
        this.allInfo.onCheck = true;
        this.$emit('getAllInfo', this.allInfo);
      }
      this.$emit('activeSets', this.activeSets);
      this.$emit('getOrderInfo', this.orderInfo);
      this.$emit('getCategoryByPack', {packSection: this.activePackType, count: this.activeNumName})
    },
    setActiveNum(i) {
      this.activeNum = i;
      this.activeNumName = '';
      this.activeNumName = this.getPackNumber[i].count;
      this.orderInfo.packVolume = this.getPackNumber[this.activeNum].volume;
      this.orderInfo.packWeight = this.getPackNumber[this.activeNum].weight;
      this.orderInfo.package = this.activePackTypeName + ' / ' + this.getPackNumber[this.activeNum].count + 'шт.';
      this.orderInfo.packageType = this.activePackType;
      this.orderInfo.packageNum = this.activeNumName;
      this.$emit('getOrderInfo', this.orderInfo);
      this.$emit('getCategoryByPack', {packSection: this.activePackType, count: this.activeNumName})
    },
    clickOnSets() {
      this.activeNum = null;
      this.activePackType = null;
      this.activeSets = true;
      this.activeSetsNum = 0;
      if (this.step === 1) {
        this.allInfo.onCheck = true;
        this.$emit('getAllInfo', this.allInfo);
      }
      let [first] = this.getSetsNumber
      this.$emit('chooseSetsNum', first);
      this.$emit('activeSets', this.activeSets);
      this.$emit('getCategoriesWithSets', {count: this.getSetsNumber[this.activeSetsNum]});
    },
    setSetsNum(item, i) {
      this.activeSetsNum = i;
      this.$emit('chooseSetsNum', item);
      this.$emit('getCategoriesWithSets', {count: this.getSetsNumber[this.activeSetsNum]});
    }

  },
  computed: {
    getPackNumber() {
      if (this.allSelected.formId.length !== 0) {
        return this.packList.filter(item => item.type === this.activePackType && item.form === this.allSelected.formId).sort((a, b) => a.count > b.count ? 1 : -1);
      }

      return this.packList.filter(item => item.type === this.activePackType).reduce((res, item) => {
        if (!res.find(({count}) => item.count === count)) {
          res.push(item);
        }
        return res;
      }, []).sort((a, b) => a.count > b.count ? 1 : -1);
    },
    sortPackTypeList() {
      if (this.allSelected.formId.length !== 0) {
        const sortByForm = this.packList.filter(item => item.form === this.allSelected.formId);
        const sortByPack = sortByForm.map(item => Number(item.type));
        return this.packTypeList.filter(({id}) => sortByPack.includes(parseInt(id)));
      }
      const sortByForm = this.packList;
      const sortByPack = sortByForm.map(item => Number(item.type));
      return new Set(this.packTypeList.filter(({id}) => sortByPack.includes(parseInt(id))).sort((a, b) => a - b));
    },
    getPackImage() {
      if (undefined === this.getPackNumber[this.activeNum]) {
        return;
      }
      if (this.step === 1) {
        const sortPackType = this.defaultPackPic.filter((item) => item.id === this.activePackType);
        return sortPackType[0].picture;
      }
      return this.getPackNumber[this.activeNum].picture;
    },
    getSetsNumber() {
      if (this.step !== 1) {
        let sortCount = this.sets.data.map((item) => {
          return Number(item.setCount);
        });
        return new Set(sortCount.sort((a, b) => a - b));
      } else {
        return this.defaultSetsList;
      }

    },
    getPackSetsImage() {
      if (this.getSetsNumber[this.activeNumSets] === undefined) {
        return;
      }
      return this.getSetsNumber[this.activeNumSets].photoWithForm;
    },
    checkSets() {
      if (this.step === 1) {
        return true;
      }
      if (this.sets.data.length > 0) {
        return true;
      } else {
        return false;
      }
    }
  }
}
</script>

<style>
.pac-options {
  width: 550px;
  padding: 60px;
  box-sizing: border-box;
}

.pac-quantity {
  margin-top: 25px;
}

.pac-title {
  margin-left: 5px;
  font-weight: 400;
  font-size: 18px;
  line-height: 25px;
  color: #252525;
}

.pac-type-list, .pac-quantity-list {
  display: flex;
  flex-wrap: wrap;
  width: 400px;
  margin: 0;
  padding: 0;
}

.pac-type-list li, .pac-quantity-list li {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 5px;
  border: 1px solid #D9D9D9;
  border-radius: 4px;
  list-style-type: none;
  font-weight: 300;
  font-size: 15px;
  line-height: 20px;
  text-align: center;
  color: #252525;
  transition: 100ms;
  box-sizing: border-box;
  cursor: pointer;
}

.pac-type-list li:hover, .pac-quantity-list li:hover {
  border: 3px solid;
  box-sizing: border-box;
  transition: 100ms;
}

.pac-type-list li.active, .pac-quantity-list li.active {
  border: 3px solid;
  box-sizing: border-box;
  transition: 100ms;
}

.pac-type-list li {
  width: 186px;
  height: 33px;
}

.pac-quantity-list li {
  width: 88px;
  height: 34px;
}

.pac-info {
  width: 600px;
  text-align: center;
}

.pac-info img {
  max-height: 100%;
}

.t-color-two .pac-type-list li.active, .t-color-two .pac-quantity-list li.active, .t-color-two .pac-type-list li:hover, .t-color-two .pac-quantity-list li:hover {
  border-color: var(--color-one);
}

.t-color-six .pac-type-list li.active, .t-color-six .pac-quantity-list li.active, .t-color-six .pac-type-list li:hover, .t-color-six .pac-quantity-list li:hover {
  border-color: var(--color-six);
}
</style>
