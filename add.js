$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: [
            // Ajoutez vos événements ici
            {
                title: 'Événement 1',
                start: '2023-11-15'
            },
            {
                title: 'Événement 2',
                start: '2023-11-18'
            }
            // ... autres événements
        ]
    });
});