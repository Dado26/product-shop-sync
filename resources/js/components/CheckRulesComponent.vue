<template>
  <div class="card shadow mb-4" id="test-rules">
    <div class="card-header">Test Rules</div>

    <div class="card-body">
      <div class="d-flex form-inline navbar-search mb-2">
        <div class="input-group w-75">
          <div class="input-group-prepend">
            <span class="input-group-text">URL:</span>
          </div>
          <input
            type="text"
            v-model="testUrl"
            class="form-control border"
            placeholder="https://shop.com/product/73625"
          />
        </div>

        <button
          type="button"
          id="check-rules-btn"
          class="btn btn-primary shadow-sm w-auto ml-3"
          @click="loadResults"
          :disabled="!testUrl"
        >Check Rules</button>
      </div>

      <!-- SPINNER -->
      <div class="text-center mt-5 mb-4" v-if="requestPending">
        <div class="spinner"></div>
      </div>

      <!-- RESULTS -->
      <div class="results-container" v-if="resultsLoaded">
        <hr />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group title">
              <label class="control-label">Title</label>
              <div class="form-control text-truncate" :class="{'invalid-rule': results.title === null}">{{ results.title }}</div>
            </div>

            <div class="form-group description">
              <label class="control-label">Description</label>
              <div class="form-control multiline" :class="{'invalid-rule': results.description === null}">{{ results.description }}</div>
            </div>

            <div class="form-group price">
              <label class="control-label">Price</label>
              <div class="form-control" :class="{'invalid-rule': results.price === null}">{{ results.price }}</div>
            </div>

            <div class="form-group price-modification">
              <label class="control-label">Price Modification</label>
              <div class="form-control" :class="{'invalid-rule': results.price_modification === null}">{{ results.price_modification }}</div>
            </div>

            <div class="form-group in-stock-value">
              <label class="control-label">In stock value</label>
              <div class="form-control" :class="{'invalid-rule': results.in_stock_value === null}">{{ results.in_stock_value }}</div>
            </div>

            <div class="form-group variants">
              <label class="control-label">Variants</label>
              <div class="variants-container" :class="{'invalid-rule': results.variants.length === 0}">
                  <ol class="d-block">
                      <li v-for="(variant, index) in results.variants" :key="'variant-'+index">{{ variant }}</li>
                  </ol>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group images">
              <label class="control-label">Images</label>
              <div class="images-container" :class="{'invalid-rule': results.images.length === 0}">
                  <img :src="image" class="img-fluid w-50" v-for="(image, index) in results.images" :key="'images-'+index">
              </div>
            </div>
          </div>

          <div class="form-group col specifications">
            <label class="control-label">Specifications</label>
            <div class="form-control" v-html="results.specifications"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      results: null,
      testUrl: null,
      requestPending: false,
      resultsLoaded: false
    };
  },
  methods: {
    loadResults() {
       const params = {
            url: this.testUrl,
            price_modification: document.querySelector('input[name="sites[price_modification]"]').value,
            rules: {
                title: document.querySelector('input[name="sync_Rules[title]"]').value,
                description: document.querySelector('input[name="sync_Rules[description]"]').value,
                specifications: document.querySelector('input[name="sync_Rules[specifications]"]').value,
                price: document.querySelector('input[name="sync_Rules[price]"]').value,
                in_stock: document.querySelector('input[name="sync_Rules[in_stock]"]').value,
                in_stock_value: document.querySelector('input[name="sync_Rules[in_stock_value]"]').value,
                price_decimals: document.querySelector('input[name="sync_Rules[price_decimals]"]').value,
                images: document.querySelector('input[name="sync_Rules[images]"]').value,
                variants: document.querySelector('input[name="sync_Rules[variants]"]').value,
            },
        };

    //   const params = {
    //     url: "http://product-sync/test/product",
    //     rules: {
    //       title: "#product-title",
    //       description: ".product-description",
    //       specifications: "#product-specs",
    //       price: ".product-price",
    //       in_stock: ".product-stock",
    //       price_decimals: "2",
    //       images: ".product-images > img",
    //       variants: ".variants > .color"
    //     }
    //   };

      // show spinner & hide results
      this.requestPending = true;
      this.resultsLoaded = false;

      // make ajax request
      axios
        .post("/api/sites/test-rules", params)
        .then(response => {
          // show results on success
          this.resultsLoaded = true;

          this.results = response.data;
        })
        .catch(error => {
          // hide results on server error
          this.resultsLoaded = false;

          alert("Whoops, something went wrong...");
          console.error(error);
        })
        .finally(() => {
          // always hide spinner after request has finished
          this.requestPending = false;
        });
    }
  }
};
</script>
