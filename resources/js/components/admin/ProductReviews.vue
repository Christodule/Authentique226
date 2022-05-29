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
                                            Product Reviews
                                        </h3>
                                    </div>
                                    <div class="icons d-flex">
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
                                        
                                            <div id="productreviewTable_wrapper" class="dataTables_wrapper no-footer">

                                            <div class="dataTables_length" id="productreviewTable_length"><label>Show 
                                            <select name="productreviewTable_length"  class="" v-model="limit" v-on:change="fetchreviews()">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="500">500</option>
                                            <option value="1000">1000</option>
                                            </select> entries</label></div>

                                            <div id="productreviewTable_filter" class="dataTables_filter">
                                                <label>Search:<input type="text" class="" placeholder=""  v-model="searchParameter" @keyup="fetchreviews()"></label>
                                                <button v-if="this.searchParameter != ''" @click="clearSearch">clear</button>

                                            </div>
                                                <table id="productreviewTable" class="display dataTable no-footer" role="grid">
                                                    <thead class="text-body">
                                                        <tr role="row">
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending">
                                                                id
                                                            </th>
                                                            <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending">
                                                                Customer Review
                                                            </th>
                                                           <th class="sorting" tabindex="0"  rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending">
                                                                Customer Email
                                                            </th>
                                                            <th class="no-sort sorting_disabled" rowspan="1" colspan="1">
                                                                Customer Name
                                                            </th>
                                                            <th class="no-sort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" >
                                                                Rating
                                                            </th>
                                                            <th class="no-sort sorting_disabled" rowspan="1" colspan="1">
                                                                Product name
                                                            </th>

                                                            <th class="no-sort sorting_disabled" rowspan="1" colspan="1">
                                                                Status
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="kt-table-tbody text-dark">
                                                        <tr class="kt-table-row kt-table-row-level-0 odd" role="row" v-for="review in reviews" v-bind:key="review.id">
                                                            <td class="sorting_1">
                                                                {{review.id}}
                                                            </td>
                                                            <td>
                                                                {{ review.comment }}
                                                            </td>
                                                            <td class="sorting_1">
                                                                {{review.customer ? review.customer.customer_email : ""}}
                                                            </td>
                                                            <td>
                                                                {{ review.customer ? review.customer.customer_first_name +' '+ review.customer.customer_last_name : "" }}
                                                            </td>
                                                            

                                                            <td class="sorting_1">
                                                                {{review.rating}}
                                                            </td>

                                                            <td class="sorting_1">
                                                                {{review.product ? review.product.detail[0].title : ""}}
                                                            </td>

                                                            <td class="sorting_1">
                                                                {{review.status}}
                                                            </td>
                                                            <td>
                                                            <a href="javascript:void(0)" class=" click-edit" id="click-edit1" data-toggle="tooltip" title="" data-placement="right" data-original-title="Check out more demos" @click="editreview(review)"><i class="fa fa-edit"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <ul class="pagination pagination-sm m-0 float-right">
                                                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]"><button class="page-link" href="#" @click="fetchreviews(pagination.prev_page_url)">Previous</button></li>

                                                    <li class="disabled"><button class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</button></li>

                                                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><button class="page-link" href="#" @click="fetchreviews(pagination.next_page_url)">Next</button></li>
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
            <h4 class="font-size-h4 font-weight-bold m-0">Edit review</h4>
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
                        <label class="text-dark">Title </label>
                        <input type="text" name="text" v-model="review.title" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('title')" v-text="errors.get('title')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">Comment</label>
                        <textarea type="text" cols="10" rows="10" v-model="review.comment" class="form-control" ></textarea>
                        <small class="form-text text-danger" v-if="errors.has('comment')" v-text="errors.get('comment')"></small>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">Rating </label>
                        <input type="email" name="number" v-model="review.rating" class="form-control" />
                        <small class="form-text text-danger" v-if="errors.has('rating')" v-text="errors.get('rating')"></small>
                    </div>
                </div>
            </div>
            <button type="button" @click="addUpdatereview()" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</template>

<script>
import ErrorHandling from "../../ErrorHandling";
export default {
    data() {
        return {
            review:{
                id:"",
                title:"",
                comment:"",
                rating:""

            },
            display_form: 0,
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
            reviews: [],
            languages: [],
            token: [],
            selectedLanguage:'',
            errors: new ErrorHandling(),
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        };
    },

    methods: {
       
        fetchreviews(page_url) {
            this.$parent.loading = true;
            let vm = this;
            page_url = page_url || "/api/admin/review";
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
            page_url += '&sortBy='+this.sortBy+'&sortType='+this.sortType+'&product=1&customer=1';
            var responseData = {};

            axios.get(page_url, this.token).then(res => {
                this.reviews = res.data.data;
                
                vm.makePagination(res.data.meta, res.data.links);
                console.log(this.reviews,"reviews");
            })
            .finally(() => (this.$parent.loading = false));
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
        deletereview(id) {
            if (confirm('Are You Sure?')) {
                this.$parent.loading = true;
                axios.delete(`/api/admin/review/${id}`,this.token)
                    .then(res => {
                        if (res.data.status == "Success") {
                            this.$toaster.success('Settings has been updated successfully')
                            this.fetchreviews();
                        }

                    })
                    .catch(err => console.log(err))
                    .finally(() => (this.$parent.loading = false));
            }
        },

        editreview(review) {
            this.display_form = 1;
            this.review.title = review.title;
            this.review.comment = review.comment;
            this.review.rating = review.rating;
            this.review.id = review.id;
        },
        addUpdatereview() {
            this.$parent.loading = true;
            var url = '/api/admin/review/'+this.review.id;
            this.request_method = 'put'
            axios[this.request_method](url,this.review, this.token)
                .then(res => {
                    if (res.data.status == "Success") {
                        this.display_form = 0;
                        this.$toaster.success('Review has been updated successfully')
                        this.clearForm();
                        this.fetchreviews();
                    } else {
                        this.$toaster.error(res.data.message)
                    }
                })
                .catch(error => {
                    this.error_message = '';
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        if (error.response.data.status == 'Error') {
                            this.error_message = error.response.data.message;
                        } else {
                            this.errors.record(error.response.data.errors);
                        }
                    }
                }).finally(() => (this.$parent.loading = false));

        },
        sorting(sortBy){
            this.sortBy = sortBy;
            this.sortType = this.sortType == 'asc' || this.sortType == 'ASC' ? this.sortType='desc' : this.sortType = 'asc';
            this.fetchreviews();
        },
        clearSearch(){
            this.searchParameter = "",
            this.fetchreviews();
        }
    },
    mounted() {
        
        var token = localStorage.getItem('token');
        this.token = {
            headers: {
                Authorization: `Bearer ${token}`
            }
        };
        this.fetchreviews();
    }
};
</script>
