<template>
    <b-modal v-model="showModal" :title="type+' Appointment'"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12">
                   Are you sure?
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="save('ok')" variant="primary" :disabled="form.processing" block>Yes</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            showModal: false,
            editable: false,
            form: {},
            type: null,
            status: null,
            id: null,
        }
    },
    methods : {
        show(status,type,id) {
            this.type = type;
            this.id = id;
            this.status = status;
            this.showModal = true;
        },
        save(){
            this.form = this.$inertia.form({
                id: this.id,
                status_id: this.status,
                option: this.type,
            })

            this.form.put('/appointments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',true);
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>