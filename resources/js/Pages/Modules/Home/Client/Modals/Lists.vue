<template>
    <b-modal v-model="showModal" size="lg" title="List of Services"  header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 3%;">#</th>
                                    <th style="width: 20%;">Service</th>
                                    <th style="width: 15%;" class="text-center">Price</th>
                                    <th style="width: 15%;" class="text-center">Status</th>
                                    <th style="width: 10%;" class="text-center">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ list.service.service }}</td>
                                    <td class="text-center">{{formatMoney(list.price)}}</td>
                                    <td class="text-center">
                                        <span class="badge" :class="list.status.color">{{list.status.name}}</span>
                                    </td>
                                    <td class="text-center">
                                        <b-button v-if="!list.rating" variant="soft-info"  @click="openRate(list,index)" v-b-tooltip.hover title="View" size="sm" class="me-1" :disabled="list.status.name !== 'Completed'">
                                             Rate now
                                        </b-button>
                                        <span v-else>{{list.rating}}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
    <Rate @message="update" ref="rate"/>
</template>
<script>
import Rate from './Rate.vue';
export default {
    components: { Rate },
    data(){
        return {
            lists: null,
            index: null,
            showModal: false,
        }
    },
    methods : {
        show(lists) {
            this.lists = lists;
            this.showModal = true;
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        openRate(list,index){
            this.index = index;
            this.$refs.rate.show(list.id);
        },
        update(data){
            this.lists[this.index] = data;
        },
        hide(){
            this.showModal = false;
        },
    }
}
</script>