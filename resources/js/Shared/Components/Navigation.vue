<template>
    <header id="page-topbar" :style="($page.props.role != 'Client' && $page.props.role != 'Staff') ? 'left: 300px; right: 24px;' : 'left: 25px; right: 23px;'">
        <div class="layout-width">
            <div class="navbar-header">

                <div class="d-flex">
                    <button v-if="$page.props.role != 'Client' && $page.props.role != 'Staff'" type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon" >
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <div class="navbar-brand-box">
                        <Link href="/" class="logo logo-dark">
                            <span class="logo-sm"><img src="/imagess/logo-sm.png" alt="" height="30" /></span>
                            <span class="logo-lg"><img src="/imagess/logo-dark.png" alt="" height="30" /></span>
                        </Link>
                        <Link href="/" class="logo logo-light">
                            <span class="logo-sm"> <img src="/imagess/logo-sm.png" alt="" height="30" /> </span>
                            <span class="logo-lg"><img src="/imagess/logo-dark.png" alt="" height="30" /> </span>
                        </Link>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="ms-1 header-item d-none d-sm-flex">
                        <b-button type="button" variant="ghost-secondary" class="btn-icon btn-topbar rounded-circle"
                            data-toggle="fullscreen" @click="initFullScreen">
                            <i class="bx bx-fullscreen fs-22"></i>
                        </b-button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <b-button type="button" variant="ghost-secondary" class="btn-icon btn-topbar rounded-circle light-dark-mode"
                            @click="toggleDarkMode">
                            <i class="bx bx-moon fs-22"></i>
                        </b-button>
                    </div>
                    
                    <BDropdown variant="link" class="ms-sm-3 header-item topbar-user" toggle-class="rounded-circle arrow-none" menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -14, crossAxis: 0, mainAxis: 0 }">
                        <template #button-content>
                            <span class="d-flex align-items-center">
                                <img  class="rounded-circle header-profile-user" :src="currentUrl+'/imagess/avatars/'+auth.data.avatar"  alt=".">
                                <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{auth.data.profile.logged}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{auth.data.role}}</span>
                                </span>
                            </span>
                        </template>
                        <h6 class="dropdown-header">Welcome Pretty Potions!</h6>
                        <Link class="dropdown-item" href="/home">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Profile</span>
                        </Link>
                        <div class="dropdown-divider"></div>
                        <Link class="dropdown-item" method="post" as="button" href="/logout">
                            <BButton variant="none" type="submit" class="btn p-0"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Logout</BButton>
                        </Link>
                    </BDropdown>
                </div>

            </div>
        </div>
    </header>
</template>
<script>
export default {
    props: ['auth'],
    data(){
        return {
             currentUrl: window.location.origin,
        }
    },
    methods: {
        toggleDarkMode(){
            if (document.documentElement.getAttribute("data-bs-theme") == "dark") {
                document.documentElement.setAttribute("data-bs-theme", "light");
            } else {
                document.documentElement.setAttribute("data-bs-theme", "dark");
            }
        },
        toggleMenu() {
            this.$parent.toggleMenu();
        },
        initFullScreen() {
            document.body.classList.toggle("fullscreen-enable");
            if(
                !document.fullscreenElement &&
                !document.mozFullScreenElement &&
                !document.webkitFullscreenElement
            ){
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(
                        Element.ALLOW_KEYBOARD_INPUT
                    );
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        },
        toggleHamburgerMenu() {
            var windowSize = document.documentElement.clientWidth;
            if (windowSize > 767)
                document.querySelector(".hamburger-icon").classList.toggle("open");

            if (
                document.documentElement.getAttribute("data-layout") === "horizontal"
            ) {
                document.body.classList.contains("menu") ?
                document.body.classList.remove("menu") :
                document.body.classList.add("menu");
            }

            if (document.documentElement.getAttribute("data-layout") === "vertical") {
                if (windowSize < 1025 && windowSize > 767) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "sm" ?
                    document.documentElement.setAttribute("data-sidebar-size", "") :
                    document.documentElement.setAttribute("data-sidebar-size", "sm");
                } else if (windowSize > 1025) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "lg" ?
                    document.documentElement.setAttribute("data-sidebar-size", "sm") :
                    document.documentElement.setAttribute("data-sidebar-size", "lg");
                } else if (windowSize <= 767) {
                document.body.classList.add("vertical-sidebar-enable");
                document.documentElement.setAttribute("data-sidebar-size", "lg");
                }
            }

            if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
                document.body.classList.contains("twocolumn-panel") ?
                document.body.classList.remove("twocolumn-panel") :
                document.body.classList.add("twocolumn-panel");
            }
        },
    },
    mounted() {
        document.addEventListener("scroll", function () {
        var pageTopbar = document.getElementById("page-topbar");
        if (pageTopbar) {
            document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50 ? pageTopbar.classList.add("topbar-shadow") : pageTopbar.classList.remove("topbar-shadow");
        }
        });
        if (document.getElementById("topnav-hamburger-icon"))
        document.getElementById("topnav-hamburger-icon").addEventListener("click", this.toggleHamburgerMenu);
    },
}
</script>