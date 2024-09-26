<template>
    <b-modal v-model="showModal" title="View Aesthetician"  style="--vz-modal-width: 620px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12 mt-1">
                    <p class="text-muted fs-11"> This is the list of <code>categories</code> assigned to the aesthetician. Click to view <code>services</code> within the category.</p>
                    <hr class="text-muted"/>
                    <b-accordion class="custom-accordionwithicon" id="accordionWithicon" style="max-height: 200px; overflow: auto;">
                        <b-accordion-item v-for="(list,index) in selected.lists" v-bind:key="index" :title="list.category.name">
                            <b-list-group flush>
                                <b-list-group-item v-for="(service,index) in list.category.services">{{index+1}}. {{service.service}}</b-list-group-item>
                            </b-list-group>
                        </b-accordion-item>
                    </b-accordion>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <!-- <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button> -->
        </template>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect },
    props: ['specialists','categories','users'],
    data(){
        return {
            selected: {},
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
        hide(){
            this.showModal = false;
        },
    }
}
</script>