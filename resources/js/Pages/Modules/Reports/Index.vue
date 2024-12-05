<template lang="">
    <div class="row">
        <div class="col-md-12 mb-n3">
            <div class="card">
                <div class="card-body">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between" style="margin: -15px 0 -14px 0;">
                        <h4 class="mb-sm-0">Reports</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a class="" href="javascript: void(0);" target="_self">Reports</a></li>
                                <li class="breadcrumb-item"><a class="" href="javascript: void(0);" target="_self">Lists</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="height: calc(100vh - 255px); overflow: hidden;">
                    <b-row class="g-2 mb-2">
                        <!-- <b-col md="8">
                            <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search Service"
                                v-model="filter.keyword" />
                            <i class="ri-search-line search-icon"></i>
                            </div>
                        </b-col> -->
                        <b-col md="4">
                            <Multiselect class="form-control" v-model="filter.category" 
                            :close-on-select="true" placeholder="Select Type"
                            :searchable="true" :create-option="true" 
                            :options="['Daily','Monthly','Yearly']" label="name" track-by="name"/>
                        </b-col>
                        <b-col md="3" v-if="filter.category == 'Daily'">
                            <input type="date" class="form-control search" placeholder="Search Date"
                            v-model="filter.target" />
                        </b-col>
                        <b-col md="3" v-if="filter.category == 'Monthly'">
                            <Multiselect class="form-control" v-model="filter.target" 
                            :close-on-select="true" placeholder="Select Type"
                            :searchable="true" :create-option="true" 
                            :options="months" label="name" track-by="name"/>
                        </b-col>
                        <b-col md="3" v-if="filter.category == 'Yearly' || filter.category == 'Monthly'">
                            <input type="text" class="form-control" placeholder="Select Year"
                            v-model="filter.year" />
                        </b-col>
                        <b-col md="2">
                            <b-button variant="primary" class="w-100" @click="openReport()">Generate</b-button>
                        </b-col>
                    </b-row>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            filter: {
                target: null,
                category: null,
                year: new Date().getFullYear(),
            },
            months: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
        }
    },
    watch:{
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
    },
    methods: {
        openReport(){
            window.open('/appointments?option=report&category='+this.filter.category+'&target='+this.filter.target+'&year='+this.filter.year);
        }
    },
}
</script>