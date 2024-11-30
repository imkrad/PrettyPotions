<template>
    <b-modal v-model="showModal" :title="(editable) ? 'Edit Service' : 'Create Service'"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12 mt-2">
                   <div class="form-group">
                        <label>Name: <span v-if="form.errors" v-text="form.errors.name" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="name">
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
export default {
    data(){
        return {
            name: null,
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
            this.id = data.id;
            this.service.price = data.price;
            this.showModal = true;
        },
        create(){
            if(!this.editable){
                this.form = this.$inertia.form({
                    name: this.name
                })
                this.form.put('/categories/update',{
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