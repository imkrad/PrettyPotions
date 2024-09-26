<template>
    <b-modal v-model="showModal" title="Add More" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <!-- {{services}} -->
         <multiselect id="ajax" label="name" :searchable="true" 
                    placeholder="Select Aesthetician" v-model="list" open-direction="bottom" 
                    :options="lists" :allow-empty="false" :show-labels="false">
                    </multiselect> 
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
            id: null,
            category_id: null,
            appointment_id: null,
            list: null,
            lists: []
        }
    },
    methods : {
        show(id,category_id,appointment_id) {
            this.id = id;
            this.category_id = category_id;
            this.appointment_id = appointment_id;
            this.showModal = true;
            this.fetch();
        },
        fetch(page_url){
            page_url = page_url || '/appointments';
            axios.get(page_url,{
                params : {
                    category_id : this.category_id,
                    option: 'aestheticians'
                }
            })
            .then(response => {
                this.lists = response.data;
            })
            .catch(err => console.log(err));
        },
        save(){
             this.form = this.$inertia.form({
                id: this.id,
                aesthetician_id: this.list,
                appointment_id: this.appointment_id,
                option: 'aesthetician'
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
        hide(){
            this.list = null;
            this.showModal = false;
        },
    }
}
</script>