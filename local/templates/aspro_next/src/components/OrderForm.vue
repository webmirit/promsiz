<template>
  <div class="conf-content">
    <div class="conf-title basket">
      Конфигурация заказа:
    </div>
    <div class="conf-add-item" @click="startOver">
      <span>+</span>Добавить ещё
    </div>
    <div v-if="cart.length > 0" class="conf-basket">
      <div class="basket-table">
        <table class="basket-list">
          <tr class="table-header">
            <td class="table-header_name">Название</td>
            <td class="table-header_pattern">Узор</td>
            <td class="table-header_form-pack">Упаковка</td>
            <td class="table-header_form-vol">Объём/вес</td>
            <td class="table-header_quality">Количество</td>
          </tr>
          <tr class="basket-list-item" v-for="(item) in cart" :key="item.pattern.id">
            <td>
              <img :src="item.picture" :alt="item.name">
              <div class="basket-item_info">
                <span>Форма: {{ item.name }}</span>
              </div>
            </td>
            <td>
              {{ item.pattern }}
            </td>
            <td>
              {{ item.package }}
            </td>
            <td>
              {{ item.packVolume }} м<sup>3</sup> / {{ item.packWeight }} кг
            </td>
            <td class="basket-list-item_quantity-td">
              <div class="basket-list-item_quantity">
                <span class="btn-quantity" @click="reduceQuantily(item)">-</span>
                <input type="text" name="input-quantity" id="input-quantity" class="input-quantity"
                       :value="item.quantity">
                <span class="btn-quantity" @click="addQuantity(item)">+</span>
              </div>
              <div class="basket-list-item_quantity-text">квант равен коробу</div>
              <div class="basket-list-item-drop" @click="dropProduct(item)"></div>
            </td>
          </tr>
        </table>
      </div>
      <div class="basket-form">
        <div class="basket-form_title">Информация о заказе</div>
        <ul>
          <li><span>Объем:</span> {{ orderVolume }} м3</li>
          <li><span>Вес:</span> {{ orderWeight }} кг</li>
          <li><span>Кол-во коробов:</span> {{ calcBox }}</li>
          <li><span>Кол-во паллет:</span> 2</li>
        </ul>
        <hr>
        <div class="basket-form_title">Ваши контакты</div>
        <form class="basket-form_feedback">
          <span>Имя:</span>
          <input type="text" v-model="orderInfo.userName">
          <span>Телефон:</span>
          <input type="text" v-mask="'+7 (###)###-####'" v-model="orderInfo.userPhone" placeholder="+7 (___) ___-____">
          <button class="conf-btn" @click="sendOrder">Отправить</button>
        </form>
      </div>
      <div class="basket-list-clear" @click="clearCart()">
        <img :src="require('../assets/trash.png')" alt="Очистить корзину">
        <span>Очистить корзину</span>
      </div>
    </div>
    <div v-else class="conf-basket">
        <h2 class="basket-clear">Корзина пуста</h2>
    </div>
  </div>
</template>

<script>
export default {
  name: "OrderForm",
  data: () => ({
    allWeight: 0,
    allVolume: 0,
    allPack: 0,
    orderInfo: {
      userName: '',
      userPhone: '',
    }
  }),
  props: {
    cart: {
      type: Array,
    }
  },
  methods: {
    addQuantity(item) {
      this.$emit("changeQuantity", {id: item.id, add: true});
    },
    reduceQuantily(item) {
      this.$emit("changeQuantity", {id: item.id, add: false});
    },
    startOver() {
      this.$emit('getStep', 0);
      this.$emit('clearInfo', true);
      this.$emit('clearId');
    },
    dropProduct(item) {
      this.$emit('dropProduct', item.id);
    },
    clearCart() {
      this.$emit('clearCart', true);
    },
    sendOrder() {
      this.$emit('getOrderInfo', this.orderInfo);
    }
  },
  computed: {
    orderVolume() {
      let orderVolume = 0;
      for (let i = 0; i < this.cart.length; i++) {
        orderVolume += this.cart[i].packVolume * this.cart[i].quantity;
      }
      return orderVolume;
    },
    orderWeight() {
      let orderWeight = 0;
      for (let i = 0; i < this.cart.length; i++) {
        orderWeight += this.cart[i].packWeight * this.cart[i].quantity;
      }
      return orderWeight;
    },
    calcBox() {
      let boxQuantity = 0;
      for (let i = 0; i < this.cart.length; i++) {
        boxQuantity += this.cart[i].quantity;
      }
      return boxQuantity;
    }
  }
}
</script>

<style>
h2.basket-clear {
  margin: 0 auto;
  margin-bottom: 40px;
  font-weight: 400;
}

.conf-title.basket {
  margin-top: 10px;
}

