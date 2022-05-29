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
                        Expense Report
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
                                v-on:change="expenseReports()"
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
                            <!-- <label>Search:<input type="search" class="" placeholder="" aria-controls="sale" v-model="searchParameter" @keyup="expenseReports()"></label> -->
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
                                  Detail
                                </th>
                                <th
                                  class="no-sort sorting_disabled"
                                  rowspan="1"
                                  colspan="1"
                                  aria-label="Action"
                                  style="width: 53.1891px"
                                >
                                  Expense Amount
                                </th>
                              </tr>
                            </thead>
                            <tbody class="kt-table-tbody text-dark">
                              <tr
                                class="kt-table-row kt-table-row-level-0 odd"
                                sale="row"
                                v-for="(expense, i) in expenses"
                                v-bind:key="i"
                              >
                                <td>
                                  {{ expense.description }}
                                </td>
                                <td>
                                  {{ expense.amount }}
                                </td>
                                <input
                                  type="hidden"
                                  :set="
                                    (totel_amount =
                                      parseFloat(totel_amount) +
                                      parseFloat(expense.amount))
                                  "
                                />
                              </tr>
                              <tr>
                                <td>Totel Expense</td>
                                <td>
                                  {{
                                    expenses.reduce(function (total, item) {
                                      return total + parseFloat(item.amount);
                                    }, 0)
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
                                  expenseReports(pagination.prev_page_url)
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
                                  expenseReports(pagination.next_page_url)
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
      expenses: [],
      totel_amount: 0,
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

      errors: new ErrorHandling(),
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },

  methods: {
    expenseReports(page_url) {
      this.$parent.loading = true;
      let vm = this;
      page_url = page_url || "/api/admin/reports/expense-report";
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
          this.expenses = res.data.data;
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
  },
  mounted() {
    var token = localStorage.getItem("token");
    this.token = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    };
    this.expenseReports();
  },
  props: ["loading"],
};
</script>
