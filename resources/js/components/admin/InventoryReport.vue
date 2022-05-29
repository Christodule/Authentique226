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
                        Stock History
                      </h3>
                    </div>
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
                        <label>Type</label>
                        <select class="form-control" v-model="stock_type">
                          <option value="">all</option>
                          <option value="StockAdjustment">
                            Stock Adjustment
                          </option>
                          <option value="Purchase">Purchase</option>
                          <option value="Order">Order</option>
                          <option value="StockTransfer">StockTransfer</option>
                          <option value="PurchaseReturn">
                            Purchase Return
                          </option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <button
                          style="margin-top: 20px"
                          class="btn btn-success"
                          @click="fetchstocks('')"
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
                                class=""
                                v-model="limit"
                                v-on:change="fetchstocks()"
                              >
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                              </select>
                              entries</label
                            >
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
                                  @click="sorting('id')"
                                  :class="
                                    (this.$data.sortType == 'asc' ||
                                      this.$data.sortType == 'ASC') &&
                                    this.$data.sortBy == 'id'
                                      ? 'sorting_asc'
                                      : (this.$data.sortType == 'desc' ||
                                          this.$data.sortType == 'DESC') &&
                                        this.$data.sortBy == 'id'
                                      ? 'sorting_desc'
                                      : 'sorting'
                                  "
                                >
                                  ID
                                </th>

                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                  @click="sorting('created_at')"
                                  :class="
                                    (this.$data.sortType == 'asc' ||
                                      this.$data.sortType == 'ASC') &&
                                    this.$data.sortBy == 'created_at'
                                      ? 'sorting_asc'
                                      : (this.$data.sortType == 'desc' ||
                                          this.$data.sortType == 'DESC') &&
                                        this.$data.sortBy == 'created_at'
                                      ? 'sorting_desc'
                                      : 'sorting'
                                  "
                                >
                                  Created At
                                </th>
                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                  @click="sorting('product_id')"
                                  :class="
                                    (this.$data.sortType == 'asc' ||
                                      this.$data.sortType == 'ASC') &&
                                    this.$data.sortBy == 'product_id'
                                      ? 'sorting_asc'
                                      : (this.$data.sortType == 'desc' ||
                                          this.$data.sortType == 'DESC') &&
                                        this.$data.sortBy == 'product_id'
                                      ? 'sorting_desc'
                                      : 'sorting'
                                  "
                                >
                                  Product
                                </th>
                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                  @click="sorting('warehouse_id')"
                                  :class="
                                    (this.$data.sortType == 'asc' ||
                                      this.$data.sortType == 'ASC') &&
                                    this.$data.sortBy == 'warehouse_id'
                                      ? 'sorting_asc'
                                      : (this.$data.sortType == 'desc' ||
                                          this.$data.sortType == 'DESC') &&
                                        this.$data.sortBy == 'warehouse_id'
                                      ? 'sorting_desc'
                                      : 'sorting'
                                  "
                                >
                                  Warehouse
                                </th>

                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                  @click="sorting('stock_status')"
                                  :class="
                                    (this.$data.sortType == 'asc' ||
                                      this.$data.sortType == 'ASC') &&
                                    this.$data.sortBy == 'stock_status'
                                      ? 'sorting_asc'
                                      : (this.$data.sortType == 'desc' ||
                                          this.$data.sortType == 'DESC') &&
                                        this.$data.sortBy == 'stock_status'
                                      ? 'sorting_desc'
                                      : 'sorting'
                                  "
                                >
                                  Status
                                </th>

                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                  @click="sorting('qty')"
                                  :class="
                                    (this.$data.sortType == 'asc' ||
                                      this.$data.sortType == 'ASC') &&
                                    this.$data.sortBy == 'qty'
                                      ? 'sorting_asc'
                                      : (this.$data.sortType == 'desc' ||
                                          this.$data.sortType == 'DESC') &&
                                        this.$data.sortBy == 'qty'
                                      ? 'sorting_desc'
                                      : 'sorting'
                                  "
                                >
                                  Quantity
                                </th>

                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Type/Reason
                                </th>
                              </tr>
                            </thead>
                            <tbody class="kt-table-tbody text-dark">
                              <tr
                                class="kt-table-row kt-table-row-level-0 odd"
                                sale="row"
                                v-for="stock in stocks"
                                v-bind:key="stock.id"
                              >
                                <td>
                                  {{ stock.id }}
                                </td>
                                <td>
                                  {{ stock.created_at }}
                                </td>

                                <td>
                                  <router-link
                                    :to="'/admin/product/' + stock.product_id"
                                    >{{
                                      stock.product.detail.length > 0
                                        ? stock.product.detail[0].title
                                        : ""
                                    }}</router-link
                                  >
                                </td>
                                <td>
                                  {{ stock.warehouse.warehouse_name }}
                                </td>

                                <!-- <td v-if="stock.product.product_type == 'variable'">
                                                                 
                                                                     <span v-for="(combinationdtl,i) in stock.product.combination_detail" v-bind:key="i">
                                                                         <span v-for="(variation,j) in combinationdtl.combination" v-bind:key="j">
                                                                             {{ variation.detail[0].name }}
                                                                         </span>
                                                                     </span>
                                                                
                                                            </td> -->

                                <td>
                                  {{ stock.stock_status }}
                                </td>
                                <td>
                                  {{ stock.qty }}
                                </td>
                                <td>
                                  {{ stock.stock_type }}
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
                                @click="fetchstocks(pagination.prev_page_url)"
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
                                @click="fetchstocks(pagination.next_page_url)"
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

    <div
      class="offcanvas offcanvas-right kt-color-panel p-5 kt_notes_panel"
      v-if="display_form"
      :class="display_form ? 'offcanvas-on' : ''"
    >
      <div
        class="
          offcanvas-header
          d-flex
          align-items-center
          justify-content-between
          pb-3
        "
      >
        <h4 class="font-size-h4 font-weight-bold m-0">Add sale</h4>
        <a
          href="#"
          class="
            btn btn-sm btn-icon btn-light btn-hover-primary
            kt_notes_panel_close
          "
          v-on:click="display_form = 0"
        >
          <svg
            width="20px"
            height="20px"
            viewBox="0 0 16 16"
            class="bi bi-x"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
            ></path>
          </svg>
        </a>
      </div>
      <form id="myform">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="text-dark">Name </label>
              <input
                type="text"
                name="text"
                v-model="stock.name"
                class="form-control"
              />
              <small
                class="form-text text-danger"
                v-if="errors.has('name')"
                v-text="errors.get('name')"
              ></small>
            </div>
            <div class="form-group">
              <label class="text-dark">Direction </label>
              <select v-model="stock.direction">
                <option value="ltr">LTR</option>
                <option value="rtl">RTL</option>
              </select>
              <small
                class="form-text text-danger"
                v-if="errors.has('direction')"
                v-text="errors.get('direction')"
              ></small>
            </div>
            <div class="form-group">
              <label class="text-dark">Code </label>
              <input
                type="text"
                name="text"
                v-model="stock.code"
                class="form-control"
              />
              <small
                class="form-text text-danger"
                v-if="errors.has('code')"
                v-text="errors.get('code')"
              ></small>
            </div>
            <div class="form-group">
              <label class="text-dark">Directory </label>
              <input
                type="text"
                name="text"
                v-model="stock.directory"
                class="form-control"
              />
              <small
                class="form-text text-danger"
                v-if="errors.has('directory')"
                v-text="errors.get('directory')"
              ></small>
            </div>
            <div class="form-group">
              <input
                type="checkbox"
                name="text"
                v-model="stock.is_default"
                id="is_default"
                class="form-check-input"
              />
              <label class="text-dark" for="is_default">Set as default </label>
              <small
                class="form-text text-danger"
                v-if="errors.has('is_default')"
                v-text="errors.get('is_default')"
              ></small>
            </div>
          </div>
        </div>
        <button type="button" @click="addUpdatesale()" class="btn btn-primary">
          Submit
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import ErrorHandling from "../../ErrorHandling";
export default {
  data() {
    return {
      display_form: 0,
      stocks: [],
      searchParameter: "",
      sortBy: "id",
      sortType: "DESC",
      limit: 10,
      error_message: "",
      edit: false,
      actions: false,
      pagination: {},
      request_method: "",
      is_default: "0",
      token: [],
      stock_type: "",
      errors: new ErrorHandling(),
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },

  methods: {
    fetchstocks(page_url) {
      this.$parent.loading = true;
      let vm = this;
      page_url = page_url || "/api/admin/stock";
      var arr = page_url.split("?");

      if (arr.length > 1) {
        page_url += "&limit=" + this.limit;
      } else {
        page_url += "?limit=" + this.limit;
      }
      if (this.searchParameter != null) {
        page_url += "&searchParameter=" + this.searchParameter;
      }
      page_url += "&sortBy=" + this.sortBy + "&sortType=" + this.sortType;
      page_url += "&getProduct=1&getWarehouse=1&getProduct=1";
      page_url += "&stockType=" + this.stock_type;

      var responseData = {};

      axios
        .get(page_url, this.token)
        .then((res) => {
          this.stocks = res.data.data;
          vm.makePagination(res.data.meta, res.data.links);
        })
        .finally(() => (this.$parent.loading = false));
    },

    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
      };

      this.pagination = pagination;
    },
    productNameBasedOnType(stock) {
      if (stock.product.product_type === "simple") {
        return stock.product.detail[0].title;
      }
      if (stock.product.product_type === "variable") {
        var nameToReturn = stock.product.detail[0].title + "(";
        stock.product.combination_detail.forEach((element, i) => {
          if (element.product_combination_id == stock.product_combination_id) {
            element.combination.forEach((result, j) => {
              nameToReturn += result.variation.detail[0].name;
              if (element.combination.length != j + 1) {
                nameToReturn += ",";
              }
            });
          }
        });
        nameToReturn += ")";
        return nameToReturn;
      }
    },
    sorting(sortBy) {
      this.sortBy = sortBy;
      this.sortType =
        this.sortType == "asc" || this.sortType == "ASC"
          ? (this.sortType = "desc")
          : (this.sortType = "asc");
      this.fetchstocks();
    },
    clearSearch() {
      (this.searchParameter = ""), this.fetchstocks();
    },
  },
  mounted() {
    var token = localStorage.getItem("token");
    this.token = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    };
    this.fetchstocks();
  },
  props: ["loading"],
};
</script>
