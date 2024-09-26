<template>
    <b-modal v-model="showModal" title="View Booking" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="table-responsive" style="max-height: 250px; overflow: auto;">
            <table class="table table-nowrap align-middle mb-0">
                <thead class="table-light">
                    <tr class="fs-11">
                        <th class="text-center" style="width: 33%;">Service</th>
                        <th class="text-center" style="width: 33%;">Customer</th>
                        <th class="text-center" style="width: 33%;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fs-12 text-center" style="width: 33%;">
                           {{selected.service.service}}
                        </td>
                        <td class="fs-12 text-center" style="width: 33%;">
                            {{selected.appointment.user.profile.firstname}} {{selected.appointment.user.profile.lastname}}
                        </td>
                        <td class="fs-12 text-center" style="width: 33%;">
                            {{selected.appointment.date}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <template v-slot:footer>
            <b-button v-if="selected.status.name === 'Pending'" @click="save(23)" variant="info" :disabled="form.processing" block>Mark as Ongoing</b-button>
            <b-button v-if="selected.status.name === 'Ongoing'" @click="save(20)" variant="success" :disabled="form.processing" block>Mark as Completed</b-button>
             <b-button v-if="selected.status.name === 'Completed'" @click="hide()" variant="light" block>Close</b-button>
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
            selected: {
                appointment: {
                    user: {
                        profile: {}
                    },
                },
                service: {},
                status: {}
            },
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
        save(status){
            this.form = this.$inertia.form({
                id: this.selected.id,
                status_id: status,
                option: 'service'
            });

            this.form.put('/appointments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        },
    }
}
</script>