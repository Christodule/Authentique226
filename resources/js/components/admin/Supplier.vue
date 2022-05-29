<template>
<div>
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                                <div class="card-header align-items-center  border-bottom-dark px-0">
                                    <div class="card-title mb-0">
                                        <h3 class="card-label mb-0 font-weight-bold text-body">
                                            Supplier
                                        </h3>
                                    </div>
                                    <div class="icons d-flex">
                                        <button class="btn ml-2 p-0 kt_notes_panel_toggle" data-toggle="tooltip" title="" data-placement="right" data-original-title="Check out more demos" v-if="$parent.permissions.includes('supplier-manage')">
                                            <span class="bg-secondary h-30px font-size-h5 w-30px d-flex align-items-center justify-content-center  rounded-circle shadow-sm " v-on:click="
                                                        display_form = !display_form
                                                    ">
                                                <svg width="25px" height="25px" viewBox="0 0 16 16" class="bi bi-plus white" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <div class="card card-custom gutter-b bg-white border-0">
                                <div class="card-body">
                                    <div>
                                        <div class=" table-responsive" id="printableTable">
                                        
                                            <div id="productUnitTable_wrapper" class="dataTables_wrapper no-footer">

                                            <div class="dataTables_length" id="productUnitTable_length"><label>Show 
                                            <select name="productUnitTable_length"  class="" v-model="limit" v-on:change="fetchsuppliers()">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="500">500</option>
                                            <option value="1000">1000</option>
                                            </select> entries</label></div>

                                            <div id="productUnitTable_filter" class="dataTables_filter">
                                                <label>
                                                    Search:<input type="text" class="" placeholder=""  v-model="searchParameter" @keyup="fetchsuppliers()">
                                                    <button v-if="this.searchParameter != ''" @click="clearSearch">clear</button>
                                                </label>
                                            </div>
                                                <table id="productUnitTable" class="display dataTable no-footer" role="grid">
                                                    <thead class="text-body">
                                                        <tr role="row">
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending" style="width: 31.25px;" @click="sorting('id')" :class="(this.$data.sortType == 'asc' || this.$data.sortType == 'ASC') && this.$data.sortBy == 'id'  ? 'sorting_asc' : (this.$data.sortType == 'desc' || this.$data.sortType == 'DESC') && this.$data.sortBy == 'id' ? 'sorting_desc' : 'sorting'">
                                                                ID
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="supplier: activate to sort column ascending" style="width: 95.5288px;" @click="sorting('first_name')" :class="(this.$data.sortType == 'asc' || this.$data.sortType == 'ASC') && this.$data.sortBy == 'first_name'  ? 'sorting_asc' : (this.$data.sortType == 'desc' || this.$data.sortType == 'DESC') && this.$data.sortBy == 'first_name' ? 'sorting_desc' : 'sorting'">
                                                                First Name
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="Phone No: activate to sort column ascending" style="width: 81.8109px;" :class="(this.$data.sortType == 'asc' || this.$data.sortType == 'ASC') && this.$data.sortBy == 'last_name'  ? 'sorting_asc' : (this.$data.sortType == 'desc' || this.$data.sortType == 'DESC') && this.$data.sortBy == 'last_name' ? 'sorting_desc' : 'sorting'" @click="sorting('last_name')">
                                                                Last Name
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 114.84px;">
                                                                Address
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending" style="width: 158.462px;">
                                                                Phone #
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="No Of Product: activate to sort column ascending" style="width: 108.67px;">
                                                                Mobile
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="Stock Quantity: activate to sort column ascending" style="width: 112.917px;">
                                                                Country
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="Stock Quantity: activate to sort column ascending" style="width: 112.917px;">
                                                                State
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-label="Stock Quantity: activate to sort column ascending" style="width: 112.917px;">
                                                                City
                                                            </th>
                                                            <th v-if="$parent.permissions.includes('supplier-manage')" class="no-sort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" style="width: 53.1891px;">
                                                                Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="kt-table-tbody text-dark">
                                                        <tr class="kt-table-row kt-table-row-level-0 odd" role="row" v-for="supplier in suppliers" v-bind:key="supplier.supplier_id">
                                                            <td class="sorting_1">
                                                                {{supplier.supplier_id}}
                                                            </td>
                                                            <td>
                                                                {{ supplier.supplier_first_name }}
                                                            </td>
                                                            <td>
                                                                {{ supplier.supplier_last_name }}
                                                            </td>
                                                            <td>
                                                                {{ supplier.supplier_address }}
                                                            </td>
                                                            <td>
                                                                {{ supplier.supplier_phone }}
                                                            </td>
                                                            <td>
                                                                {{ supplier.supplier_mobile}}
                                                            </td>
                                                            <td>
                                                                {{ supplier.country.country_name}}
                                                            </td>
                                                            <td>
                                                                {{ supplier.state.name}}
                                                            </td>
                                                            <td>
                                                                {{ supplier.supplier_city}}
                                                            </td>
                                                            <td v-if="$parent.permissions.includes('supplier-manage')">
                                                            <a href="javascript:void(0)" class=" click-edit" id="click-edit1" data-toggle="tooltip" title="" data-placement="right" data-original-title="Check out more demos" @click="editsupplier(supplier)"><i class="fa fa-edit"></i></a>
                                                                        <a class="" href="#" @click="deletesupplier(supplier.supplier_id)"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <ul class="pagination pagination-sm m-0 float-right">
                                                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]"><button class="page-link" href="#" @click="fetchsuppliers(pagination.prev_page_url)">Previous</button></li>

                                                    <li class="disabled"><button class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</button></li>

                                                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><button class="page-link" href="#" @click="fetchsuppliers(pagination.next_page_url)">Next</button></li>
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

    <div class="offcanvas offcanvas-right kt-color-panel p-5 kt_notes_panel" v-if="display_form" :class="display_form ? 'offcanvas-on' : ''">
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
            <h4 class="font-size-h4 font-weight-bold m-0">Add supplier</h4>
            <a href="#" class="btn btn-sm btn-icon btn-light btn-hover-primary kt_notes_panel_close" v-on:click="display_form = 0">
                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
            </a>
        </div>
        <form id="myform">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="text-dark">First Name </label>
                        <input type="text" name="text" v-model="supplier.first_name" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('first_name')" v-text="errors.get('first_name')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">Last Name </label>
                        <input type="text" name="text" v-model="supplier.last_name" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('last_name')" v-text="errors.get('last_name')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">Address </label>
                        <input type="text" name="text" v-model="supplier.address" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('address')" v-text="errors.get('address')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">Phone </label>
                        <input type="text" name="text" v-model="supplier.phone" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('phone')" v-text="errors.get('phone')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">Mobile </label>
                        <input type="text" name="text" v-model="supplier.mobile" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('mobile')" v-text="errors.get('mobile')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">Country </label>
                        <select v-model="supplier.country_id" @change="fetchStatesByCountryID(supplier.country_id)">
                        <option value="">Select Country</option>
                        <option v-for="country in countries" v-bind:value="country.country_id">
                        {{ country.country_name }}
                        </option>
                        </select>
                        <small class="form-text text-danger" v-if="errors.has('country_id')" v-text="errors.get('country_id')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">State </label>
                        <select v-model="supplier.state_id">
                        <option value="">Select State</option>
                        <option v-for="state in states" v-bind:value="state.id">
                        {{ state.name }}
                        </option>
                        </select>
                        <small class="form-text text-danger" v-if="errors.has('state_id')" v-text="errors.get('state_id')"></small>
                    </div>

                  

                    <div class="form-group">
                        <label class="text-dark">City </label>
                        <input type="text" name="text" v-model="supplier.city" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('city')" v-text="errors.get('city')"></small>
                    </div>



                </div>
            </div>
            <button type="button" @click="addUpdatesupplier()" class="btn btn-primary">Submit</button>
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
            supplier: {
                id: "",
                first_name: "",
                last_name: "",
                address: "",
                phone: "",
                mobile: "",
                country_id: "",
                state_id: "",
                city: "",
            },
            searchParameter: '',
            sortBy: 'id',
            sortType: 'ASC',
            limit: 10,
            error_message: '',
            edit: false,
            actions: false,
            pagination: {},
            request_method: "",
            countrySelected: "",
            stateSelected: "",
            suppliers: [],
            countries: [],
            states: [],
            token: [],
            errors: new ErrorHandling(),
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        };
    },

    methods: {
        fetchCountries() {
            this.$parent.loading = true;
            var token = localStorage.getItem('token');
            const config = {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            };
            var responseData = {};

            axios.get('/api/admin/country?getAllData=1', config)
                .then(res => {
                    if (res.data.status == "Success") {
                        this.countries = res.data.data;
                    }
                }).finally(() => (this.$parent.loading = false));
        },
        fetchStatesByCountryID(country_id) {
            this.$parent.loading = true;
            var token = localStorage.getItem('token');
            const config = {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            };
            var responseData = {};

            if(country_id == null){
                return;
            }

            axios.get('/api/admin/country/'+country_id+'?getStates=1', config)
                .then(res => {
                    if (res.data.status == "Success") {
                        this.states = res.data.data.states;
                    }
                }).finally(() => (this.$parent.loading = false));
        },
        fetchsuppliers(page_url) {
            this.$parent.loading = true;
            let vm = this;
            page_url = page_url || "/api/admin/supplier";
            var arr = page_url.split('?');
            
            if (arr.length > 1) {
                page_url += '&limit='+this.limit;
            }
            else{
                page_url += '?limit='+this.limit;
            }
            if(this.searchParameter != null){
                page_url += '&searchParameter='+this.searchParameter;
            }
            page_url += '&sortBy='+this.sortBy+'&sortType='+this.sortType+'&getCountry=1&getState=1';
            var responseData = {};

            axios.get(page_url, this.token).then(res => {
                this.suppliers = res.data.data;
                vm.makePagination(res.data.meta, res.data.links);
            }).finally(() => (this.$parent.loading = false));
        },

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };

            this.pagination = pagination;
        },
        deletesupplier(id) {
            if (confirm('Are You Sure?')) {
                this.$parent.loading = true;
                axios.delete(`/api/admin/supplier/${id}`,this.token)
                    .then(res => {
                        if (res.data.status == "Success") {
                            this.$toaster.success(res.data.message)
                            this.fetchsuppliers();
                        }

                    })
                    .catch(err => console.log(err))
                    .finally(() => (this.$parent.loading = false));
            }
        },
        addUpdatesupplier() {
            this.$parent.loading = true;
            var url = '/api/admin/supplier';
            if (this.edit === false) {
                // Add
                this.request_method = 'post'
            } else {
                // Update
                var url = '/api/admin/supplier/' + this.supplier.id;
                this.request_method = 'put'
            }
            axios[this.request_method](url, this.supplier, this.token)
                .then(res => {
                    if (res.data.status == "Success") {
                        this.display_form = 0;
                        this.$toaster.success(res.data.message)
                        this.clearForm();
                        this.fetchsuppliers();
                    } else {
                        this.$toaster.error(res.data.message)
                    }
                })
                .catch(error => {
					this.error_message = '';
					this.errors = new ErrorHandling();
					if (error.response.status == 422) {
						if(error.response.data.status == 'Error'){
							this.error_message = error.response.data.message;
						}
						else{
							this.errors.record(error.response.data.errors);
						}
					}
				}).finally(() => (this.$parent.loading = false));

        },
        editsupplier(supplier) {
            this.edit = true;
            this.display_form = 1;
            this.errors = new ErrorHandling();
            this.supplier.id = supplier.supplier_id;
            this.supplier.first_name = supplier.supplier_first_name;
            this.supplier.last_name = supplier.supplier_last_name;
            this.supplier.address = supplier.supplier_address;
            this.supplier.phone = supplier.supplier_phone;
            this.supplier.mobile = supplier.supplier_mobile;
            this.supplier.country_id = supplier.country.country_id;
            this.supplier.state_id = supplier.state.id;
            this.supplier.city = supplier.supplier_city;
        },
        clearForm() {
            this.edit = false;
            this.supplier.id = null;
            this.supplier.first_name = '';
            this.supplier.last_name = '';
            this.supplier.address = '';
            this.supplier.phone = '';
            this.supplier.mobile = '';
            this.supplier.country_id = '';
            this.supplier.state_id = '';
            this.supplier.city = '';
            },
            sorting(sortBy){
                this.sortBy = sortBy;
                this.sortType = this.sortType == 'asc' || this.sortType == 'ASC' ? this.sortType='desc' : this.sortType = 'asc';
                this.fetchsuppliers();
            },
            clearSearch(){
            this.searchParameter = "",
            this.fetchsuppliers();
        }
    },
    mounted() {
        
        var token = localStorage.getItem('token');
        this.token = {
            headers: {
                Authorization: `Bearer ${token}`
            }
        };
        this.fetchCountries();
        this.fetchsuppliers();
    }
};
</script>
