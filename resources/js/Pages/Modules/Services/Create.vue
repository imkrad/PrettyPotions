<template>
    <b-modal v-model="showModal" :title="(editable) ? 'Edit Service' : 'Create Service'"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-9 mt-2">
                   <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" v-model="service.service">
                    </div>
                </div>
                <div class="col-md-3 mt-2">
                   <div class="form-group">
                        <label>Price:</label>
                        <input type="text" class="form-control" v-model="service.price">
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                   <div class="form-group">
                        <label>Description:</label>
                        <input type="text" class="form-control" v-model="service.description">
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: -2px;">
                    <label>Category: <span v-if="form.errors" v-text="form.errors.category_id" class="haveerror"></span></label>
                    <multiselect id="ajax" v-model="service.category" label="name"
                    placeholder="Select Category" open-direction="bottom" 
                    :options="options" :allow-empty="false" :show-labels="false">
                    </multiselect> 
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
    props: ['options'],
    data(){
        return {
            service: {
                id: null,
                service: null,
                description: null,
                price: null,
                category: null
            },
            form: {},
            showModal: false,
            editable: false,
        }
    },
    methods : {
        show() {
            this.showModal = true;
        },
        edit(data){
            this.editable = true;
            this.service.id = data.id;
            this.service.price = data.price;
            this.service.service = data.service;
            this.service.description = data.description;
            this.service.category = data.category.value;
            this.showModal = true;
        },
        create(){
            if(!this.editable){
                this.form = this.$inertia.form({
                    id: this.service.id,
                    service: this.service.service,
                    description: this.service.description,
                    price: this.service.price,
                    category_id: this.service.category
                })

                this.form.post('/services',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            }else{
                 this.form = this.$inertia.form({
                    id: this.service.id,
                    service: this.service.service,
                    description: this.service.description,
                    price: this.service.price,
                    category_id: this.service.category
                })

                this.form.put('/services/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            }
        },
        hide(){
            this.$parent.fetch();
            this.editable = false;
            this.showModal = false;
        },
    }
}
</script>