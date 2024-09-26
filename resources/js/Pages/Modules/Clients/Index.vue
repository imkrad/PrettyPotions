<template lang="">
    <div class="row">
        <div class="col-md-12 mb-n3">
            <div class="card">
                <div class="card-body">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between" style="margin: -15px 0 -14px 0;">
                        <h4 class="mb-sm-0">LIST OF CLIENTS</h4>
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
                        <b-col md="11">
                            <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search User"
                                v-model="filter.keyword" />
                            <i class="ri-search-line search-icon"></i>
                            </div>
                        </b-col>
                        <b-col md="1">
                            <b-button variant="primary" class="w-100" @click="openCreate()">Create</b-button>
                        </b-col>
                    </b-row>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 22%;" class="text-center">Email</th>
                                    <th style="width: 10%;" class="text-center">Mobile</th>
                                    <th style="width: 15%;" class="text-center">Gender</th>
                                    <th style="width: 15%;" class="text-center">Role</th>
                                    <th style="width: 15%;" class="text-center">Status</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                                    <td>{{ ((meta.current_page - 1) * meta.per_page) + index + 1 }}</td>
                                    <td>{{list.profile.lastname}}, {{list.profile.firstname}}</td>
                                    <td class="text-center">{{list.email}}</td>
                                    <td class="text-center">{{list.profile.mobile}}</td>
                                    <td class="text-center">{{list.profile.gender}}</td>
                                    <td class="text-center">{{list.role}}</td>
                                    <td class="text-center">
                                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                                        <span v-else class="badge bg-danger">Inactive</span>
                                    </td>
                                    <td class="text-end">
                                        <!-- <b-button variant="soft-success" @click="update('status',list,index)" v-b-tooltip.hover title="Lock" size="sm" class="remove-list me-1">
                                            <i class="ri-lock-2-fill align-bottom"></i>
                                        </b-button> -->
                                        <b-button variant="soft-warning"  @click="update('verification',list,index)" v-b-tooltip.hover title="Verify" size="sm" class="remove-list me-1">
                                            <i class="ri-mail-send-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openEdit(list,index)" variant="soft-primary" v-b-tooltip.hover title="Edit" size="sm" class="edit-list">
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
    <Create :roles="options" ref="create"/>
</template>
<script>
import Create from './Create.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Multiselect, Create },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                role: 'Client',
            },
        }
    },
    created(){
        this.fetch();
    },
    watch:{
        "filter.role"(){
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
            page_url = page_url || '/clients';
            axios.get(page_url,{
                params : {
                    keyword : this.filter.keyword,
                    role: this.filter.role,
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