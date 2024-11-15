<template lang="">
   <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <div class="col" v-for="(item, index) of counts" :key="index">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">{{item.name}} <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i :class="item.icon" class="display-6 text-muted cfs-22"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0 cfs-22">
                                            <span v-if="!item.money" class="counter-value" data-target="197">{{item.total}}</span>
                                            <span v-else class="counter-value" data-target="197">{{formatMoney(item.total)}}</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-n3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <button @click="openCalendar()" class="btn btn-info">View Calendar</button>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex hastck gap-2 flex-wrap">
                                <button @click="openCustomer()" class="btn btn-danger"><i class="ri-add-fill align-bottom me-1"></i> New Customer</button>
                                <button @click="openNew()" class="btn btn-success"><i class="ri-add-fill align-bottom me-1"></i> Walkin Appointment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <BRow class="row-cols-xxl-4 mt-n2">
                <BCol>
                    <BCard no-body>
                        <BLink class="card-header bg-warning-subtle" role="button">
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Pending Appointments</h5>
                            <p class="text-muted mb-0">{{counts[0].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) of appointments.pending" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{item.code}} <span class="text-muted fs-11">({{item.user.profile.firstname}} {{item.user.profile.lastname}})</span></h6>
                                    <p class="fs-11 text-muted mb-0">Booking Date : {{item.date}}</p>
                                    <p class="fs-11 text-muted mb-n1">Created At : {{item.created_at}}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                </BCol>
                <BCol>
                    <BCard no-body>
                        <BLink class="card-header bg-info-subtle" role="button" v-b-toggle.leadDiscovered>
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Incoming Appointments</h5>
                            <p class="text-muted mb-0">{{counts[1].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) of appointments.incoming" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <button type="button" @click="openNotify(item)" class="btn btn-info float-end">Notify</button>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{item.code}} <span class="text-muted fs-11">({{item.user.profile.firstname}} {{item.user.profile.lastname}})</span></h6>
                                    <p class="fs-11 text-muted mb-0">Booking Date : {{item.date}}</p>
                                    <p class="fs-11 text-muted mb-n1">Created At : {{item.created_at}}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                </BCol>
                <BCol>
                    <BCard no-body>
                        <BLink class="card-header bg-primary-subtle" role="button" v-b-toggle.leadDiscovered>
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Ongoing Appointments</h5>
                            <p class="text-muted mb-0">{{counts[1].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) of appointments.ongoing" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{item.code}} <span class="text-muted fs-11">({{item.user.profile.firstname}} {{item.user.profile.lastname}})</span></h6>
                                    <p class="fs-11 text-muted mb-0">Booking Date : {{item.date}}</p>
                                    <p class="fs-11 text-muted mb-n1">Created At : {{item.created_at}}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                </BCol>
                <BCol>
                    <BCard no-body>
                        <BLink class="card-header bg-success-subtle" role="button" v-b-toggle.leadDiscovered>
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Completed Appointments</h5>
                            <p class="text-muted mb-0">{{counts[2].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) of appointments.completed" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{item.code}} <span class="text-muted fs-11">({{item.user.profile.firstname}} {{item.user.profile.lastname}})</span></h6>
                                    <p class="fs-11 text-muted mb-0">Booking Date : {{item.date}}</p>
                                    <p class="fs-11 text-muted mb-n1">Created At : {{item.created_at}}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                </BCol>
            </BRow>
        </div>
    </div>
    <Create :categories="categories" ref="create"/>
    <View ref="view"/>
    <Register ref="register"/>
    <Calendar ref="calendar"/>
</template>
<script>
import simplebar from "simplebar-vue";
import Calendar from './Modals/Calendar.vue';
import Register from '../../../Register.vue';
import Create from './Modals/Create.vue';
import View from './Modals/View.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    props: ['categories','counts','appointments'],
    components: { Multiselect, View, Create, Register, Calendar, simplebar },
    data(){
        return {
            filter : {
                keyword: null,
                category: null
            },
            cart: [],
            discount: 0,
            subtotal: 0,
            total: 0,
            lists: false
        }
    },
    methods: {
        openView(data){
            this.$refs.view.show(data);
        },
        openNew(){
            this.$refs.create.show();
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        openNotify(data){
            this.form = this.$inertia.form({
                list: data,
                option: 'notify'
            });

            this.form.put('/appointments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        openCustomer(){
             this.$refs.register.show();
        },
        openCalendar(){
            this.$refs.calendar.show();
        }
    }
}
</script>