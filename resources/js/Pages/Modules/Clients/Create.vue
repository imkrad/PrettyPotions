<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">{{type}} Staff</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <form class="customform">
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                            <img src="/images/users/user-dummy-img.jpg"
                                class="rounded-circle avatar-lg img-thumbnail user-profile-image"
                                alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file"  @change="previewImage"
                                    class="profile-img-file-input">
                                <label for="profile-img-file-input"
                                    class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Firstname: <span v-if="form.errors" v-text="form.errors.firstname" class="haveerror"></span></label>
                                <input type="text" class="form-control" v-model="profile.firstname" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Middlename: <span v-if="form.errors" v-text="form.errors.middlename" class="haveerror"></span></label>
                                <input type="text" class="form-control" v-model="profile.middlename" style="text-transform: capitalize;"> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Lastname: <span v-if="form.errors" v-text="form.errors.lastname" class="haveerror"></span></label>
                                <input type="text" class="form-control" v-model="profile.lastname" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Suffix: <span v-if="form.errors" v-text="form.errors.suffix" class="haveerror"></span></label>
                                <input type="text" class="form-control" v-model="profile.suffix" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email: <span v-if="form.errors" v-text="form.errors.email" class="haveerror"></span></label>
                                <input type="email" class="form-control" v-model="user.email" style="text-transform: lowercase;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Mobile No.: <span v-if="form.errors" v-text="form.errors.mobile" class="haveerror"></span></label>
                                <input type="text" class="form-control" v-model="profile.mobile">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Username: <span v-if="form.errors" v-text="form.errors.username" class="haveerror"></span></label>
                                <input type="text" class="form-control" v-model="user.username" style="text-transform: lowercase;">
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top: -1px; margin-bottom: -15px;">
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="customRadio1" class="custom-control-input me-2"  value="Male" v-model="profile.gender">
                                        <label class="custom-control-label" for="customRadio1">Male</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" id="customRadio2" class="custom-control-input me-2" value="Female" v-model="profile.gender">
                                        <label class="custom-control-label" for="customRadio2">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Role: <span v-if="form.errors" v-text="form.errors.role" class="haveerror"></span></label>
                                <Multiselect 
                                v-model="user.role" 
                                :options="roles"
                                :allow-empty="false"
                                :show-labels="false"
                                placeholder="Select Role"/>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="showProvince">
                            <div class="form-group mb-4">
                                <label>Province: <span v-if="form.errors" v-text="form.errors.province" class="haveerror"></span></label>
                                    <multiselect 
                                    v-model="user.province" 
                                    :options="provinces"
                                    :allow-empty="false"
                                    :show-labels="false"
                                    label="name" track-by="code"
                                    placeholder="Select Province">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="showSchool">
                            <div class="form-group mb-4">
                                <label>School: <span v-if="form.errors" v-text="form.errors.school" class="haveerror"></span></label>
                                <multiselect 
                                v-model="user.school" 
                                :options="schools"
                                :allow-empty="false"
                                :show-labels="false"
                                @search-change="asyncSchool"
                                label="name" track-by="id"
                                placeholder="Select School">
                            </multiselect>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>{{type}}</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    props: ['roles'],
    components : { Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            user: {
                id: '',
                email: '',
                avatar: '',
                role: null,
                username: ''
            },
            profile: {
                id:'',
                firstname: '',
                lastname: '',
                middlename: '',
                suffix: '',
                gender: '',
                mobile: '',
            },

            form: {},
            type: '',
            showModal: false,
            editable: false
        }
    },
    methods: {
        create() {
            this.form = this.$inertia.form({
                id: this.user.id,
                username: this.user.username,
                firstname: this.profile.firstname,
                lastname: this.profile.lastname,
                middlename: this.profile.middlename,
                suffix: this.profile.suffix,
                email: this.user.email,
                mobile: this.profile.mobile,
                gender: this.profile.gender,
                role: this.user.role,
                img: (this.editable) ? '' : this.user.avatar,
                editable: this.editable
            })

            if(!this.editable){
                this.form.post('/staffs',{
                    forceFormData: true,
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    }
                });
            }else{
                this.form.put('/staffs/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    }
                });
            }
        },
        show(){
            this.user = {},
            this.type = 'Create';
            this.editable = false;
            this.showModal = true;
        },
        edit(data){
            this.editable = true;
            this.user = data;
            this.profile = data.profile;
            this.type = 'Update';
            this.showModal = true;
        },
        hide(){
            this.$parent.fetch();
            this.form = {};
            this.user = {};
            this.profile = {};
            this.showModal = false;
            this.editable = false;
        },
        previewImage(e) {
            var preview = document.querySelector(".user-profile-image");
            var file = document.querySelector(".profile-img-file-input").files[0];
            var reader = new FileReader();
            reader.addEventListener("load", function () { preview.src = reader.result; }, false);
            reader.onload = (e) => { this.user.avatar = e.target.result; };
            if (file) { reader.readAsDataURL(file); }
        },
    }
}
</script>
<style>
.multiselect__single {
    font-size: 12px;
}
</style>