<template>
    <b-modal v-model="showModal" :title="type+' Appointment'"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12" v-if="type == 'Confirm'">
                    <label class="form-label">Note</label>
                    <textarea rows="4" class="form-control" placeholder="Please input note to be text"  v-model="reason"/>
                </div>
                <div v-else class="col-md-12">
                    <label class="form-label">Reason</label>
                    <textarea rows="4" class="form-control" placeholder="Please input reason"  v-model="reason"/>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="save('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
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
            reason: null,
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
                reason: this.reason,
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