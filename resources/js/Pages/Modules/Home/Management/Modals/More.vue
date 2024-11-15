<template>
    <b-modal v-model="showModal" title="Add More" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <div class="alert alert-warning" role="alert">It is optional to choose an aesthetician</div>
                </div>
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group">
                        <multiselect id="ajax" label="name" :searchable="true" object
                        placeholder="Select Service" v-model="service" open-direction="bottom" 
                        :options="services" :allow-empty="false" :show-labels="false">
                        </multiselect> 
                    </div>
                </div>
                <div class="col-md-12 mt-2" v-if="service">
                    <div class="form-group">
                        <multiselect id="ajax" label="name" :searchable="true" object
                        placeholder="Select Aesthetician" v-model="aesthetician" open-direction="bottom" 
                        :options="aestheticians" :allow-empty="false" :show-labels="false">
                        </multiselect> 
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="save()" variant="primary" :disabled="form.processing" block>Confirm</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect },
    data(){
        return {
            form: {},
            showModal: false,
            editable: false,
            service: '',
            services: [],
            date: null,
            aesthetician: null,
            aestheticians: [],
            id: null
        }
    },
    watch: {
        service(newService) {
            if (newService) {
                this.aestheticians = newService.aestheticians;
            } else {
                this.aestheticians = [];
            }
        }
    },
    methods : {
        show(data,id,date) {
            this.id = id;
            this.date = date;
            this.lists = data;
            this.showModal = true;
            this.fetch();
        },
        fetch(page_url){
            page_url = page_url || '/appointments';
            axios.get(page_url,{
                params : {
                    lists : this.lists,
                    option: 'ids'
                }
            })
            .then(response => {
                this.services = response.data;
            })
            .catch(err => console.log(err));
        },
        save(){
             this.form = this.$inertia.form({
                service: this.service,
                aesthetician: this.aesthetician,
                date: this.date,
                appointment_id: this.id,
                option: 'service'
            })

            this.form.post('/appointments',{
                preserveScroll: true,
                onSuccess: (response) => {
                    console.log(this.$page.props.flash.data);
                    this.$emit('message',this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        calculateTotalPrice() {
            this.subtotal = this.cart.reduce((total, item) => total + parseFloat(item.price), 0);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        hide(){
            this.service = null;
            this.showModal = false;
        },
    }
}
</script>