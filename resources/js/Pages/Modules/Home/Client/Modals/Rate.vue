<template>
    <b-modal v-model="showModal" title="Rate Appointment"  header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label>Comment:</label>
                        <input type="text" class="form-control" v-model="comment">
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <label>Rate:</label>
                    <vue3-star-ratings :numberOfStars="5" v-model="rating"/>
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
import vue3StarRatings from "vue3-star-ratings";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect, vue3StarRatings },
    props: ['specialists','categories','users'],
    data(){
        return {
            id: null,
            rating: null,
            comment: null,
            form: {},
            showModal: false,
        }
    },
    methods : {
        show(id) {
            this.id = id;
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                appointment_id: this.id,
                comment: this.comment,
                rating: this.rating
            })

            this.form.post('/reviews',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('message',true);
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