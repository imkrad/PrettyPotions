<template>
    <div id="layout-wrapper">
        <Navigation :auth="auth"/>
        <Menu v-if="$page.props.role != 'Client' && $page.props.role != 'Staff'"/>
        <div :class="($page.props.role != 'Client' && $page.props.role != 'Staff') ? 'main-content' : ''" style="padding: 0">
            <div class="page-content">
                <b-container fluid>
                    <slot/>
                </b-container>
            </div>
            <!-- <Footer /> -->
        </div>
    </div>
</template>
<script>
import Menu from '../Components/Menu.vue';
import Footer from '../Components/Footer.vue';
import Navigation from '../Components/Navigation.vue'
export default {
    components: { Navigation, Menu, Footer },
    props: ['auth'],
    data(){
        return {
            isMenuCondensed: false,
            layoutType: 'vertical',
            layoutWidth: 'fluid',
            sidebarSize: 'lg',
            topbar: 'light',
            mode: 'light',
            position: 'fixed',
            sidebarView: 'default',
            sidebarColor: 'dark',
            sidebarImage: 'none',
            preloader: 'disable'
        };
    },
    created: () => {
        document.body.removeAttribute("data-layout", "horizontal");
        document.body.removeAttribute("data-topbar", "dark");
        document.body.removeAttribute("data-layout-size", "boxed");
    },
    methods : {
        initActiveMenu() {
            if (document.documentElement.getAttribute('data-sidebar-size') === 'sm-hover') {
                localStorage.setItem('hoverd',true)
                document.documentElement.setAttribute('data-sidebar-size', 'sm-hover-active');
            } else if (document.documentElement.getAttribute('data-sidebar-size') === 'sm-hover-active') {
                localStorage.setItem('hoverd',false)
                document.documentElement.setAttribute('data-sidebar-size', 'sm-hover');
            } else {
                document.documentElement.setAttribute('data-sidebar-size', 'sm-hover');
            }
        },
        toggleMenu() {
            document.body.classList.toggle("sidebar-enable");
    
            if (window.screen.width >= 992) {
                router.afterEach((routeTo, routeFrom) => {
                    document.body.classList.remove("sidebar-enable");
                    document.body.classList.remove("vertical-collpsed");
                });
                document.body.classList.toggle("vertical-collpsed");
            }else{
                router.afterEach((routeTo, routeFrom) => {
                    document.body.classList.remove("sidebar-enable");
                });
                document.body.classList.remove("vertical-collpsed");
            }
            this.isMenuCondensed = !this.isMenuCondensed;
        },
        toggleRightSidebar() {
            document.body.classList.toggle("right-bar-enabled");
        },
        hideRightSidebar() {
            document.body.classList.remove("right-bar-enabled");
        },
    }
}
</script>