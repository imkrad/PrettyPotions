<template>
    <b-modal v-model="showModal" title="Service Image" hide-footer header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12 text-center" style="margin-top: -2px;">
                    <div class="profile-user position-relative d-inline-block mx-auto mb-3">
                        <img :src="src" class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow">
                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                            <input id="profile-img-file-input" type="file" class="profile-img-file-input" @change="previewImage"/>
                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                <span class="avatar-title rounded-circle bg-light text-body">
                                <i class="ri-camera-fill"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>
<script>
import { useForm } from "@inertiajs/vue3"
export default {
    data(){
        return {
            id: null,
            src: null,
            form: useForm({
                image: null,
                id: null,
            }),
            showModal: false,
            editable: false,
        }
    },
    methods : {
        previewImage(e) {
            var fileInput = document.querySelector(".profile-img-file-input");
            var preview = document.querySelector(".user-profile-image");
            var file = fileInput.files[0];
            this.form.image = file;
            this.form.id = this.id;
            var reader = new FileReader();

            reader.addEventListener("load", () => { 
                preview.src = reader.result;
                this.form.post('/profile', {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                    onSuccess: () => '',
                });
            }, false);

            if (file) { 
                reader.readAsDataURL(file); 
            }
        },
        show(data) {
            this.id = data.id;
            this.src = (data.image == 'avatar.jpg') ? 'imagess/'+data.image :  data.image;
            this.showModal = true;
        },

        hide(){
            this.showModal = false;
        },
    }
}
</script>