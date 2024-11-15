<template>
    <b-modal v-model="showModal" title="Update Status"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2" v-if="selected">
            <div class="row customerform">
                <div class="col-md-12 mt-2">
                   <div class="form-group">
                        <input type="text" class="form-control" v-model="selected.service" readonly>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div v-if="!this.selected.is_active" class="alert alert-success" role="alert">Set service as <b>Active.</b></div>
                    <div v-else class="alert alert-danger" role="alert">Set service as <b>Inactive.</b></div>
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
            selected: null,
            form: {},
            showModal: false,
            editable: false,
        }
    },
    methods : {
        show(data) {
            this.selected = data;
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                id: this.selected.id,
                is_active: (this.selected.is_active) ? 0 : 1
            })

            this.form.put('/services/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.$parent.fetch();
            this.editable = false;
            this.showModal = false;
        },
    }
}
</script>