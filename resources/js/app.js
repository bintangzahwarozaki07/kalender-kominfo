
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

// URL aplikasi Laravel otomatis
const APP_URL = document.querySelector('meta[name="app-url"]')?.content || window.location.origin;

// URL endpoint kalender
const CALENDAR_URL = APP_URL.replace(/\/$/, '') + '/calendar-events';

document.addEventListener('DOMContentLoaded', function () {

    // =====================
    // Calendar
    // =====================
    const calendarEl = document.getElementById('calendar');

    if (calendarEl) {

        const calendar = new Calendar(calendarEl, {

            plugins: [
                dayGridPlugin,
                interactionPlugin,
                timeGridPlugin
            ],

            locale: idLocale,

            height: 700,

            initialView: 'dayGridMonth',

            // URL kalender Laravel yang sudah diperbaiki
            events: CALENDAR_URL,

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },

            eventClick: function (info) {

                const e = info.event.extendedProps;

                Swal.fire({

                    title: info.event.title,

                    html:
                        '<b>Kategori:</b> ' + (e.kategori || '-') + '<br>' +
                        '<b>Jam:</b> ' + (e.jam || '-') + '<br>' +
                        '<b>Lokasi:</b> ' + (e.lokasi || '-') + '<br>' +
                        '<b>PIC:</b> ' + (e.pic || '-') + '<br>' +
                        '<b>Status:</b> ' + (e.status || '-') + '<hr>' +
                        (e.deskripsi || '-'),

                    icon: 'info',

                    confirmButtonText: 'Tutup'

                });

            },

            eventDidMount: function (info) {
                info.el.style.cursor = 'pointer';
            },

            loading: function (isLoading) {
                console.log(
                    isLoading
                        ? 'Memuat data kalender...'
                        : 'Data kalender selesai dimuat.'
                );
            }

        });

        calendar.render();

    }

});
