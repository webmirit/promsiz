<template>
  <div class="formSelect">
    <div class="formSlide">
      <span class="nav-prev"><img src="./../assets/arrow.svg" alt="arrow preview"></span>
      <div class="listForm">
        <div class="itemForm" v-for="(item, i) in forms" :key="i" @click="getActive(i)">
          <img :src="item.src" :alt="item.id">
        </div>
      </div>
      <span class="nav-next"><img src="./../assets/arrow.svg" alt="arrow preview"></span>
    </div>
    <div class="form-card">
      Название: {{ forms[activeForm].type + ' ' +forms[activeForm].id}}
      Объем: {{ forms[activeForm].volume }}
      Высота: {{ forms[activeForm].height }}
    </div>
  </div>

</template>

<script>
export default {
  name: "FormList",
  data: () => ({
    activeForm: '0',
    forms: [
      {
        src: require('../assets/formSelect/1649.jpg'),
        id: 1649,
        volume: 250,
        height: 93,
        type: 'Кружка'
      },
      {
        src: require('../assets/formSelect/5029.jpg'),
        id: 5029,
        volume: 250,
        height: 92,
        type: 'Кружка'
      },
      {
        src: require('../assets/formSelect/5393.jpg'),
        id: 5393,
        volume: 325,
        height: 120,
        type: 'Кружка'
      },
      {
        src: require('../assets/formSelect/1337.jpg'),
        id: 1337,
        volume: 200,
        height: 69,
        type: 'Чашка'
      },
      {
        src: require('../assets/formSelect/1416.jpg'),
        id: 1416,
        volume: 220,
        height: 65,
        type: 'Чашка'
      },
      {
        src: require('../assets/formSelect/531.jpg'),
        id: 531,
        volume: 350,
        height: 98.5,
        type: 'Кружка'
      },
      {
        src: require('../assets/formSelect/353.jpg'),
        id: 353,
        volume: 320,
        height: 90,
        type: 'Кружка'
      },
    ]
  }),
  methods: {
    getActive(item) {
      this.activeForm = item;
    }
  }
}
</script>

<style scoped>
.formSelect {
  display: flex;
}

.formSlide {
  display: flex;
  flex-direction: column;
}

.nav-prev img {
  width: 100px;
  transform: rotate(180deg);;
}

.nav-next img {
  width: 100px;
}

.itemForm img {
  max-width: 100px;
}
</style>