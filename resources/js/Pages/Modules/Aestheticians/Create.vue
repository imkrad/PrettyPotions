<template>
    <b-modal v-model="showModal" title="Create Aesthetician"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-6" style="margin-top: -2px;">
                    <label>User: <span v-if="form.errors" v-text="form.errors.user_id" class="haveerror"></span></label>
                    <multiselect id="ajax" v-model="aesthetician.user" label="name"
                    placeholder="Select User" open-direction="bottom" 
                    :options="users" :allow-empty="false" :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-md-6" style="margin-top: -2px;">
                    <label>Specialist: <span v-if="form.errors" v-text="form.errors.specialist_id" class="haveerror"></span></label>
                    <multiselect id="ajax" v-model="aesthetician.specialist" label="name"
                    placeholder="Select Specialist" open-direction="bottom" 
                    :options="specialists" :allow-empty="false" :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-md-12 mt-1">
                    <label>Service Category: <span v-if="form.errors" v-text="form.errors.category" class="haveerror"></span></label>
                    <multiselect id="ajax" v-model="aesthetician.categories" label="name"
                    placeholder="Select Category" object="true" mode="multiple" open-direction="bottom" 
                    :options="categories" :allow-empty="false" :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-md-12 mt-1`" v-if="aesthetician.categories.length > 0">
                    <hr class="text-muted"/>
                    <b-list-group class="list-group-numbered mt-3">
                        <b-list-group-item v-for="(list,index) in aesthetician.categories" v-bind:key="index">
                            {{list.name}}
                            <i @click="remove(list.id)" class="ri-delete-bin-5-fill align-middle float-end" style="cursor: pointer;"></i>
                        </b-list-group-item>
                    </b-list-group>
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
    props: ['specialists','categories','users'],
    data(){
        return {
            aesthetician: {
                id: null,
                user: null,
                specialist: null,
                categories: []
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
        create(){
            this.form = this.$inertia.form({
                id: this.aesthetician.id,
                user_id: this.aesthetician.user,
                specialist_id: this.aesthetician.specialist,
                categories: this.aesthetician.categories
            })

            this.form.post('/aestheticians',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        remove(id){
            const index = this.aesthetician.categories.findIndex(item => item.id === id);
            if (index !== -1) {
                this.aesthetician.categories.splice(index, 1);
            }
        },
        hide(){
            this.$parent.fetch();
            this.showModal = false;
        },
    }
}
</script>