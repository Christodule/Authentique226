
<template>
<!--begin::Header Mobile-->
	<div id="tc_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
		<!--begin::Logo-->
		<a href="/admin/dashboard" class="brand-logo">

			<span class="brand-text"><img style="height: 25px;" alt="Logo" src="/assets/images/misc/logo.png" /></span>

		</a>
		<!--end::Logo-->
		<!--begin::Toolbar-->
		<div class="d-flex align-items-center">
           
			 <div class="posicon d-lg-block" v-if="$parent.permissions.includes('pos')">
				<a href="/admin/pos" class="btn btn-primary d-flex align-items-center justify-content-center white mr-2">POS</a>
			</div>
			<button class="btn p-0" id="tc_aside_mobile_toggle" @click="setBurgerMenu()">
				<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-justify-right" fill="currentColor"
					xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M6 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
				</svg>
			</button>

			<div class="posicon d-lg-block">
                    <div class="dropdown" :class="{ 'show': showdropdown }">

								<div class="topbar-item" data-toggle="dropdown" data-display="static" :aria-expanded="showdropdown" @click="showDropDown()">
									<div class="btn btn-icon w-auto btn-clean d-flex align-items-center pr-1 pl-3">
										<span class="text-dark-50 font-size-base d-none d-xl-inline mr-3">
                                            {{ username }}</span>
										<span class="symbol symbol-35 symbol-light-success" >
											<span class="symbol-label font-size-h5 " >
												<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
												</svg>
											</span>
										</span>
									</div>
								</div>

								<div class="dropdown-menu dropdown-menu-right" :class="{ 'show': showdropdown }" style="min-width: 150px;">

									<router-link to="/admin/profile" class="dropdown-item">
										<span class="svg-icon svg-icon-xl svg-icon-primary mr-2">
											<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
												<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
												<circle cx="12" cy="7" r="4"></circle>
											</svg>
										</span>
										Edit Profile
									</router-link>

									<a href="#" class="dropdown-item" @click="logOut()">
										<span class="svg-icon svg-icon-xl svg-icon-primary mr-2">
											<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power">
												<path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
												<line x1="12" y1="2" x2="12" y2="12"></line>
											</svg>
										</span>
										Logout
									</a>
								</div>

							</div>
                </div>

		</div>
		<!--end::Toolbar-->
	</div>
	<!--end::Header Mobile-->
</template>

<script>
export default {
   data(){
       return {
           showdropdown:false,
           username:""
       }
       
   },
    methods: {
        logOut() {
            this.$parent.loading = true;
            let page_url = "/api/admin/logout";

            axios.post(page_url,{},this.token).then(res => {
                this.orders = res.data.data;
                setTimeout(() => { this.$router.push('/admin/login'); }, 1000);
            })
        },
        setBurgerMenu(){
            
            var classList = document.body.classList.value.split(' ');
            console.log(classList);
            if(classList.indexOf('aside-minimize') === -1)
			{
                document.body.classList.add('aside-minimize');
				document.getElementById("tc_aside").classList.add('aside-on');
				document.getElementById("aside-overlay").classList.add('active');
				
            }else{
                	document.body.classList.remove('aside-minimize');
					document.getElementById("tc_aside").classList.remove('aside-on');
					document.getElementById("aside-overlay").classList.remove('active');
			}

            this.$emit('setBurgerMenu');
        },
        showDropDown(){
            this.showdropdown = !this.showdropdown
        }
    },
    mounted() {
     
        var token = localStorage.getItem('token');
        this.token = {
            headers: {
                Authorization: `Bearer ${token}`
            }
        };

        console.log(localStorage.getItem('name'));
        if(localStorage.getItem('name')){

            this.username = localStorage.getItem('name')
        }
    },
};
</script>
