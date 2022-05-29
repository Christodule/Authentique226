<template>
  <div>
    <div class="d-flex flex-column-fluid">
      <!--begin::Container-->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-lg-12 col-xl-12">
                <div
                  class="
                    card card-custom
                    gutter-b
                    bg-transparent
                    shadow-none
                    border-0
                  "
                >
                  <div
                    class="
                      card-header
                      align-items-center
                      border-bottom-dark
                      px-0
                    "
                  >
                    <div class="card-title mb-0">
                      <h3 class="card-label mb-0 font-weight-bold text-body">
                        Purchase Report
                      </h3>
                    </div>
                    <div class="icons d-flex"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-custom gutter-b bg-white border-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Warehouse Id</label>
                          <select class="form-control" v-model="warehouse_id">
                            <option value="">all</option>
                            <option
                              v-for="warehouse in warehouses"
                              :value="warehouse.warehouse_id"
                            >
                              {{ warehouse.warehouse_name }}
                            </option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <label>Product Id</label>
                        <select class="form-control" v-model="product_id">
                          <option value="">all</option>
                          <option
                            v-for="product in products"
                            :value="product.product_id"
                          >
                            {{ product.detail ? product.detail[0].title : "" }}
                          </option>
                        </select>
                      </div>

                      <div class="col-md-3">
                        <button
                          style="margin-top: 20px"
                          class="btn btn-success"
                          @click="purchasReports('')"
                        >
                          Filter
                        </button>
                      </div>
                    </div>
                    <div>
                      <div class="table-responsive" id="printableTable">
                        <div
                          id="sale_wrapper"
                          class="dataTables_wrapper no-footer"
                        >
                          <div class="dataTables_length" id="sale_length">
                            <label
                              >Show
                              <select
                                name="sale_length"
                                aria-controls="sale"
                                class=""
                                v-model="limit"
                                v-on:change="purchasReports()"
                              >
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                              </select>
                              entries</label
                            >
                          </div>

                          <div id="sale_filter" class="dataTables_filter">
                            <!-- <label>Search:<input type="search" class="" placeholder="" aria-controls="sale" v-model="searchParameter" @keyup="purchasReports()"></label> -->
                          </div>
                          <table
                            id="sale"
                            class="display dataTable no-footer"
                            sale="grid"
                          >
                            <thead class="text-body">
                              <tr sale="row">
                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Product
                                </th>
                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Purchase Amount
                                </th>
                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Purchase Qty
                                </th>
                                
                              </tr>
                            </thead>
                            <tbody class="kt-table-tbody text-dark">
                              <tr
                                class="kt-table-row kt-table-row-level-0 odd"
                                sale="row"
                                v-for="(purchase,i) in purchases"
                                v-bind:key="i"
                              >
                                <td>
                                  {{ purchase.product.detail ? purchase.product.detail[0].title : "" }}
                                </td>
                                <td>
                                  {{ purchase.price}}
                                </td>
                                <td>
                                  {{ purchase.qty}}
                                </td>                               
                              </tr>
                            </tbody>
                          </table>
                          <ul class="pagination pagination-sm m-0 float-right">
                            <li
                              v-bind:class="[
                                { disabled: !pagination.prev_page_url },
                              ]"
                            >
                              <button
                                class="page-link"
                                href="#"
                                @click="
                                  purchasReports(pagination.prev_page_url)
                                "
                              >
                                Previous
                              </button>
                            </li>

                            <li class="disabled">
                              <button class="page-link text-dark" href="#">
                                Page {{ pagination.current_page }} of
                                {{ pagination.last_page }}
                              </button>
                            </li>

                            <li
                              v-bind:class="[
                                { disabled: !pagination.next_page_url },
                              ]"
                              class="page-item"
                            >
                              <button
                                class="page-link"
                                href="#"
                                @click="
                                  purchasReports(pagination.next_page_url)
                                "
                              >
                                Next
                              </button>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ErrorHandling from "../../ErrorHandling";
export default {
  data() {
    return {
      purchases: [],
      searchParameter: "",
      sortBy: "id",
      sortType: "ASC",
      limit: 10,
      error_message: "",
      edit: false,
      actions: false,
      pagination: {},
      request_method: "",
      is_default: "0",
      token: [],
      product_id: "",
      warehouse_id: "",
      warehouses: [],
      products: [],
      errors: new ErrorHandling(),
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },

  methods: {
    purchasReports(page_url) {
      this.$parent.loading = true;
      let vm = this;
      page_url = page_url || "/api/admin/reports/purchase-report";
      var arr = page_url.split("?");

      if (arr.length > 1) {
        page_url += "&limit=" + this.limit;
      } else {
        page_url += "?limit=" + this.limit;
      }
      page_url +=
        "&warehouse_id=" + this.warehouse_id + "&product_id=" + this.product_id;

      var responseData = {};

      axios
        .get(page_url, this.token)
        .then((res) => {
          this.purchases = res.data.data;
          vm.makePagination(res.data, res.data.links);
        })
        .finally(() => (this.$parent.loading = false));
    },

    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: meta.next_page_url,
        prev_page_url: meta.prev_page_url,
      };

      this.pagination = pagination;
    },
    productNameBasedOnType(purchase) {
      // console.log(purchase);

      if (purchase.detail[0].product.product_type === "simple") {
        return purchase.detail[0].product.detail[0].title;
      }
      if (purchase.detail[0].product.product_type === "variable") {
        var nameToReturn =
          purchase.detail[0].product.detail[0].title + "(";

        purchase.detail[0].product.combination_detail.forEach(
          (element, i) => {
            if (
              element.product_combination_id ==
              purchase.detail[0].product_combination
                .product_combination_id
            ) {
              element.combination.forEach((result, j) => {
                nameToReturn += result.variation.detail[0].name;
                if (element.combination.length != j + 1) {
                  nameToReturn += ",";
                }
              });
            }
          }
        );
        nameToReturn += ")";
        return nameToReturn;
      }

      // return "working";
    },
    fetchWarehouses(page_url) {
      this.$parent.loading = true;
      let vm = this;
      page_url = page_url || "/api/admin/warehouse?getAllData=1";
      axios
        .get(page_url, this.token)
        .then((res) => {
          this.warehouses = res.data.data;
        })
        .finally(() => (this.$parent.loading = false));
    },
    fetchProducts(page_url) {
      this.$parent.loading = true;
      let vm = this;
      page_url = page_url || "/api/admin/product?getAllData=1";

      axios
        .get(page_url, this.token)
        .then((res) => {
          this.products = res.data.data;
        })
        .finally(() => (this.$parent.loading = false));
    },
  },
  mounted() {
    var token = localStorage.getItem("token");
    this.token = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    };
    this.purchasReports();
    this.fetchWarehouses();
    this.fetchProducts();
  },
  props: ["loading"],
};
</script>
