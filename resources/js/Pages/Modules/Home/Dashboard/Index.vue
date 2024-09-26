<template lang="">
    <b-row>
        <div class="col-md-12">
            <div class="row g-3">
                <b-col lg="4" md="6" v-for="(item, index) of counts" :key="index">
                    <b-card no-body>
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-info rounded-circle fs-3">
                                        <i :class="`bx ${item.icon} align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ item.name }}
                                    </p>
                                    <h4 class="mb-0">
                                        <span class="counter-value">
                                        {{ item.total }}
                                        </span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                   
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
            </div>
        </div>
        <div class="col-md-12">
            <b-card no-body>
                <b-card-body>
                    <apexchart ref="realtimeChart" class="apex-charts mb-n5 mt-2" type="area" dir="ltr" height="400" :series="series"
                            :options="chartOptions">
                    </apexchart>
                </b-card-body>
            </b-card>
        </div>
    </b-row>
</template>
<script>
export default {
    props: ['counts'],
    data() {
        return {
            currentUrl: window.location.origin,
            type: 'yearly',
            years: [],
            year: new Date().getFullYear(),
            series: [],
            chartOptions: {
                chart: {
                    stacked: true,
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: true,
                    },
                    id: "vuechart-example",
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "50%",
                        endingShape: "rounded",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                xaxis: {
                    labels: {
                        rotate: -45
                    },
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                    tickPlacement: 'on'
                },
                yaxis: {
                    title: {
                        text: 'Appointments Count'
                    },
                },
                colors: ["#556ee6", "#ea6868", "#34c38f", "#f1b44c", "#a20cce", " #713d3d"],
                legend: {
                    position: "top",
                },
                fill: {
                    opacity: 1,
                },
            },
        }
    },
    created() {
        this.fetch();
    },
    methods: {
        fetch() {
            axios.get(this.currentUrl + '/appointments',{
                params : {
                    option : 'reports',
                    year: this.year,
                }
            })
            .then(response => {
                this.provinces = response.data.provinces;
                this.chartOptions = {
                    ...this.chartOptions,
                    ...{
                        xaxis: {
                            labels: {
                                show: true,
                                rotate: -65,
                                rotateAlways: true,
                                minHeight: 100,
                                maxHeight: 180,
                                style: {
                                    colors: "red"
                                }
                            },
                            categories: response.data.categories,
                            tickPlacement: 'on'
                        }
                    }
                };
                this.series = response.data.lists;
            })
            .catch(err => console.log(err));
        },
        previous(year){
            this.year = year - 20;
            this.fetch();
        },
        next(year){
            this.year = year + 20;
            this.fetch();
        }
    }
}
</script>
<style lang="">
    
</style>