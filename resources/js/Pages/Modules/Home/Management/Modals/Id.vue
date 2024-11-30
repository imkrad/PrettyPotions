<template>
    <b-modal v-model="showModal" title="View Identification Card" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
       <img style="width: 100%; height:auto;" :src="currentUrl+'/imagess/cards/'+selected"  alt=".">
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            showModal: false
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