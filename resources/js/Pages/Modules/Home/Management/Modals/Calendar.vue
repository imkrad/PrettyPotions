<template>
    <b-modal v-model="showModal" title="View Calendar" hide-footer style="--vz-modal-width: 1500px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="row" style="height: 600px;">
            <FullCalendar :options="calendarOptions" />
        </div>
    </b-modal>
</template>
<script>
 import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import listPlugin from "@fullcalendar/list";
export default {
    components: {
        FullCalendar
    },
    data(){
        return {
            calendarEvents: [],
            calendarOptions: {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
                },
                plugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin,
                    listPlugin,
                ],
                initialView: "dayGridMonth",
                themeSystem: "bootstrap",
                events: [],
                editable: true,
                droppable: true,
                eventResizableFromStart: true,
                dateClick: this.dateClicked,
                eventClick: this.editEvent,
                eventsSet: this.handleEvents,
                weekends: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                slotMinTime: "08:00:00",
                slotMaxTime: "18:00:00",
            },
            showModal: false,
        }
    },
    methods : {
        show() {
            this.fetch();
            this.showModal = true;
        },
        fetch(page_url) {
            page_url = page_url || '/appointments';
            axios.get(page_url, {
                params: {
                    option: 'calendar'
                }
            })
            .then(response => {
                if (response) {
                    this.calendarOptions.events = response.data.data;
                }
            })
            .catch(err => console.log(err));
        },
        hide(){
            this.showModal = false;
        },
    }
}
</script>