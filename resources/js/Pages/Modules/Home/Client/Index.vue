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
                    <div>
                        <b-row class="job-list-row" id="companies-list" v-if="!lists" style="height: calc(100vh - 301px); overflow-x: hidden;">
                            <b-col xxl="4" v-for="(data, index) of categories.data" :key="index">
                                <b-card no-body class="companiesList-card" @click="filter.category = data">
                                    <b-card-body  style="cursor: pointer;">
                                        <div class="text-center">
                                            <h5 class="mt-1 fs-13 company-name">{{ data.name }}</h5>
                                        </div>
                                        <div>
                                            <b-button type="button" variant="soft-primary" class="w-100 btn-sm viewcompany-list">{{data.services.length}} Services Available</b-button>
                                        </div>
                                    </b-card-body>
                                </b-card>
                            </b-col>
                        </b-row>
                        <b-row v-else>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body" style="height: calc(100vh - 302px); overflow-x: hidden;">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr class="fs-11">
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 30%;">Name</th>
                                                        <th style="width: 35%;" class="text-center">Description</th>
                                                        <th style="width: 15%;" class="text-center">Price</th>
                                                        <th style="width: 10%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(list,index) in filter.category.services" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>{{list.service}}</td>
                                                        <td class="text-center">{{list.description}}</td>
                                                        <td class="text-center">{{list.price}}</td>
                                                        <td class="text-end">
                                                            <b-button variant="primary" class="btn btn-primary btn-sm waves-effect waves-light" @click="addCart(list)">Book Now</b-button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </b-row>
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
                                        <tr v-for="(list,index) in cart" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                            <td class="text-center">{{ index + 1 }}.</td>
                                            <td class="fs-12">
                                                {{list.service}} <span v-if="list.description != 'n/a'" class="fs-11 text-muted">({{list.description}})</span> 
                                            </td>
                                            <td class="text-end fs-12">{{formatMoney(list.price)}}</td>
                                            <td class="text-end">
                                                <b-button @click="removeCart(index)" variant="soft-danger" v-b-tooltip.hover title="Remove" size="sm" class="remove-list me-1">
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
                                <button @click="openConfirm()" class="btn btn-info" type="button" :disabled="(cart.length == 0) ? true : false">CONFIRM BOOKING</button>
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
                                    <th style="width: 25%;">Code</th>
                                    <th style="width: 10%;" class="text-center">Date</th>
                                    <th style="width: 10%;" class="text-center">Total</th>
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
                                    <td class="text-center">{{list.date}}</td>
                                    <td class="text-center">{{list.lists.length}}</td>
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
</template>
<script>
import View from '../Management/Modals/View.vue';
import Rate from './Modals/Rate.vue';
import Confirm from './Modals/Confirm.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    props: ['categories','appointments'],
    components: { Multiselect, Confirm, Rate, View },
    data(){
        return {
            filter : {
                keyword: null,
                category: null
            },
            cart: [],
            discount: 0,
            subtotal: 0,
            total: 0,
            lists: false,
            neww: false
        }
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
    mounted() {
        this.calculateTotalPrice();
    },
    methods: {
        addCart(data){
            const exst = this.cart.some(item => item.id === data.id);
            if(!exst){
                this.cart.push(data);
            }else{
                
            }
            this.calculateTotalPrice();
        },
        openConfirm(){
            this.$refs.confirm.show(this.cart,this.subtotal,this.discount,'book');
        },
        openRate(list){
            this.$refs.rate.show(list.id);
        },
        openView(data){
            this.$refs.view.view(data);
        },
        calculateTotalPrice() {
            this.subtotal = this.cart.reduce((total, item) => total + parseFloat(item.price), 0);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        removeCart(index){
            this.cart.splice(this.cart.indexOf(index), 1);
        },
        update(){
            this.cart = [];
        }
    }
}
</script>