<template>
<Head title="Login" />
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-page-content">
            <b-container>


                <b-row class="justify-content-center">
                    <b-col md="8" lg="6" xl="5">
                        <b-card no-body class="mt-4">
                            <b-card-body class="p-4">
                                    <div class="row mb-n3">
                                        <div class="col-2">
                                            <img src="/imagess/logo-sm.png" alt="" class="avatar-sm">
                                        </div>
                                        <div class="col-10">
                                            <div class="text-primary mt-1">
                                                <h4>DOST - STSIMS</h4>
                                                <p class="mt-n2">Reset Password</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <b-alert v-model="authError" variant="danger" class="mt-3" dismissible>{{ authError }}</b-alert>
                                    <div>

                                </div>

                                <form class="customform" @submit.prevent="submit">
                                    <div class="mb-2">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Enter email" v-model="form.email" />
                                        <div class="invalid-feedback">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input :type="(!form.showPassword) ? 'password' : 'text'"  v-model="form.password" class="form-control pe-5" placeholder="Enter password" id="password-input" />
                                            <b-button @click="toggleShow" variant="link" class="position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon">
                                                <i class="ri-eye-fill align-middle"></i>
                                            </b-button>
                                            <div class="invalid-feedback">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label" for="password-input">Confirm Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input :type="(!form.showPassword) ? 'password' : 'text'"  v-model="form.password_confirmation" class="form-control pe-5" placeholder="Enter password" id="password-input" />
                                            <div class="invalid-feedback">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div v-if="Object.keys(form.errors).length != 0" class="alert alert-warning text-center mt-4 mb-4" role="alert" v-text="form.errors.email"></div>
                                        <b-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" variant="primary" class="w-100" type="submit">
                                            Reset Password
                                        </b-button>
                                    </div>

                                </form>
                                </div>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
            </b-container>
        </div>

      
  </div>
</template>
<script>
export default {
    layout: null,
   
}
</script>
<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
    showPassword: false
});

const submit = () => {
    form.post('/reset-password');
};

const toggleShow = () => {
    if(form.showPassword){
        form.showPassword = false;
    }else{
        form.showPassword = true;
    }
};
</script>


