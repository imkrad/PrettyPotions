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
                            <b-row class="job-list-row" id="companies-list" v-if="!lists" style="height: calc(100vh - 400px); overflow-x: hidden;">
                                <b-col xxl="4" v-for="(data, index) of categories.data" :key="index">
                                    <b-card no-body class="companiesList-card" @click="filter.category = data">
                                        <b-card-body style="cursor: pointer;">
                                            <div class="text-center">
                                                <h5 class="mt-3 company-name fs-13">{{ data.name }}</h5>
                                            </div>
                                            <div>
                                                <b-button type="button" variant="soft-primary" class="w-100 viewcompany-list">{{data.services.length}} Services Available</b-button>
                                            </div>
                                        </b-card-body>
                                    </b-card>
                                </b-col>
                            </b-row>
                            <b-row v-else>
                                <div class="col-md-12 mt-3">
                                    <div style="height: calc(100vh - 400px); overflow-x: hidden;">
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
                            </b-row>
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
                                            <td class="fs-12">{{list.service}} <span v-if="list.description != 'n/a'" class="fs-11 text-muted">({{list.description}})</span> 
                                                <h5 class="fs-13 mb-0 text-dark">{{list.service}}</h5>
                        <p class="fs-12 text-muted mb-0">{{list.description}}</p>
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
        <!-- <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="save()" variant="primary" :disabled="form.processing" block>Confirm</b-button>
        </template> -->
    </b-modal>
    <Confirm @message="hide()" ref="confirm"/>
</template>
<script>
import Confirm from './Confirm.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect, Confirm },
    props: ['categories'],
    data(){
        return {
            form: {},
            filter: {
                keyword: null,
                category: null
            },
            cart: [],
            discount: 0,
            subtotal: 0,
            total: 0,
            lists: false,
            showModal: false,
            editable: false,
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
    methods : {
        show() {
            this.showModal = true;
        },
        addCart(data){
            const exst = this.cart.some(item => item.id === data.id);
            if(!exst){
                this.cart.push(data);
            }else{
                
            }
            this.calculateTotalPrice();
        },
        openConfirm(){
            this.$refs.confirm.new(this.cart,this.subtotal,this.discount,'walkin');
        },
        calculateTotalPrice() {
            this.subtotal = this.cart.reduce((total, item) => total + parseFloat(item.price), 0);
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