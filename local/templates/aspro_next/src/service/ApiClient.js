import axios from "axios";
// import jsonToFormData from "json-form-data";

export default class ApiClient {
  constructor() {
    this.client = axios.create({
      baseURL: '/api'
    });
  }

  getGladyeByCategory(category) {
    return this.call(
      '/configurator/gladye/getByCategory/',
      {
        method: 'post',
        data: {
          category,
        }
      }
    );
  }

  getProduct(data) {
    return this.client(
      '/configurator/catalog/getProduct/',
      {
        method: 'post',
        data,
      }
    );
  }

  getSets(data) {
    return this.client(
      '/configurator/catalog/getSetsByForm/',
      {
        method: 'post',
        data,
      }
    );
  }

  getCategoriesByPackSection(data) {
    return this.client(
      '/configurator/catalog/getCategoriesByPackSection/',
      {
        method: 'post',
        data,
      }
    );
  }

  getFormByProductSectionAndPack(data) {
    return this.client(
      '/configurator/catalog/getFormByProductSectionAndPack/',
      {
        method: 'post',
        data,
      }
    );
  }

  getCategoriesWithSets(data) {
    return this.client(
      '/configurator/catalog/getCategoriesWithSets/',
      {
        method: 'post',
        data,
      }
    );
  }

  sendOrderInfo(data) {
    return this.client(
      '/configurator/order/handle/',
      {
        method: 'post',
        data,
      }
    );
  }

  /**
   *
   * @param url
   * @param payload
   * @returns {{error: {}}|AxiosPromise}
   */
  async call(url, payload) {
    const {
      data: {
        data: data = {},
        message: message = null,
        errors: errors = {},
      } = {},
    } = await this.client(url, payload);

    if (errors.length > 0) {
      return {errors, success: false};
    }

    if (message) {
      return {message, success: false};
    }

    return data;
  }
}
