<template>
    <b-modal v-model="showModal" title="View Booking"  :style="(selected.status.name == 'Pending' || selected.status.name == 'Confirmed') ? '--vz-modal-width: 800px;' : '--vz-modal-width: 600px;'" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="d-flex">
            <div class="flex-grow-1">
                <h4>{{this.selected.code}}</h4>
                <div class="hstack gap-3 flex-wrap mt-n1">
                    <div><a href="#" class="text-primary d-block">{{selected.user.profile.firstname}} {{selected.user.profile.lastname}}</a></div>
                    <div class="vr"></div>
                    <div class="text-muted">Date : <span class="text-body fw-medium">{{selected.date}}</span></div>
                    <div class="vr"></div>
                    <div class="text-muted">Status : <span class="fw-medium" :class="selected.status.others">{{selected.status.name}}</span></div>
                </div>
            </div>
            <div class="flex-shrink-0">
                <b-button @click="addMore()" v-if="selected.status.name == 'Pending'" variant="soft-info">
                    <i class="ri-plus-fill align-bottom"></i> Add More
                </b-button>
            </div>
        </div>
        <hr class="text-muted"/>
        <!-- <div class="table-responsive mt-3">
            <table class="table table-nowrap align-middle mb-0">
                <thead class="table-light">
                    <tr class="fs-11">
                        <th style="width: 70%;">Service</th>
                        <th class="text-center" v-if="selected.status.name == 'Confirmed'">Aesthetician</th>
                        <th style="width: 25%;" :class="(selected.status.name == 'Pending') ? 'text-center' : 'text-end'">Price</th>
                        <th v-if="selected.status.name == 'Pending'"></th>
                    </tr>
                </thead>
            </table>
        </div> -->
        <div class="table-responsive" style="max-height: 250px; overflow: auto;">
            <table class="table table-nowrap align-middle mb-0">
                <thead class="table-light">
                    <tr class="fs-11">
                        <th style="width: 70%;">Service</th>
                        <th class="text-center" v-if="selected.status.name == 'Confirmed'">Aesthetician</th>
                        <th class="text-center" v-if="selected.status.name == 'Ongoing'">Status</th>
                        <th style="width: 25%;" :class="(selected.status.name == 'Pending') ? 'text-center' : 'text-end'">Price</th>
                        <th v-if="selected.status.name == 'Pending'"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list,index) in selected.lists" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                        <!-- <td class="text-center">{{ index + 1 }}.</td> -->
                        <td class="fs-12" style="width: 70%;">
                            {{list.service.service}} <span v-if="list.service.description != 'n/a'" class="fs-11 text-muted">({{list.service.description}})</span> 
                        </td>
                        <td class="text-center" v-if="selected.status.name == 'Confirmed'">
                            <span v-if="list.aesthetician">{{list.aesthetician.user.profile.firstname}} {{list.aesthetician.user.profile.lastname}}</span>
                            <span v-else>
                                <b-button @click="addA(list.id,list.service.category_id,selected.id)" variant="soft-danger" size="sm" v-b-tooltip.hover title="add" class="remove-list me-1">
                                    Add aesthetician
                                </b-button>
                            </span>
                        </td>
                         <td class="text-center" v-if="selected.status.name == 'Ongoing'">
                            <span v-if="list.status.name === 'Completed'">
                                Completed
                            </span>
                            <span v-else>
                                <b-button @click="markCompleted(list.id,selected.id)" variant="soft-danger" size="sm" v-b-tooltip.hover title="mark" class="remove-list me-1">
                                    Mark as completed
                                </b-button>
                            </span>
                         </td>
                        <td class="fs-12" :class="(selected.status.name == 'Pending') ? 'text-center' : 'text-end'" style="width: 25%;">{{formatMoney(list.service.price)}}</td>
                       
                        <td class="text-end" v-if="selected.status.name == 'Pending'">
                            <b-button @click="removeCart(index,selected.id,list)" variant="soft-danger" v-b-tooltip.hover title="Remove" size="sm" class="remove-list me-1" :disabled="(selected.lists.length == 1) ? true : false">
                                <i class="ri-delete-bin-fill align-bottom"></i>
                            </b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-nowrap align-middle mb-0">
                <tbody>
                    <tr class="table-light text-muted fs-12">
                        <td colspan="3">Subtotal : </td>
                        <td class="text-end">{{formatMoney(selected.total)}}</td>
                    </tr>
                    <tr class="table-light text-muted fs-12">
                        <td colspan="3">Discount : </td>
                        <td class="text-end">{{formatMoney(selected.discount)}}</td>
                    </tr>
                    <tr class="table-success fw-semibold">
                        <td colspan="3">Total : </td>
                        <td class="text-end">{{formatMoney(selected.total)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="selected.review" class="alert alert-info alert-dismissible material-shadow mt-3" role="alert" aria-live="polite" aria-atomic="true" show="">
            Comment : {{selected.review.comment}} <br /><br />
            <vue3-star-ratings :disableClick="true" :numberOfStars="5" v-model="selected.review.rating"/>
        </div>
        <hr class="text-muted mb-n2"/>
        <template v-slot:footer>
            <b-button v-if="selected.status.name === 'Pending'" @click="openSave(21,'Cancel')" variant="danger" block>Cancel Booking</b-button>
            <b-button v-if="selected.status.name === 'Pending' && client === false" @click="openSave(22,'Confirm')" variant="primary" :disabled="form.processing" block>Mark as Confirmed</b-button>
            <b-button v-if="selected.status.name === 'Confirmed' && client === false" @click="save(23)" variant="info" :disabled="(nullCount == 0) ? false : true" block>Mark as Ongoing</b-button>
            <b-button v-if="selected.status.name === 'Ongoing' && client === false" @click="save(20)" variant="success" :disabled="(pendingCount == 0) ? false : true" block>Mark as Completed</b-button>
            
            <b-button v-if="selected.status.name === 'Completed'" @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
    <More @message="update" ref="more"/>
    <A @message="update" ref="a"/>
    <C @update="hide" ref="confirm"/>
</template>
<script>
import A from './A.vue';
import C from './C.vue';
import More from './More.vue';
import vue3StarRatings from "vue3-star-ratings";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect, vue3StarRatings, More, A, C },
    props: ['specialists','categories','users'],
    data(){
        return {
            selected: {
                user: {
                    profile: {}
                },
                lists: [],
                status: {},
                review: {}
            },
            form: {},
            showModal: false,
            editable: false,
            client: false
        }
    },
    computed: {
        nullCount() {
           return this.selected.lists.filter(item => item.aesthetician === null).length;
        },
        pendingCount() {
           return this.selected.lists.filter(item => item.status.name === 'Pending').length;
        }
    },
    methods : {
        show(data) {
            this.selected = data;
            this.showModal = true;
        },
        view(data){
            this.client = true;
            this.selected = data;
            this.showModal = true;
        },
        openSave(status,type){
           this.$refs.confirm.show(status,type,this.selected.id);
        },
        save(status){
            this.form = this.$inertia.form({
                id: this.selected.id,
                status_id: status
            });

            this.form.put('/appointments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        hide(){
            this.showModal = false;
        },
        addMore(){
            this.$refs.more.show(this.selected.lists,this.selected.id);
        },
        removeCart(index,id,service){
            this.form = this.$inertia.form({
                service: service,
                appointment_id: id,
                option: 'remove'
            })

            this.form.post('/appointments',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.selected = this.$page.props.flash.data;
                },
            });
            this.selected.lists.splice(this.selected.lists.indexOf(index), 1);
        },
        update(data){
            this.selected = data;
        },
        addA(id,category_id,appointment_id){
            this.$refs.a.show(id,category_id,appointment_id);
        },
        markCompleted(id,selected){
            this.form = this.$inertia.form({
                id: id,
                selected: selected,
                option: 'completed'
            });

            this.form.put('/appointments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.selected = this.$page.props.flash.data;
                },
            });
        }
    }
}
</script>