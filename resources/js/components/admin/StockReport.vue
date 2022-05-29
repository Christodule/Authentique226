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
                        Stock in Hand
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
                            <option v-for="warehouse in warehouses" :value="warehouse.warehouse_id">
                              {{warehouse.warehouse_name}}
                            </option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                          <label>Category</label>

                         <select class="form-control" v-model="category_id">
                            <option value="">all</option>
                            <option v-for="category in product_categories" :value="category.id">
                              {{category.slug.replace(/[^\w\s]/gi, ' ')}}
                            </option>
                          </select>
                      </div>

                      <div class="col-md-3">
                        <label>Product Id</label>
                        <select class="form-control" v-model="product_id">
                            <option value="">all</option>
                            <option v-for="product in products" :value="product.product_id">
                              {{product.detail ? product.detail[0].title : "" }}
                            </option>
                          </select>
                      </div>

                      <div class="col-md-3">
                        <button style="margin-top:20px" class="btn btn-success" @click="fetchStockOnHand('')">Filter</button>
                      </div>
                    </div>
                    <div>
                      <div class="table-responsive" id="printableTable">
                        <div
                          id="productUnitTable_wrapper"
                          class="dataTables_wrapper no-footer"
                        >
                          <div
                            class="dataTables_length"
                            id="productUnitTable_length"
                          >
                            <label
                              >Show
                              <select
                                name="productUnitTable_length"
                                class=""
                                v-model="limit"
                                v-on:change="fetchStockOnHand()"
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
                            id="productUnitTable"
                            class="display dataTable no-footer"
                            role="grid"
                          >
                            <thead class="text-body">
                              <tr role="row">
                                <th
                                  class="sorting"
                                  tabindex="0"
                                  rowspan="1"
                                  colspan="1"
                                  aria-sort="ascending"
                                  aria-label="ID: activate to sort column descending"
                                  style="width: 31.25px"
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
                                  Pid
                                </th>
                                <th
                                  class="sorting"
                                  tabindex="0"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="stock: activate to sort column ascending"
                                  style="width: 95.5288px"
                                >
                                  Product Name
                                </th>
                                <th
                                  class="sorting"
                                  tabindex="0"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Phone No: activate to sort column ascending"
                                  style="width: 81.8109px"
                                >
                                  In Stock
                                </th>
                                <th
                                 
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Out Stock
                                </th>

                                <th
                                  
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Stock On Hand
                                </th>

                                <th
                                  
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Total Value
                                </th>
                              </tr>
                            </thead>
                            <tbody class="kt-table-tbody text-dark">
                              <tr
                                class="kt-table-row kt-table-row-level-0 odd"
                                role="row"
                                v-for="(stock, i) in stocks"
                                v-bind:key="i"
                              >
                                <td class="sorting_1">
                                  {{ stock.product_id }}
                                </td>
                                <td>
                                  {{
                                    stock.product
                                      ? stock.product.detail
                                        ? stock.product.detail[0].title
                                        : ""
                                      : ""
                                  }}
                                </td>
                                <td>
                                  {{ stock.stock_in ? stock.stock_in : 0 }}
                                </td>
                                <td>
                                  {{ stock.stock_out ? stock.stock_out : 0 }}
                                </td>
                                <td>
                                  {{ stock.remaining ? stock.remaining : 0 }}
                                </td>
                                <td>
                                  {{
                                    stock.current_value_simple_product
                                      ? stock.current_value_simple_product
                                          .total_amount
                                      : stock.current_value_variable_product
                                      ? stock.current_value_variable_product
                                          .total_amount
                                      : 0
                                  }}
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
                                  fetchStockOnHand(pagination.prev_page_url)
                                "
                              >
                                Previous
                              </button>
                            </li>

                            <li class="disabled">
                              <a class="page-link text-dark" href="#"
                                >Page {{ pagination.current_page }} of
                                {{ pagination.last_page }}</a
                              >
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
                                  fetchStockOnHand(pagination.next_page_url)
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
import ErrorHandling from "./../../ErrorHandling";
export default {
  data() {
    return {
      sortBy: "id",
      sortType: "ASC",
      limit: 10,
      error_message: "",
      pagination: {},
      stocks: [],
      warehouses: [],
      products: [],
      warehouse_id:"",
      product_id:"",
      category_id:"",
      product_categories: [],
      token: [],
      errors: new ErrorHandling(),
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },

  methods: {
    fetchStockOnHand(page_url) {
      this.$parent.loading = true;
      let vm = this;
      page_url = page_url || "/api/admin/reports/stock-on-hand";
      var arr = page_url.split("?");

      if (arr.length > 1) {
        page_url += "&limit=" + this.limit;
      } else {
        page_url += "?limit=" + this.limit;
      }

      page_url += "&sortBy=" + this.sortBy + "&sortType=" + this.sortType;
      page_url += "&warehouse_id=" + this.warehouse_id + "&category_id=" + this.category_id+"&product_id="+this.product_id;

      var responseData = {};

      axios
        .get(page_url, this.token)
        .then((res) => {
          this.stocks = res.data.data;
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
    fetchProductCategories(page_url) {
      this.$parent.loading = true;
      let vm = this;
      page_url = page_url || "/api/admin/category?getAllData=1";
      axios
        .get(page_url, this.token)
        .then((res) => {
          this.product_categories = res.data.data;
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
    sorting(sortBy) {
      this.sortBy = sortBy;
      this.sortType =
        this.sortType == "asc" || this.sortType == "ASC"
          ? (this.sortType = "desc")
          : (this.sortType = "asc");
      this.fetchStockOnHand("");
    },
  },
  mounted() {
    var token = localStorage.getItem("token");
    this.token = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    };
    this.fetchStockOnHand("");
    this.fetchWarehouses();
    this.fetchProductCategories();
    this.fetchProducts();
  },
};
</script>
