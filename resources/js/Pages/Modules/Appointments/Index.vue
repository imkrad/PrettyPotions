<template lang="">
    <div class="row">
        <div class="col-md-12 mb-n3">
            <div class="card">
                <div class="card-body">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between" style="margin: -15px 0 -14px 0;">
                        <h4 class="mb-sm-0">LIST OF APPOINTMENTS</h4>
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
                        <b-col md="9">
                            <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search User"
                                v-model="filter.keyword" />
                            <i class="ri-search-line search-icon"></i>
                            </div>
                        </b-col>
                        <b-col md="2">
                           
                        </b-col>
                        <b-col md="1">
                            <!-- <b-button variant="primary" class="w-100" @click="openCreate()">Create</b-button> -->
                        </b-col>
                    </b-row>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 25%;">Code</th>
                                    <th style="width: 22%;" class="text-center">Client</th>
                                    <th style="width: 10%;" class="text-center">Date</th>
                                    <th style="width: 10%;" class="text-center">Services</th>
                                    <th style="width: 15%;" class="text-center">Rating</th>
                                    <th style="width: 15%;" class="text-center">Status</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                    <td>{{ ((meta.current_page - 1) * meta.per_page) + index + 1 }}</td>
                                    <td>{{list.code}}</td>
                                    <td class="text-center">{{list.user.profile.lastname}}, {{list.user.profile.firstname}}</td>
                                    <td class="text-center">{{list.date}}</td>
                                    <td class="text-center">{{list.lists.length}}</td>
                                    <td class="text-center">{{(list.review) ? list.review.rating : 'n/a'}}</td>
                                    <td class="text-center">
                                        <span class="badge" :class="list.status.color">{{list.status.name}}</span>
                                    </td>
                                    <td class="text-end">
                                        <b-button variant="soft-info"  @click="openView(list)" v-b-tooltip.hover title="View" size="sm" class="remove-list me-1">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                        <b-button v-if="list.status.name === 'Pending'" variant="soft-danger"  @click="openEdit(list,index)" v-b-tooltip.hover title="View" size="sm" class="remove-list me-1">
                                            <i class="ri-pencil-fill align-bottom"></i>
                                        </b-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <View ref="view"/>
    <Create :categories="categories.data" ref="create"/>
</template>
<script>
import View from '../Home/Management/Modals/View.vue';
import Create from './Create.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['categories'],
    components: { Pagination, Multiselect, Create, View },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                specialist: null,
            },
        }
    },
    created(){
        this.fetch();
    },
    watch:{
        "filter.specialist"(){
            this.fetch();
        },
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/appointments';
            axios.get(page_url,{
                params : {
                    keyword : this.filter.keyword,
                    specialist: this.filter.specialist,
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
        openCreate(){
            this.$refs.create.show();
        },
        openView(data){
            this.$refs.view.show(data);
        },
        openEdit(data,index){
            this.type = 'edit';
            this.index = index;
            this.$refs.create.edit(data);
        },
        refresh(){
            this.fetch();
        }
    },
}
</script>