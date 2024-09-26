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
                                        <h4>DOST - STSIMS</h4>
                                        <p class="mt-n2">Forgot Password</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 mt-4">
                                <b-alert v-model="authError" variant="danger" class="mt-3" dismissible>{{ authError }}</b-alert>
                            <div>

                        </div>

                        <form class="customform" @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="Enter email" v-model="form.email" />
                                <div class="invalid-feedback">
                                    <span></span>
                                </div>
                            </div>

                            <div class="mb-n2 alert alert-success alert-dismissible" role="alert" v-if="status">
                                <strong>{{status}}</strong> 
                                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
                            </div>


                            <div class="mt-4">
                                 <div v-if="Object.keys(form.errors).length != 0" class="alert alert-warning text-center mt-4 mb-4" role="alert" v-text="form.errors.email"></div>
                                <b-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" variant="primary" class="w-100" type="submit">
                                    Email Password Reset Link
                                </b-button>
                            </div>

                            <div class="mt-4 text-center">
                                <p class="mb-0">Login now.
                                    <Link href="/login" class="fw-semibold text-primary text-decoration-underline"> Click here</Link>
                                </p>
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

    defineProps({
        status: String,
    });

    const form = useForm({
        email: '',
    });

    const submit = () => {
        form.post('/forgot-password');
    };

</script>
