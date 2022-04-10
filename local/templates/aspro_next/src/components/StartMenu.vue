<template>
  <div>
    <div class="start-title">
      С чего начнем?
    </div>

    <div class="start-list">

      <div class="start-item" v-for="(item, i) in items" :key="i" :class="{active : i === activeIndex}" @click="itemCheck(i)">
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
      {image: require('../assets/start/start-tech.png'), title: 'Технология'},
      {image: require('../assets/start/start-form.png'), title: 'Вид формы'},
      {image: require('./../assets/start/start-pack.png'), title: 'Упаковка'}
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

.start-title {
  text-align: center;
  font-size: 36px;
  margin-bottom: 50px;
}

.start-list {
  display: flex;
  justify-content: space-between;
}

.start-item {
  display: flex;
  flex-direction: column;
  text-align: center;
  padding: 24px;
  border: 2px solid #fff0;
  border-radius: 20px;
  transition: 400ms;
  cursor: pointer;
}

/*.start-item:hover {
  border: 2px solid #172B77;
  transition: 400ms;
}*/

.start-item.active {
  border: 2px solid #172B77;
  transition: 400ms;
}

.start-item img {
  max-width: 200px;
}

.start-item span {
  font-size: 22px;
  padding: 10px;
}

</style>