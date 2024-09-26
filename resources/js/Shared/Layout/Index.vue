<script>
import { layoutComputed } from "@/State/helpers";
import Vertical from "./Vertical.vue";

export default {
    props: ['auth'],
    components: { Vertical },
    data() {
        return {};
    },
    computed: {
        ...layoutComputed,
        message() {
            return (this.$page.props.flash.message) ?  true : false;
        }
    },
    methods: {
        check(){
            this.$page.props.flash.message = '';
            this.message = false;
        }
    }
};
</script>

<template>
    <div>
        <Vertical :auth="auth">
            <slot />
        </Vertical>
    </div>
    <b-modal v-model="message" hide-footer class="v-modal-custom" modal-class="zoomIn" body-class="p-0" centered hide-header-close style="z-index: 5000;">
        <div class="text-end me-4">
            <button type="button" class="btn-close text-end" @click="check()"></button>
        </div>
        <div class="text-center px-5 pt-2">
            <div class="mt-2">
                 <div class="avatar-md mx-auto">
                    <div class="avatar-title rounded-circle bg-light">
                        <i v-if="$page.props.flash.status" class="ri-checkbox-circle-fill text-success h1 mb-0"></i>
                        <i v-else class="ri-close-circle-fill text-danger h1 mb-0"></i>
                    </div>
                </div>
                <h5 class="mb-3 mt-4">{{$page.props.flash.message }}</h5>
                <p v-if="$page.props.flash.info" class="text-muted fs-10">{{$page.props.flash.info }}</p>
            </div>
        </div>
    </b-modal>
</template>