.conf-basket {
  display: flex;
  justify-content: space-between;
  position: relative;
}

.conf-basket:after {
  content: "";
  position: absolute;
  width: 1150px;
  height: 4px;
  background: linear-gradient(to right, #A284AF, #8B81D8, #5CB5E2, #AFD374, #FFDE5C, #F5AE5C, #EF7C65);
  bottom: 0;
  left: 50%;
  transform: translate(-50%, -50%);
}

.conf-add-item {
  margin: 30px 0 15px 60px;
  font-weight: 600;
  font-size: 16px;
  line-height: 22px;
  color: var(--color-seven);
  cursor: pointer;
  width: fit-content;
  box-sizing: border-box;
}

.conf-add-item:hover {
  color: #A32209FF;
}

.conf-add-item span {
  font-size: 30px;
  font-weight: 700;
  position: relative;
  top: 5px;
  left: -5px;
}

.basket-table {
  width: 850px;
  height: max-content;
  max-height: 340px;
  padding-right: 20px;
  overflow-y: scroll;
}

.basket-table::-webkit-scrollbar {
  width: 5px;
}

.basket-table::-webkit-scrollbar-track {
  background-color: #eaeaeabf;
  border-radius: 4px;
}

.basket-table::-webkit-scrollbar-thumb {
  background-color: var(--color-seven);
  border-radius: 4px;
}

.basket-list {
  width: 100%;
}

.table-header {
  height: 25px;
}

.table-header td {
  border: 1.5px solid #D9D9D9;
  border-top: 0px;
  padding-left: 10px;
  color: #D9D9D9;
}

.table-header td:first-child {
  border-left: 0px;
}

.table-header td:last-child {
  border-right: 0px;
}

.table-header_name {
  width: 255px;
}

.table-header_pattern {
  width: 120px;
}

.table-header_form-pack {
  width: 90px;
}

.table-header_form-vol {
  width: 95px;
}

.table-header_quality {
  width: 170px;
}

.basket-list-item {
  height: 120px;
}

.basket-list-item td {
  border: 1.5px solid #D9D9D9;
  border-top: 0px;
  padding-left: 10px;
  box-sizing: border-box;
}

.basket-list-item td:first-child {
  border-left: 0px;
}

.basket-list-item td:last-child {
  border-right: 0px;
}

.basket-list-item td img {
  max-width: 100px;
}

.basket-item_info {
  display: inline-block;
}

.basket-item_info span {
  font-weight: 600;
}

.basket-form {
  width: 260px;
  height: 410px;
  position: relative;
  top: -30px;
  padding: 15px 20px;
  border: 3px solid #EAEAEA;
  box-sizing: border-box;
}

.basket-form_title {
  margin-bottom: 10px;
  font-weight: 500;
  font-size: 17px;
  line-height: 27px;
  text-align: center;
  color: #252525;
}

.basket-form ul {
  padding-left: 20px;
}

.basket-form ul li span {
  font-weight: 700;
}

.basket-form_feedback span {
  font-weight: 300;
  font-size: 11px;
  line-height: 15px;
}

.basket-form_feedback .conf-btn {
  margin-top: 10px;
}

.basket-form_feedback input {
  background: #fff !important;
  border: 1px solid #D9D9D9 !important;
  padding: 4px 10px 4px !important;
}

.basket-list-item_quantity {
  text-align: center;
}

.basket-list-item_quantity-td {
  position: relative;
}

.basket-list-item_quantity-text {
  text-align: center;
}

.btn-quantity {
  font-size: 30px;
  position: relative;
  top: 5px;
  cursor: pointer;
}

.input-quantity {
  width: 30px !important;
  height: 20px !important;
  background: #fff !important;
  border: 1px solid #D9D9D9 !important;
  padding: 0 !important;
  border-radius: 0 !important;
  margin: 0 10px;
  text-align: center;
}

.basket-list-item-drop {
  position: absolute;
  top: 17px;
  right: 25px;
  cursor: pointer;
}

.basket-list-item-drop:after, .basket-list-item-drop:before {
  content: '';
  width: 18px;
  height: 2px;
  background: #D9D9D9;
  position: absolute;
  transition: 300ms;
}

.basket-list-item-drop:hover:after, .basket-list-item-drop:hover:before {
  background: var(--color-seven);
  transition: 300ms;
}

.basket-list-item-drop:after {
  transform: rotate(45deg);
}

.basket-list-item-drop:before {
  transform: rotate(-45deg);
}

.basket-list-clear {
  position: absolute;
  bottom: 25px;
  left: 90px;
  cursor: pointer;
  color: #252525;
  transition: 300ms;
}

.basket-list-clear span {
  padding-left: 6px;
  text-decoration: underline;
}

.basket-list-clear:hover span {
  color: var(--color-seven);
  transition: 300ms;
}
</style>
