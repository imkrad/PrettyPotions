<template>
    <b-modal v-model="showModal" title="Create Appointment" hide-footer style="--vz-modal-width: 1500px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <b-row class="g-2">
                            <b-col md="8">
                                <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search Service"
                                    v-model="filter.keyword" />
                                <i class="ri-search-line search-icon"></i>
                                </div>
                            </b-col>
                            <b-col md="4">
                                <Multiselect class="form-control" v-model="filter.category" 
                                :close-on-select="true" placeholder="Select Category"
                                :searchable="true" :create-option="true" object="true"
                                :options="categories.data" label="name" track-by="name"/>
                            </b-col>
                        </b-row>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-3">
                            <div class="row" style="height: calc(100vh - 400px); overflow-x: hidden;">
                            <div class="col-md-6 col-lg-4 col-xxl-3 product-item upto-30" v-for="(list,index) in services" v-bind:key="index" >
                                <div class="card explore-box card-animate" @click="addCart(list)" style="cursor: pointer;">
                                    <div class="position-relative rounded overflow-hidden">
                                        <img :src="currentUrl+'/imagess/avatar.jpg'" alt="" class="card-img-top explore-img">
                                    </div>
                                    <div class="card-body">
                                        <h6 class="fs-14 mb-0 text-truncate"><a class="" href="/apps/nft-item-detail" target="_self">{{list.service}}</a></h6>
                                        <span class="text-muted">{{list.category.name}}</span>
                                       
                                    </div>
                                    <div class="card-footer">
                                        <div class="mt-n1 mb-n3">
                                            <p class="fw-medium mb-0 float-end"><i class="mdi mdi-heart text-danger align-middle"></i> {{(list.rating) ? list.rating : '-'}} </p>
                                            <h5 class="text-success fs-14">₱{{list.price}} </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-success material-shadow" role="alert">
                                Services Summary
                </div>
                <hr class="text-muted"/>
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th class="text-center" style="width: 3%;">#</th>
                                <th style="width: 30%;">Service</th>
                                <th style="width: 15%;" class="text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(list,index) in cart" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                <td class="text-center">{{ index + 1 }}.</td>
                                <td class="fs-12">
                                    <h5 class="fs-13 mb-0 text-dark"> {{list.service}} <span v-if="list.description != 'n/a'" class="fs-11 text-muted">({{list.description}})</span> </h5>
                                    <p class="fs-12 text-muted mb-0">{{list.aesthetician.name}}</p>
                                </td>
                                <td class="text-end fs-12">{{formatMoney(list.price)}}</td>
                            </tr>
                            <tr class="table-light text-muted fs-12">
                                <td colspan="2">Subtotal : </td>
                                <td class="text-end">{{formatMoney(subtotal)}}</td>
                            </tr>
                            <!-- <tr class="table-light text-muted fs-12">
                                <td colspan="2">Discount : </td>
                                <td class="text-end">{{formatMoney(discount)}}</td>
                            </tr> -->
                            <tr class="table-light fw-semibold">
                                <td colspan="2">Total : </td>
                                <td class="text-end">{{formatMoney(subtotal)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-grid gap-2 mt-4" >
                    <button @click="openConfirm()" class="btn btn-info" type="button">CONFIRM APPOINTMENT</button>
                </div>
            </div>
        </div>
    </b-modal>
    <Confirm @message="hide()" ref="confirm"/>
    <Tao @update="updateCart" ref="tao"/>
</template>
<script>
import Tao from './Tao.vue';
import Confirm from './Confirm.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect, Confirm, Tao },
    props: ['categories'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: {},
            filter: {
                keyword: null,
                category: null
            },
            cart: [],
            services: [],
            total: 0,
            lists: false,
            showModal: false,
            editable: false,
        }
    },
    computed: {
        subtotal() {
            return this.cart.reduce((total, booking) => {
                // Check if booking and service.price exist before adding
                if (booking && booking.price) {
                return total + parseFloat(booking.price);
                }
                return total;
            }, 0);
        }
    },
    created(){
        this.fetch();
    },
    watch: {
        "filter.category"(){
            if(this.filter.category){
                this.lists = true;
            }else{
                this.lists = false;
            }
        }
    },
    methods : {
        show() {
            this.showModal = true;
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/services';
            axios.get(page_url,{
                params : {
                    keyword : this.filter.keyword,
                    category: this.filter.category,
                    option: 'services'
                }
            })
            .then(response => {
                if(response){
                    this.services = response.data.data;       
                }
            })
            .catch(err => console.log(err));
        },
        addCart(data){
            const exst = this.cart.some(item => item.id === data.id);
            if(!exst){
                this.$refs.tao.show(data);
            }
        },
        updateCart(data){
            this.cart.push(data);
        },
        openConfirm(){
            this.$refs.confirm.new(this.cart,this.subtotal,'walkin');
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        hide(){
            this.showModal = false;
        },
    }
}
</script>