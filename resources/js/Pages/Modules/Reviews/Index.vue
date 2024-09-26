<template lang="">
    <div class="row">
        <div class="col-md-12 mb-n3">
            <div class="card">
                <div class="card-body">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between" style="margin: -15px 0 -14px 0;">
                        <h4 class="mb-sm-0">LIST OF REVIEWS</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a class="" href="javascript: void(0);" target="_self">Client</a></li>
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
                        <b-col md="12">
                            <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search User"
                                v-model="filter.keyword" />
                            <i class="ri-search-line search-icon"></i>
                            </div>
                        </b-col>
                    </b-row>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 10%;">Code</th>
                                    <th style="width: 15%;" class="text-center">Client</th>
                                    <th style="width: 25%;" class="text-center">Rate</th>
                                    <th style="width: 40%;" class="text-center">Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                    <td>{{ ((meta.current_page - 1) * meta.per_page) + index + 1 }}</td>
                                    <td>{{list.appointment.code}}</td>
                                    <td class="text-center">{{list.user.profile.lastname}}, {{list.user.profile.firstname}}</td>
                                    <td class="text-center">{{list.rating}}</td>
                                    <td class="text-center">{{list.comment}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
            },
        }
    },
    created(){
        this.fetch();
    },
    watch:{
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/reviews';
            axios.get(page_url,{
                params : {
                    keyword : this.filter.keyword,
                    counts: ((window.innerHeight-350)/56),
                    option: 'lists'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;          
                }
            })
            .catch(err => console.log(err));
        },
    },
}
</script>