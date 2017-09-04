<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <script src='_agenda/lib/moment.min.js'></script>
    <script src='_agenda/lib/jquery.min.js'></script>
    <script src='_agenda/fullcalendar.min.js'></script>
    <link href='_agenda/fullcalendar.css' rel='stylesheet'/>
    <link href='_agenda/fullcalendar.print.css' rel='stylesheet' media='print'/>
    <script src='_agenda/lang/es.js'></script>


    <script>

        $(document).ready(function () {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                //defaultDate: '2014-11-12',
                editable: false,
                allDaySlot: false,
                eventLimit: false, // allow "more" link when too many events

                events: {
                    url: '_agenda/calendar/php/get-events.php?med=<?php echo $_GET['med']; ?>',
                    error: function () {
                        $('#script-warning').show();
                    }
                },
                loading: function (bool) {
                    $('#loading').toggle(bool);
                },
                eventClick: function (event) {
                    if (event.url) {
                        window.open(event.url, "_parent");
                        return false;
                    }
                }
            });

        });

    </script>
    <style>

        body {
            margin: 0;
            padding: 0;
            font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
            font-size: 14px;
        }

        #script-warning {
            display: none;
            background: #eee;
            border-bottom: 1px solid #ddd;
            padding: 0 10px;
            line-height: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            color: red;
        }

        #loading {
            display: none;
            position: absolute;
            top: 10px;
            right: 20px;
            color: #ED0E11;
        }

        #calendar {
            max-width: 900px;
            margin: 10px auto;
            padding: 0 10px;
        }

        /* ------------------------- oculta horas ---------------------------------- */
        .fc-slats table tr:nth-child(1) {
            display: none;
        }

        .fc-slats table tr:nth-child(2) {
            display: none;
        }

        .fc-slats table tr:nth-child(3) {
            display: none;
        }

        .fc-slats table tr:nth-child(4) {
            display: none;
        }

        .fc-slats table tr:nth-child(5) {
            display: none;
        }

        .fc-slats table tr:nth-child(6) {
            display: none;
        }

        .fc-slats table tr:nth-child(7) {
            display: none;
        }

        .fc-slats table tr:nth-child(8) {
            display: none;
        }

        .fc-slats table tr:nth-child(9) {
            display: none;
        }

        .fc-slats table tr:nth-child(10) {
            display: none;
        }

        .fc-slats table tr:nth-child(11) {
            display: none;
        }

        .fc-slats table tr:nth-child(12) {
            display: none;
        }

        .fc-slats table tr:nth-child(48) {
            display: none;
        }
        <?php if($_GET['med']<>'') { // bloque los links de los enventos cuando entra como consulta o agenda ?>
        .fc-event-container {pointer-events: none; cursor: default;}
        <?php } ?>
    </style>
</head>
<body>
<div id='script-warning'>
    <code>php/get-events.php</code> must be running.
</div>

<div id='loading'><b>CARGANDO AGENDA...</b></div>

&nbsp;&nbsp;&nbsp;<b>LEYENDA:</b>&nbsp;&nbsp;&nbsp;

<span style="color:#fff;background:green;padding:5px">Ginecologia y Obstetricia</span>
<span style="color:#fff;background:#3a87ad;padding:5px">Interveciones en Inmater</span>
<?php if ($_SESSION['login'] <> 'lab') { ?>
    <span style="color:#fff;background:orange;padding:5px">Interveciones externas</span>
    <span style="color:#fff;background:deeppink;padding:5px">No Disponible</span>
<?php } ?>

<div id='calendar'></div>

</body>
</html>
