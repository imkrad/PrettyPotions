<template>
    <div v-if="$page.props.role != 'Client' && $page.props.role != 'Staff'">
        <div class="app-menu navbar-menu" style="height: calc(100vh - 112px);">
            <div class="navbar-brand-box">
                <Link href="/" class="logo logo-dark">
                    <span class="logo-sm"><img src="/imagess/logo-sm.png" alt="" height="30" /></span>
                    <span class="logo-lg"><img src="/imagess/logo-dark.png" alt="" height="30" /></span>
                </Link>
                <Link href="/" class="logo logo-light">
                    <span class="logo-sm"> <img src="/imagess/logo-sm.png" alt="" height="30" /> </span>
                    <span class="logo-lg"><img src="/imagess/logo-light.png" alt="" height="30" /> </span>
                </Link>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover" @click="initActiveMenu">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <!-- <simplebar id="scrollbar" class="h-100" ref="scrollbar"> -->
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Home') }" href="/home">
                        <i class='ri-home-3-fill'></i>
                        <span data-key="t-dashboards">Home</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Appointments') }" href="/appointments">
                        <i class='ri-calendar-fill'></i>
                        <span data-key="t-dashboards">Appointments</span>
                    </Link>
                </li>
                <li class="nav-item" v-if="$page.props.role != 'Client'">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Aestheticians') }" href="/aestheticians">
                        <i class='ri-group-2-fill'></i>
                        <span data-key="t-dashboards">Aetheticians</span>
                    </Link>
                </li>
                <li class="nav-item" v-if="$page.props.role != 'Client'">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Services') }" href="/services">
                        <i class='ri-service-fill'></i>
                        <span data-key="t-dashboards">Services</span>
                    </Link>
                </li>
                <!-- <li class="nav-item">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Dashboard') }" href="/home">
                        <i class='ri-menu-fill'></i>
                        <span data-key="t-dashboards">Dropdowns</span>
                    </Link>
                </li> -->
                <li class="nav-item" v-if="$page.props.role != 'Client'">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Clients') }" href="/clients">
                        <i class='ri-team-fill'></i>
                        <span data-key="t-dashboards">Clients</span>
                    </Link>
                </li>
                <li class="nav-item" v-if="$page.props.role != 'Client' && $page.props.role != 'Receptionist'">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Reviews') }" href="/reviews">
                        <i class='ri-star-s-fill'></i>
                        <span data-key="t-dashboards">Reviews and Ratings</span>
                    </Link>
                </li>
                <li class="nav-item" v-if="$page.props.role != 'Client'">
                    <Link class="nav-link menu-link" :class="{'active': $page.component.startsWith('Modules/Staffs') }" href="/staffs">
                        <i class='ri-account-circle-fill'></i>
                        <span data-key="t-dashboards">Staffs</span>
                    </Link>
                </li>
            </ul>
            <!-- </simplebar> -->
            <div class="sidebar-background"></div>
        </div>
    </div>
    <div class="vertical-overlay" id="overlay"></div>
</template>