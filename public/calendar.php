<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
    <!-- importações do boostrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <link href='./packages/core/main.css' rel='stylesheet' />
    <link href='./packages/daygrid/main.css' rel='stylesheet' />
    <link href='./packages/timegrid/main.css' rel='stylesheet' />
    <script src='./packages/core/main.js'></script>
    <script src='./packages/interaction/main.js'></script>
    <script src='./packages/daygrid/main.js'></script>
    <script src='./packages/timegrid/main.js'></script>
    <script src='./packages/core/locales-all.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var initialLocaleCode = 'pt-BR';
            var today = new Date()

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid'],
                header: {
                    left: 'title',
                    center: '',
                    right: 'prev, next today'
                },
                defaultDate: today,
                locale: initialLocaleCode,
                navLinks: false, // can click day/week names to navigate views
                selectable: false,
                selectMirror: true,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: 'https://localhost/agenda/public/foo',
                dateClick: function(info) {
                    var myHeading = "<p>Não há marcações para esse dia </p>";
                    $(".modal-body").html(myHeading);
                    $('#exampleModalCenter').modal('show');

                },
                eventClick: function(info) {
                    var dados = info.event.title;
                    var partes = dados.split("-");
                    if (partes.length < 5) {
                        return;
                    }

                    var medico = "<p> Médico: " + partes[0] + " </p>";
                    var unidade = "<p> Unidade: " + partes[1] + " </p>";
                    var periodo = "<p> Período:  <strong>" + partes[2] + "</strong>    (A=Ambos, M=Manhã, T=Tarde) </p>";
                    var cidade = "<p> Cidade: " + partes[3] + " </p>";
                    var procedimento = "<p> Procedimento: " + partes[4] + " </p>";

                    $(".modal-body").html(medico + unidade + periodo + cidade + procedimento);
                    $('#exampleModalCenter').modal('show');
                }
                /* events: [{
                        title: 'Dr Vinicios Penha - HO - M/T - Nossa Senhora de Aparecida ',
                        start: '2020-02-01'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-02-12T10:30:00',
                        end: '2020-02-12T12:30:00'
                    },
                    {
                        title: 'Click for Google',
                        start: '2020-02-28',
                        extendedProps: {
                            department: 'BioChemistry'
                        },
                        description: 'Lecture'
                    }
                ], */
            });

            calendar.render();
        });
    </script>
    <style rel='stylesheet'>
        body {
            margin: 40px 10px;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

    

        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Descrição</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a id="message" class="message"></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Abrir dia</button>
                </div>
            </div>
        </div>
    </div>

    <div id='calendar'></div>

</body>

</html>