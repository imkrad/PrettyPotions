<template lang="">
   <div class="row">
        <div class="col-xl-12 mt-n2">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <div class="col" v-for="(item, index) of counts" :key="index">
                            <div class="py-3 px-3">
                                <h5 class="text-muted text-uppercase fs-13">{{item.name}} <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i :class="item.icon" class="display-6 text-muted fs-18"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0 fs-20">
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

            <BRow class="row-cols-xxl-4 mt-n4 g-3">
                <BCol>
                    <BCard no-body class="mb-3">
                        <BLink class="card-header bg-warning-subtle" role="button">
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Pending Appointments</h5>
                            <p class="text-muted mb-0">{{counts[0].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) in pendingAppointments" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{ item.code }} <span class="text-muted fs-11">({{ item.user.profile.firstname }} {{ item.user.profile.lastname }})</span></h6>
                                    <p class="fs-12 text-muted mb-n1">Created At : {{ item.created_at }}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                    <div class="d-flex justify-content-center mt-2" v-if="pendingAppointments.length > 0">
                        <ul class="pagination">
                            <li class="page-item" @click="prevPage1" :class="{'disabled': currentPage1 === 1}" :disabled="currentPage1 === 1" ><a class="page-link" href="#" target="_self" tabindex="-1">← &nbsp; Prev</a></li>
                            <li class="page-item" 
                                v-for="page in visiblePageNumbers1" 
                                :key="page" 
                                @click="goToPage1(page)" 
                                :class="{'btn-primary': currentPage1 === page}">
                                <a class="page-link" href="#" target="_self"> {{ page }}</a>
                            </li>
                            <li class="page-item" @click="nextPage1" :class="{'disabled': currentPage1 === totalPages1}" :disabled="currentPage1 === totalPages1"><a class="page-link" href="#" target="_self">Next &nbsp; →</a></li>
                        </ul>
                    </div>
                </BCol>
                <BCol>
                    <BCard no-body class="mb-3">
                        <BLink class="card-header bg-info-subtle" role="button" v-b-toggle.leadDiscovered>
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Incoming Appointments</h5>
                            <p class="text-muted mb-0">{{counts[1].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) of incomingAppointments" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <!-- <button type="button" @click="openNotify(item)" class="btn btn-info float-end">Notify</button> -->
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{item.code}} <span class="text-muted fs-11">({{item.user.profile.firstname}} {{item.user.profile.lastname}})</span></h6>
                                    <p class="fs-12 text-muted mb-n1">Created At : {{item.created_at}}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                    <div class="d-flex justify-content-center mt-2" v-if="incomingAppointments.length > 0">
                        <ul class="pagination">
                            <li class="page-item" @click="prevPage2" :class="{'disabled': currentPage2 === 1}" :disabled="currentPage2 === 1" ><a class="page-link" href="#" target="_self" tabindex="-1">← &nbsp; Prev</a></li>
                            <li class="page-item" 
                                v-for="page in visiblePageNumbers2" 
                                :key="page" 
                                @click="goToPage2(page)" 
                                :class="{'btn-primary': currentPage2 === page}">
                                <a class="page-link" href="#" target="_self"> {{ page }}</a>
                            </li>
                            <li class="page-item" @click="nextPage2" :class="{'disabled': currentPage2 === totalPages2}" :disabled="currentPage2 === totalPages2"><a class="page-link" href="#" target="_self">Next &nbsp; →</a></li>
                        </ul>
                    </div>
                </BCol>
                <BCol>
                    <BCard no-body class="mb-3">
                        <BLink class="card-header bg-primary-subtle" role="button" v-b-toggle.leadDiscovered>
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Ongoing Appointments</h5>
                            <p class="text-muted mb-0">{{counts[1].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) of ongoingAppointments" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{item.code}} <span class="text-muted fs-11">({{item.user.profile.firstname}} {{item.user.profile.lastname}})</span></h6>
                                    <p class="fs-12 text-muted mb-n1">Created At : {{item.created_at}}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                    <div class="d-flex justify-content-center mt-2" v-if="ongoingAppointments.length > 0">
                        <ul class="pagination">
                            <li class="page-item" @click="prevPage3" :class="{'disabled': currentPage3 === 1}" :disabled="currentPage3 === 1" ><a class="page-link" href="#" target="_self" tabindex="-1">← &nbsp; Prev</a></li>
                            <li class="page-item" 
                                v-for="page in visiblePageNumbers3" 
                                :key="page" 
                                @click="goToPage3(page)" 
                                :class="{'btn-primary': currentPage3 === page}">
                                <a class="page-link" href="#" target="_self"> {{ page }}</a>
                            </li>
                            <li class="page-item" @click="nextPage3" :class="{'disabled': currentPage3 === totalPages3}" :disabled="currentPage3 === totalPages3"><a class="page-link" href="#" target="_self">Next &nbsp; →</a></li>
                        </ul>
                    </div>
                </BCol>
                <BCol>
                    <BCard no-body class="mb-3">
                        <BLink class="card-header bg-success-subtle" role="button" v-b-toggle.leadDiscovered>
                            <h5 class="card-title text-uppercase fw-semibold mb-1 fs-12">Completed Appointments</h5>
                            <p class="text-muted mb-0">{{counts[2].total}} appointments</p>
                        </BLink>
                    </BCard>
                    <BCard no-body class="mb-1" v-for="(item, index) of completedAppointments" :key="index">
                        <BCardBody>
                            <BLink class="d-flex align-items-center" role="button" @click="openView(item)">
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-12 mb-1">{{item.code}} <span class="text-muted fs-11">({{item.user.profile.firstname}} {{item.user.profile.lastname}})</span></h6>
                                    <p class="fs-12 text-muted mb-n1">Created At : {{item.created_at}}</p>
                                </div>
                            </BLink>
                        </BCardBody>
                    </BCard>
                    <div class="d-flex justify-content-center mt-2" v-if="completedAppointments.length > 0">
                        <ul class="pagination">
                            <li class="page-item" @click="prevPage4" :class="{'disabled': currentPage4 === 1}" :disabled="currentPage4 === 1" ><a class="page-link" href="#" target="_self" tabindex="-1">← &nbsp; Prev</a></li>
                            <li class="page-item" 
                                v-for="page in visiblePageNumbers4" 
                                :key="page" 
                                @click="goToPage4(page)" 
                                :class="{'btn-primary': currentPage4 === page}">
                                <a class="page-link" href="#" target="_self"> {{ page }}</a>
                            </li>
                            <li class="page-item" @click="nextPage4" :class="{'disabled': currentPage4 === totalPages4}" :disabled="currentPage4 === totalPages4"><a class="page-link" href="#" target="_self">Next &nbsp; →</a></li>
                        </ul>
                    </div>
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
            lists: false,
            currentPage1: 1,
            currentPage2: 1,
            currentPage3: 1,
            currentPage4: 1,
            itemsPerPage: 5
        }
    },
    computed: {
        pendingAppointments() {
            const start = (this.currentPage1 - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.appointments.pending.slice(start, end);
        },
        incomingAppointments() {
            const start = (this.currentPage2 - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.appointments.incoming.slice(start, end);
        },
        ongoingAppointments() {
            const start = (this.currentPage3 - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.appointments.ongoing.slice(start, end);
        },
        completedAppointments() {
            const start = (this.currentPage4 - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.appointments.completed.slice(start, end);
        },
        totalPages1() {
            return Math.ceil(this.appointments.pending.length / this.itemsPerPage);
        },
        totalPages2() {
            return Math.ceil(this.appointments.incoming.length / this.itemsPerPage);
        },
        totalPages3() {
            return Math.ceil(this.appointments.ongoing.length / this.itemsPerPage);
        },
        totalPages4() {
            return Math.ceil(this.appointments.completed.length / this.itemsPerPage);
        },
        visiblePageNumbers1() {
            const maxVisible = 3;
            let startPage = Math.max(this.currentPage1 - Math.floor(maxVisible / 2), 1);
            let endPage = startPage + maxVisible - 1;

            if (endPage > this.totalPages1) {
                endPage = this.totalPages1;
                startPage = Math.max(endPage - maxVisible + 1, 1);
            }

            const pages = [];
            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }
            return pages;
        },
        visiblePageNumbers2() {
            const maxVisible = 3;
            let startPage = Math.max(this.currentPage2 - Math.floor(maxVisible / 2), 1);
            let endPage = startPage + maxVisible - 1;

            if (endPage > this.totalPages2) {
                endPage = this.totalPages2;
                startPage = Math.max(endPage - maxVisible + 1, 1);
            }

            const pages = [];
            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }
            return pages;
        },
        visiblePageNumbers3() {
            const maxVisible = 3;
            let startPage = Math.max(this.currentPage3 - Math.floor(maxVisible / 2), 1);
            let endPage = startPage + maxVisible - 1;

            if (endPage > this.totalPages3) {
                endPage = this.totalPages3;
                startPage = Math.max(endPage - maxVisible + 1, 1);
            }

            const pages = [];
            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }
            return pages;
        },
        visiblePageNumbers4() {
            const maxVisible = 3;
            let startPage = Math.max(this.currentPage4 - Math.floor(maxVisible / 2), 1);
            let endPage = startPage + maxVisible - 1;

            if (endPage > this.totalPages4) {
                endPage = this.totalPages4;
                startPage = Math.max(endPage - maxVisible + 1, 1);
            }

            const pages = [];
            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }
            return pages;
        }
    },
    methods: {
        nextPage1() {
            if (this.currentPage1 < this.totalPages1) {
                this.currentPage1++;
            }
        },
        nextPage2() {
            if (this.currentPage2 < this.totalPages2) {
                this.currentPage2++;
            }
        },
        nextPage3() {
            if (this.currentPage3 < this.totalPages3) {
                this.currentPage3++;
            }
        },
        nextPage4() {
            if (this.currentPage4 < this.totalPages4) {
                this.currentPage4++;
            }
        },
        prevPage1() {
            if (this.currentPage1 > 1) {
                this.currentPage1--;
            }
        },
        prevPage2() {
            if (this.currentPage2 > 1) {
                this.currentPage2--;
            }
        },
        prevPage3() {
            if (this.currentPage3 > 1) {
                this.currentPage3--;
            }
        },
        prevPage4() {
            if (this.currentPage4 > 1) {
                this.currentPage4--;
            }
        },
        goToPage1(page) {
            this.currentPage1 = page;
        },
        goToPage2(page) {
            this.currentPage2 = page;
        },
        goToPage3(page) {
            this.currentPage3 = page;
        },
        goToPage4(page) {
            this.currentPage4 = page;
        },
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