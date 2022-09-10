<template>
  <div class="conf-nav">
    <ul>
      <li :class="[{active: step === i}, {checked: step > i}, themeColors[i]]"
          v-for="(item, i) in topMenu"
          :key="i">
          <span class="nav-num">{{ i + 1 }}</span>
          <span class="nav-text">{{ item }}</span>
          <span class="nav-checked">
            <img :src="require('../assets/Vector.svg')" alt="">
          </span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "HeaderNav",
  data: () => ({
    counter: 0,
    themeColors: [
      'color-one',
      'color-two',
      'color-three',
      'color-four',
      'color-five',
      'color-six',
      'color-seven',
      'color-eight'
    ]
  }),
  props: {
    topMenu: {
      type: Array,
    },
    step: {
      type: Number,
    }
  },
  methods: {
    // onGetCounter(counter) {
    //   this.counter = counter;
    //   return this.$emit('getCounter', counter);
    // },
    // getNavIndex(i) {
    //   return this.$emit('getNavIndex', i);
    // }
  }
}
</script>

<style scoped>
.conf-nav {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 75px;
}
.conf-nav ul {
  display: flex;
  justify-content: space-around;
  padding: 0;
  margin: 0;
  position: relative;
  top: -5px;
}
.conf-nav ul li {
  position: relative;
  display: flex;
  align-items: center;
  flex-direction: column;
  list-style-type: none;
  margin-right: 85px;
  /*cursor: pointer;*/
}
.conf-nav ul li:last-child {
  margin-right: 0;
}
.conf-nav ul li:after {
  content: "";
  position: absolute;
  left: 20px;
  top: 20px;
  width: 120px;
  height: 2px;
  background: #EAEAEA;
  z-index: 1;
}
.conf-nav ul li:last-child:after {
  width: 0;
}

.nav-num {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  background: #FFFFFF;
  font-weight: 600;
  font-size: 14px;
  line-height: 19px;
  text-align: center;
  color: #000000;
  border: 3px solid;
  border-color: #fff0;
  box-sizing: border-box;
  box-shadow: 0px 0px 9px -2px rgba(0, 0, 0, 0.45);
  border-radius: 50px;
  transition: 400ms;
  z-index: 99;
}
.nav-text {
  position: absolute;
  top: 44px;
  width: max-content;
  font-weight: 500;
  font-size: 14px;
  line-height: 19px;
  text-align: center;
  color: #797979;
  transition: 400ms;
}
.conf-nav ul li.active .nav-num {
  border: 3px solid;
  box-shadow: none;
  box-sizing: border-box;
  transition: 400ms;
}
.conf-nav ul li.active .nav-text {
  color: #252525;
  transition: 400ms;
}
.conf-nav ul li.checked .nav-text {
  color: #797979;
  transition: 400ms;
}
.nav-checked {
  opacity: 0;
  position: absolute;
  width: 40px;
  height: 40px;
  border-radius: 50px;
  z-index: 100;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: 400ms;
}
.checked .nav-checked {
  opacity: 1;
  transition: 400ms;
}








.conf-nav ul li.checked.color-one:after {
  background: linear-gradient(to right, var(--color-one), var(--color-two));
}
.conf-nav ul li.checked.color-two:after {
  background: linear-gradient(to right, var(--color-two), var(--color-three));
}
.conf-nav ul li.checked.color-three:after {
  background: linear-gradient(to right, var(--color-three), var(--color-four));
}
.conf-nav ul li.checked.color-four:after {
  background: linear-gradient(to right, var(--color-four), var(--color-five));
}
.conf-nav ul li.checked.color-five:after {
  background: linear-gradient(to right, var(--color-five), var(--color-six));
}
.conf-nav ul li.checked.color-six:after {
  background: linear-gradient(to right, var(--color-six), var(--color-seven));
}
.conf-nav ul li.checked.color-seven:after {
  background: linear-gradient(to right, var(--color-seven), var(--color-eight));
}
/*.conf-nav ul li.checked.color-eight:after {*/
/*  background: linear-gradient(to right, var(--color-eight), var(--color-three));*/
/*}*/


.conf-nav ul li.active.color-one .nav-num {
  border-color: var(--color-one);
}
.conf-nav ul li.active.color-two .nav-num {
  border-color: var(--color-two);
}
.conf-nav ul li.active.color-three .nav-num {
  border-color: var(--color-three);
}
.conf-nav ul li.active.color-four .nav-num {
  border-color: var(--color-four);
}
.conf-nav ul li.active.color-five .nav-num {
  border-color: var(--color-five);
}
.conf-nav ul li.active.color-six .nav-num {
  border-color: var(--color-six);
}
.conf-nav ul li.active.color-seven .nav-num {
  border-color: var(--color-seven);
}
.conf-nav ul li.active.color-eight .nav-num {
  border-color: var(--color-eight);
}

.checked.color-one .nav-checked {
  background-color: var(--color-one);
}
.checked.color-two .nav-checked {
  background-color: var(--color-two);
}
.checked.color-three .nav-checked {
  background-color: var(--color-three);
}
.checked.color-four .nav-checked {
  background-color: var(--color-four);
}
.checked.color-five .nav-checked {
  background-color: var(--color-five);
}
.checked.color-six .nav-checked {
  background-color: var(--color-six);
}
.checked.color-seven .nav-checked {
  background-color: var(--color-seven);
}
.checked.color-eight .nav-checked {
  background-color: var(--color-eight);
}
</style>
