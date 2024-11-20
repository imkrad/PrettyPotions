<template>
    <b-modal v-model="showModal" title="Select Aesthetician" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2" v-if="selected">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <input type="text" class="form-control" v-model="selected.service" readonly>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="alert alert-warning" role="alert">It is optional to choose an aesthetician</div>
                </div>
                <div class="col-md-6 mt-1">
                    <div class="form-group">
                        <label>Date: <span v-if="form.errors" v-text="form.errors.date" class="haveerror"></span></label>
                        <input type="date" :min="notBeforeToday" class="form-control" v-model="date">
                    </div>
                </div>
                <div class="col-md-6 mt-1">
                   <div class="form-group">
                        <label>Time: <span v-if="form.errors" v-text="form.errors.time" class="haveerror"></span></label>
                          <select name="time" v-model="time" class="form-control">
                            <option :value="null">Select Time</option>
                            <option v-for="(time,index) in times" v-bind:value="time.value" v-bind:key="index" :selected="time.value == '4:00 PM'">{{time.text}}
                            </option>
                        </select> 
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label>Aesthetician: <span class="text-muted">(Optional)</span></label>
                        <multiselect id="ajax" label="name" :searchable="true" 
                        placeholder="Select Aesthetician" v-model="aesthetician" open-direction="bottom" object
                        :options="aestheticians" :allow-empty="false" :show-labels="false">
                        </multiselect> 
                    </div>
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
    data(){
        return {
            selected: null,
            aesthetician: null,
            date: null,
            time: null,
            form: {},
            cart: {},
            aestheticians: [],
            showModal: false,
            // notBeforeToday: new Date((new Date()).valueOf() + 1000*3600*24).toISOString().split('T')[0],
            times:[
                { text:'8:00 AM', value: '8:00 AM' },
                { text:'9:00 AM', value: '9:00 AM' },
                { text:'10:00 AM', value: '10:00 AM' },
                { text:'11:00 AM', value: '11:00 AM' },
                { text:'12:00 PM', value: '12:00 PM' },
                { text:'1:00 PM', value: '1:00 PM' },
                { text:'2:00 PM', value: '2:00 PM' },
                { text:'3:00 PM', value: '3:00 PM' },
                { text:'4:00 PM', value: '4:00 PM' },
                { text:'5:00 PM', value: '5:00 PM' },
            ]
        }
    },
    watch: {
        date(newDate) {
            this.checkAndFetch();
        },
        time(newTime) {
            this.checkAndFetch();
        }
    },
    computed: {
        notBeforeToday() {
            return new Date().toISOString().split('T')[0];
        }
    },
    methods : {
        show(data) {
            this.date = null;
            this.time = null;
            this.aesthetician = null;
            this.selected = data;
            this.showModal = true;
        },
        checkAndFetch() {
            if (this.date && this.time) {
                this.fetch();
            }
        },
        fetch(){
            axios.get('/services',{
                params : {
                    date : this.date,
                    time: this.time,
                    service: this.selected.id,
                    category: this.selected.category.value,
                    option: 'checking'
                }
            })
            .then(response => {
                if(response){
                    this.aestheticians = response.data;       
                }
            })
            .catch(err => console.log(err));
        },
        create(){
            this.form = this.$inertia.form({
                aesthetician_id: (this.aesthetician) ? this.aesthetician.value : null,
                time: this.time,
                date: this.date,
                service_id: this.selected.id,
                category: this.selected.category.value
            });

            this.form.post('/booking',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('message',true);
                    this.hide();
                },
            });
            // this.cart.id = this.selected.id;
            // this.cart.service = this.selected.service;
            // this.cart.description = this.selected.description;
            // this.cart.price = this.selected.price;
            // this.cart.aesthetician = this.aesthetician;
            // this.cart.time = this.time;
            // this.cart.date = this.date;
            // this.$emit('update',this.cart);
            // this.cart = {};
            // this.selected = null;
            // this.aesthetician = null;
            this.showModal = false;
            this.hide();
        },  
        hide(){
            this.showModal = false;
        },
    }
}
</script>