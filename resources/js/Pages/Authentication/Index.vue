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
                                    <img src="imagess/logo-sm.png" alt="" class="avatar-sm">
                                </div>
                                <div class="col-10">
                                    <div class="text-primary mt-1">
                                        <h4>PRETTY POTIONS</h4>
                                        <p class="mt-n2">Sign In to continue</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 mt-4">
                                <b-alert v-model="authError" variant="danger" class="mt-3" dismissible>{{ authError }}</b-alert>
                            <div>

                        </div>

                        <form class="customform" @submit.prevent="submit">
                            <div class="mb-3">
                            <label for="email" class="form-label">Username</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter email" v-model="form.email" />
                            <div class="invalid-feedback">
                                <span></span>
                            </div>
                            </div>

                            <div class="mb-3">
                         
                            <label class="form-label" for="password-input">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input :type="(!form.showPassword) ? 'password' : 'text'"  v-model="form.password" class="form-control pe-5" placeholder="Enter password"
                                id="password-input" />
                                <b-button @click="toggleShow" variant="link" class="position-absolute end-0 top-0 text-decoration-none text-muted"
                                type="button" id="password-addon">
                                <i class="ri-eye-fill align-middle"></i>
                                </b-button>
                                <div class="invalid-feedback">
                                <span></span>
                                </div>
                            </div>
                            </div>

                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check" />
                            <label class="form-check-label" for="auth-remember-check">Remember
                                me</label>
                            </div>

                            <div class="mt-4">
                                 <div v-if="Object.keys(form.errors).length != 0" class="alert alert-warning text-center mt-4 mb-4" role="alert" v-text="form.errors.email"></div>
                                <b-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" variant="primary" class="w-100" type="submit">
                                    Sign In
                                </b-button>
                            </div>
                            <!-- <div class="mt-4 text-center">
                                <p class="mb-0">Forgot your password? 
                                    <Link href="/forgot-password" class="fw-semibold text-primary text-decoration-underline"> Click here</Link>
                                </p>
                            </div> -->

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

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post('login', {
        onFinish: () => form.reset('password'),
    });
};
const toggleShow = () => {
    if(form.showPassword){
        form.showPassword = false;
    }else{
        form.showPassword = true;
    }
};
</script>
<style>
.auth-page-wrapper {
    background-color: #fab9d2;
}
</style>