<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Felippe Lima">
    <link rel="icon" href="https://hosuldeminas.com.br/wp-content/uploads/2020/03/cropped-LOGO-OFICIAL-HO.png">

    <title>Início</title>


    <!-- importações do boostrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style rel='stylesheet'>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        #calendar-container {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .fc-header-toolbar {

            padding-top: 1em;
            padding-left: 1em;
            padding-right: 1em;
        }
    </style>


</head>

<body>
    <?php require('./resources/navbar.php') ?>
    <!-- Modal -->
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
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

                </div>
            </div>
        </div>
    </div>


    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>


</body>
<footer>
    <div class="container text-center" style="margin-top: 60px;">
        <p class="mt-5 mb-3 text-muted">&copy; Felippe Lima - <strong><a href="https://markwareco.com">Markware</a></strong> - 2019-2021</p>
    </div>

    <script src="./resources/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.pt-br.js" type="text/javascript"></script>

    <!-- toast -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link href='./packages/core/main.css' rel='stylesheet' />
    <link href='./packages/daygrid/main.css' rel='stylesheet' />
    <link href='./packages/timegrid/main.css' rel='stylesheet' />
    <script src='./packages/core/main.js'></script>
    <script src='./packages/interaction/main.js'></script>
    <script src='./packages/daygrid/main.js'></script>
    <script src='./packages/timegrid/main.js'></script>
    <script src='./packages/core/locales-all.js'></script>
    <script src='./packages/bootstrap/main.js'></script>
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
                selectMirror: false,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: function() {
                    return $.ajax({
                        type: "GET",
                        url: "https://localhost/agenda/public/api/calendar",
                        success: function(data) {
                            //  console.log(data)

                        },
                        error: function(data) {
                            toastr.error(data.message, 'Falha', {
                                timeOut: 1000
                            });
                        }
                    });
                },
                dateClick: function(info) {
                    var myHeading = "<p>Não há marcações para esse dia </p>";
                    var btnFechar = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';

                    $(".modal-body").html(myHeading);
                    $(".modal-footer").html(btnFechar);
                    $('#ModalCenter').modal('show');

                },
                eventClick: function(info) {
                    var id_agenda = info.event.id;
                    $.ajax({
                        type: "GET",
                        url: "https://localhost/agenda/public/api/calendar/" + id_agenda,
                        success: function(data) {
                            var _medico = "Dr. " + data[0].nome;

                            var medico = "<p> Médico: " + _medico + " </p>";
                            var unidade = "<p> Unidade: " + data[0].unidade + " </p>";
                            var periodo = "<p> Período:  <strong>" + data[0].periodo + "</strong>    (A=Ambos, M=Manhã, T=Tarde) </p>";
                            var cidade = "<p> Cidade: " + data[0].cidade + " </p>";
                            var procedimento = "<p> Procedimento: " + data[0].procedimento + " </p>";

                            //botoes
                            var btnDelete = '<button onclick="Deletar(' + id_agenda + ')" class="btn btn-danger">Deletar evento</button>';
                            var btnAbrirDia = '<a href="dia?d=' + data[0].data + '" class="btn btn-primary">Abrir dia</a>';
                            var btnFechar = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';


                            $(".modal-body").html(medico + unidade + periodo + cidade + procedimento);
                            $(".modal-footer").html(btnAbrirDia + btnDelete + btnFechar);
                            $('#ModalCenter').modal('show');
                        },
                        error: function(data) {
                            toastr.error(data.message, 'Falha', {
                                timeOut: 1000
                            });
                        }
                    });


                }
            });

            calendar.render();
        });
    </script>

    <script>
        function Deletar(id) {
            $.ajax({
                type: "DELETE",
                url: "https://localhost/agenda/public/api/agenda/" + id,
                success: function(msg) {
                    location.reload();
                },
            });

        }
    </script>


</footer>

</html>