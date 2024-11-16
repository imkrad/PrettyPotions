<template lang="">
    <div class="row" v-if="appointments.length == 0 || neww == true">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
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
                    </div>
                </div>
                <div class="col-md-12">
                    <div style="height: calc(100vh - 270px); overflow: auto; margin-bottom: -20px;">
                        <div class="row">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: calc(100vh - 205px); overflow: auto;">
                            <div class="alert alert-success material-shadow" role="alert">
                                Ongoing Appointments : {{appointments.length}} <b style="cursor: pointer;" class="float-end text-danger" @click="neww = false">VIEW ALL</b>
                            </div>
                            <hr class="text-muted"/>
                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="fs-11">
                                            <th class="text-center" style="width: 3%;">#</th>
                                            <th style="width: 70%;">Service</th>
                                            <th style="width: 25%;" class="text-center">Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in bookings.data" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                            <td class="text-center">{{ index + 1 }}.</td>
                                            <td class="fs-12">
                                               <h5 class="fs-12 mb-0"> {{list.service.service}} <span v-if="list.service.description != 'n/a'" class="fs-11 text-muted">({{list.service.description}})</span></h5>
                                                <span v-if="list.aesthetician" class="fs-11 text-muted">{{list.aesthetician.user.profile.firstname}} {{list.aesthetician.user.profile.lastname}}</span> 
                                                <!-- <span v-if="list.description != 'n/a'" class="fs-11 text-muted">({{list.description}})</span>  -->
                                                
                                            </td>
                                            <td class="text-center fs-12">{{formatMoney(list.service.price)}}</td>
                                            <td class="text-end">
                                                <b-button @click="removeCart(list)" variant="soft-danger" v-b-tooltip.hover title="Remove" size="sm" class="remove-list me-1">
                                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>
                                        <tr class="table-light text-muted fs-12">
                                            <td colspan="3">Subtotal : </td>
                                            <td class="text-end">{{formatMoney(subtotal)}}</td>
                                        </tr>
                                        <!-- <tr class="table-light text-muted fs-12">
                                            <td colspan="3">Discount : </td>
                                            <td class="text-end">{{formatMoney(discount)}}</td>
                                        </tr> -->
                                        <tr class="table-light fw-semibold">
                                            <td colspan="3">Total : </td>
                                            <td class="text-end">{{formatMoney(subtotal)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="d-grid gap-2 mt-4" >
                                <button @click="openConfirm()" class="btn btn-info" type="button" :disabled="(bookings.data.length == 0) ? true : false">CONFIRM BOOKING</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="height: calc(100vh - 200px); overflow: hidden;">
                    <b-row class="g-2 mb-2">
                        <b-col md="10">
                            <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search Appointment"
                                v-model="filter.keyword" />
                            <i class="ri-search-line search-icon"></i>
                            </div>
                        </b-col>
                        <b-col md="2">
                            <b-button variant="primary" class="w-100" @click="neww = true">New Appointment</b-button>
                        </b-col>
                    </b-row>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 20%;">Code</th>
                                    <th style="width: 10%;" class="text-center">Services</th>
                                    <th style="width: 15%;" class="text-center">Total</th>
                                    <th style="width: 15%;" class="text-center">Request Date</th>
                                    <th style="width: 15%;" class="text-center">Status</th>
                                    <th style="width: 10%;" class="text-center">Rate</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in appointments" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ list.code }}</td>
                                    <td class="text-center">{{list.lists.length}}</td>
                                    <td class="text-center">{{formatMoney(list.total)}}</td>
                                    <td class="text-center">{{list.created_at}}</td>
                                    <td class="text-center">
                                        <span class="badge" :class="list.status.color">{{list.status.name}}</span>
                                    </td>
                                    <td class="text-center">
                                        <b-button v-if="!list.is_rated" variant="soft-info"  @click="openRate(list)" v-b-tooltip.hover title="View" size="sm" class="me-1" :disabled="list.status.name !== 'Completed'">
                                             Rate now
                                        </b-button>
                                        <span v-else>{{list.review.rating}}</span>
                                    </td>
                                    <td class="text-end">
                                        <b-button variant="soft-info"  @click="openView(list)" v-b-tooltip.hover title="View" size="sm" class="remove-list me-1">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                        <b-button v-if="list.status.name === 'Pending'" variant="soft-danger"  @click="openView(list)" v-b-tooltip.hover title="View" size="sm" class="remove-list me-1">
                                            <i class="ri-pencil-fill align-bottom"></i>
                                        </b-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Confirm @update="update" ref="confirm"/>
    <Rate ref="rate"/>
    <View ref="view"/>
    <Tao @update="updateCart" ref="tao"/>
</template>
<script>
import Tao from './Modals/Tao.vue';
import View from '../Management/Modals/View.vue';
import Rate from './Modals/Rate.vue';
import Confirm from './Modals/Confirm.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    props: ['categories','appointments','bookings'],
    components: { Multiselect, Confirm, Rate, View, Tao },
    data(){
        return {
            currentUrl: window.location.origin,
            filter : {
                keyword: null,
                category: null
            },
            form: {},
            cart: [],
            services: [],
            discount: 0,
            total: 0,
            lists: false,
            neww: false
        }
    },
    created(){
        this.fetch();
    },
    watch: {
        "filter.category"(){
            if(this.filter.category){
                this.fetch();
            }else{
                this.fetch();
            }
        },
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
    },
    computed: {
        subtotal() {
            return this.bookings.data.reduce((total, booking) => {
                // Check if booking and service.price exist before adding
                if (booking.service && booking.service.price) {
                return total + parseFloat(booking.service.price);
                }
                return total;
            }, 0);
        }
    },
    methods: {
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
            const exst = this.bookings.data.some(item => item.service.id === data.id);
            if(!exst){
                this.$refs.tao.show(data);
            }
        },
        updateCart(data){
            alert('wew');
            this.cart.push(data);
            this.calculateTotalPrice();
        },
        openConfirm(){
            this.$refs.confirm.show(this.bookings.data,this.subtotal,this.discount,'book');
        },
        openRate(list){
            this.$refs.rate.show(list.id);
        },
        openView(data){
            this.$refs.view.view(data);
        },
        calculateTotalPrice() {
            this.subtotal = this.bookings.data.reduce((total, item) => total + parseFloat(item.service.price), 0);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        removeCart(list){
            // this.cart.splice(this.cart.indexOf(index), 1);
            this.form = this.$inertia.form({
                id: list.id,
                option: 'delete'
            });

            this.form.post('/booking',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('message',true);
                    this.hide();
                },
            });
        },
        update(){
            this.cart = [];
        }
    }
}
</script>