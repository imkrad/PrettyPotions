<template>
    <b-modal v-model="showModal" title="Confirm Appointment"  style="--vz-modal-width: 800px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12 mt-2 mb-2" v-if="is_walkin">
                   <div class="form-group">
                        <label>Customer: <span v-if="form.errors" v-text="form.errors.user_id" class="haveerror"></span></label>
                        <Multiselect 
                        :options="customers" 
                        v-model="booking.user_id"
                        @search-change="fetchCustomer" 
                        label="name"
                        :searchable="true" 
                        placeholder="Select Customer"/>
                        </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th style="width: 40%;">Service</th>
                                <th class="text-center" style="width: 25%;">Aesthetician</th>
                                <th class="text-center" style="width: 20%;">Date</th>
                                <th style="width: 15%;" class="text-end">Price</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive" style="max-height: 150px; overflow: auto;">
                    <table class="table table-nowrap align-middle mb-0">
                        <tbody>
                            <tr v-for="(list,index) in booking.cart" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                <td class="fs-12" style="width: 40%;">
                                    {{list.service}} <span v-if="list.description != 'n/a'" class="fs-11 text-muted">({{list.description}})</span> 
                                </td>
                                <td class="text-center fs-12" style="width: 25%;">
                                    <span v-if="list.aesthetician">{{list.aesthetician.name}}</span>
                                    <span v-else>-</span>
                                </td>
                                <td class="text-center" style="width: 20%;">{{ list.date }} {{ list.time }}</td>
                                <td class="text-end fs-12" style="width: 15%;">{{formatMoney(list.price)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <tbody>
                            <tr class="table-light text-muted fs-12">
                                <td colspan="2">Subtotal : </td>
                                <td class="text-end">{{formatMoney(booking.subtotal)}}</td>
                            </tr>
                            <tr class="table-success fw-semibold">
                                <td colspan="2">Total : </td>
                                <td class="text-end">{{formatMoney(booking.subtotal)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect },
    props: ['specialists','categories','users'],
    data(){
        return {
            booking: {
                id: null,
                cart: [],
                subtotal: 0,
                total: 0,
                user_id: null
            },
            form: {},
            customers: [],
            is_walkin: false,
            showModal: false,
            editable: false,
            type: null,
        }
    },
    methods : {
        show(cart, subtotal, discount, type) {
            this.type = type;
            this.booking.cart = cart;
            this.booking.total = subtotal;
            this.booking.subtotal = subtotal;
            this.showModal = true;
        },
        new(cart, subtotal, discount) {
            this.booking.cart = cart;
            this.booking.total = subtotal;
            this.booking.subtotal = subtotal;
            this.booking.is_walkin = true;
            this.is_walkin = true;
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                cart: this.booking.cart,
                user_id: this.booking.user_id,
                total: this.booking.total,
                role: this.$page.props.role,
                type: this.type,
                option: 'walkin'
            })

            this.form.post('/appointments',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('message',true);
                    this.hide();
                },
            });
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        fetchCustomer(code){
            axios.get('/clients',{
                params: {
                    option: 'pick',
                    keyword: code
                }
            })
            .then(response => {
                this.customers = response.data;
            })
            .catch(err => console.log(err));
        },
        hide(){
            this.booking.total = null;
            this.booking.subtotal = null;
            this.booking.discount = null;
            this.booking.cart = null;
            this.showModal = false;
        }
    }
}
</script>