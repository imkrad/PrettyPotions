<template>
    <Head title="Science and Technology Scholarship Information System" />
    <div class="layout-wrapper landing">
        <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <b-container>
                <b-link class="navbar-brand" href="/">
                    <img src="imagess/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark"
                        height="25">
                    <img src="imagess/logo-light.png" class="card-logo card-logo-light" alt="logo light"
                        height="17">
                </b-link>
                <button class="navbar-toggler py-0 fs-20 text-body" type="button" v-b-toggle.navbarSupportedContent>
                    <i class="mdi mdi-menu"></i>
                </button>
                <b-collapse class="navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                       
                    </ul>
                    <div class="">
                        <Link href="/login" class="btn btn-primary">Sign In</Link>
                        <button @click="openRegister()" class="btn btn-info ms-1">Register</button>
                    </div>
                </b-collapse>
            </b-container>
        </nav>

        <section class="section job-hero-section bg-light pb-0" id="hero">
            <b-container>
                <b-row class="justify-content-between align-items-center">
                    <b-col lg="6">
                        <div>
                            <h1 class="display-6 fw-semibold text-capitalize mb-3 lh-base">PP - Pretty Potions</h1>
                            <p class="lead text-muted lh-base mb-4">At Pretty Potion, we specialize in enhancing your natural allure and revealing the radiant beauty that lies within you. Our clinic offers a magical experience tailored to rejuvenate your skin, sculpt your body, accentuate your brows and lashes, and pamper your nails.</p>
                            <form action="#" class="job-panel-filter">
                                <b-row class="g-md-0 g-2">
                                    <b-col md="4">
                                        <div>
                                            <input type="search" id="job-title" class="form-control filter-input-box"
                                                placeholder="services...">
                                        </div>
                                    </b-col>
                                    <b-col md="4">
                                        <div>
                                            <select class="form-control" data-choices>
                                                <option value="">Select service</option>
                                            </select>
                                        </div>
                                    </b-col>
                                    <b-col md="4">
                                        <div class="h-100">
                                            <b-button variant="primary" class="submit-btn w-100 h-100" type="submit"><i
                                                    class="ri-search-2-line align-bottom me-1"></i> Find Services</b-button>
                                        </div>
                                    </b-col>
                                </b-row>
                            </form>

                            <ul class="treding-keywords list-inline mb-0 mt-3 fs-13">
                                <li class="list-inline-item text-danger fw-semibold"><i
                                        class="mdi mdi-tag-multiple-outline align-middle"></i> </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Skin,</b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Body,</b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Brows,</b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Lashes,</b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Nails</b-link>
                                </li>
                            </ul>
                        </div>
                    </b-col>
                    <b-col lg="4">
                        <div class="position-relative home-img text-center mt-5 mt-lg-0">

                            <img src="/images/job-profile2.png" alt="" class="user-img">

                            <div class="circle-effect">
                                <div class="circle"></div>
                                <div class="circle2"></div>
                                <div class="circle3"></div>
                                <div class="circle4"></div>
                            </div>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </section>

        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <b-container>
                <b-row class="align-items-center gy-4">
                    <b-col sm>
                        <div>
                            <h4 class="text-white mb-0 fw-semibold">Your journey to acne-free, clear and radiant skin starts here!</h4>
                        </div>
                    </b-col>
                    <b-col sm="auto">
                        <div>
                            <b-link @click="openRegister()" target="_blank" class="btn bg-gradient btn-light">Register Now</b-link>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </section>

        <!-- <section id="team" class="section">
            <span class="text-center">list of services</span>
        </section> -->

        <footer class="custom-footer bg-dark py-5 position-relative">
            <b-container>
                <b-row>
                    <b-col lg="7" class="mt-4">
                        <div>
                            <div>
                                <img src="imagess/logo-light.png" alt="logo light" height="25">
                            </div>
                            <div class="mt-4 fs-13">
                                <p>Pretty Potions Management System</p>
                                <p class="ff-secondary">At Pretty Potion, we specialize in enhancing your natural allure and revealing the radiant beauty that lies within you. Our clinic offers a magical experience tailored to rejuvenate your skin, sculpt your body, accentuate your brows and lashes, and pamper your nails.</p>
                            </div>
                        </div>
                    </b-col>

                    <b-col lg="5" class="ms-lg-auto">
                        <b-row>
                            <b-col sm="12" class="mt-4 text-end">
                                <h4 class="text-white mb-0">Contact Details</h4>
                                <div class="text-muted mt-4 fs-13">
                                    <ul class="list-unstyled ff-secondary footer-list">
                                        <li>
                                            Pretty Potions — Aesthetic and Spa
                                        </li>
                                        <li>
                                            Cabato Road, Tetuan, Zamboanga City, Philippines, 7000
                                        </li>
                                        <li>
                                            CP no.: 0917 561 2320
                                        </li>
                                    </ul>
                                </div>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>

                <b-row class="text-center text-sm-start align-items-center mt-5">
                    <b-col sm="6">

                        <div>
                            <p class="copy-rights mb-0 currentyear">{{ new Date().getFullYear() }} © PRETTY POTIONS
                            </p>
                        </div>
                    </b-col>
                    <b-col sm="6">
                        <div class="text-sm-end mt-3 mt-sm-0">
                            <ul class="list-inline mb-0 footer-social-link">
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-facebook-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-github-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-linkedin-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-google-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-dribbble-line"></i>
                                        </div>
                                    </b-link>
                                </li>
                            </ul>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </footer>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
    </div>
    <Register ref="register"/>
</template>
<script>
import Register from './Register.vue';
export default { 
    components: { Register },
    layout: null,
    data() {
        return {};
    },
    methods: {
        topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        },
        openRegister(){
            this.$refs.register.show();
        }
    },
    mounted() {
        let backtoTop = document.getElementById("back-to-top");
        if (backtoTop) {
            backtoTop = document.getElementById("back-to-top");
            window.onscroll = function () {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    backtoTop.style.display = "block";
                } else {
                    backtoTop.style.display = "none";
                }
            };
        }
        window.addEventListener('scroll', function (ev) {
            ev.preventDefault();
            var navbar = document.getElementById("navbar");
            if (navbar) {
                if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
                    navbar.classList.add("is-sticky");
                } else {
                    navbar.classList.remove("is-sticky");
                }
            }
        });
    },
};
</script>