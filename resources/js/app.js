import './bootstrap';

import Swal from 'sweetalert2';
window.Swal = Swal;

// =========================
// FullCalendar
// =========================
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import idLocale from '@fullcalendar/core/locales/id';

document.addEventListener('DOMContentLoaded', function () {

    // =====================
    // Calendar
    // =====================
    let calendarEl = document.getElementById('calendar');

    if(calendarEl){

        let calendar = new Calendar(calendarEl,{

            plugins:[
                dayGridPlugin,
                interactionPlugin,
                timeGridPlugin
            ],

            locale:idLocale,

            height:700,

            initialView:'dayGridMonth',

            events:'/calendar-events',

            headerToolbar:{
                left:'prev,next today',
                center:'title',
                right:'dayGridMonth,timeGridWeek'
            },

            eventClick:function(info){

                let e = info.event.extendedProps;

                Swal.fire({

                    title:info.event.title,

                    html:
                    "<b>Kategori :</b> "+e.kategori+"<br>"+
                    "<b>Jam :</b> "+e.jam+"<br>"+
                    "<b>Lokasi :</b> "+e.lokasi+"<br>"+
                    "<b>PIC :</b> "+e.pic+"<br>"+
                    "<b>Status :</b> "+e.status+"<hr>"+e.deskripsi,

                    icon:'info'

                });

            }

        });

        calendar.render();

    }

});