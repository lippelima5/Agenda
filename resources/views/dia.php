<?php
if (isset($_GET['d'])) {
    $data = $_GET['d'];
} else {
    $data = date('yy-m-d');
}

$ch = curl_init();
// IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
// in most cases, you should set it to true
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'https://localhost/agenda/public/api/agenda/' . $data);
$return = curl_exec($ch);
curl_close($ch);
$Eventos = json_decode($return);

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Felippe Lima">
    <link rel="icon" href="https://hosuldeminas.com.br/wp-content/uploads/2020/03/cropped-LOGO-OFICIAL-HO.png">

    <title>Eventos do dia</title>

    <!-- Bootstrap core CSS -->
    <!-- importações do boostrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        html body {
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 30px;

        }
    </style>

</head>

<body>
    <?php require('./resources/navbar.php') ?>
    <div class="container">

        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">Eventos para o dia
                <strong> <?php echo date("d/m/Y", strtotime($data)); ?></strong>
            </h1>
        </div>


        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Médico</th>
                    <th scope="col">Unidade</th>
                    <th scope="col">Período</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Procedimento</th>
                    <th scope="col">Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($Eventos as $Evento) {
                    echo ('<tr>
                    <td>' . $Evento->nome . '</td>
                    <td>' . $Evento->unidade . '</td>
                    <td>' . $Evento->periodo . '</td>
                    <td>' . $Evento->cidade . '</td>
                    <td>' . $Evento->procedimento . '</td>
                    <td><button onclick="Deletar(' . $Evento->id_agenda  . ')" type="button" class="btn btn-outline-danger">Deletar</button></td>
                    </tr>');
                }
                ?>
            </tbody>
        </table>


    </div>






</body>
<footer>
    <script src="./resources/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- moment -->
    <script src="./resources/moment.js"></script>

    <script type="text/javascript">
        var datepicker, config;
        config = {
            locale: 'pt-br',
            uiLibrary: 'bootstrap4',
        };
        $(document).ready(function() {
            // datepicker = $('#datepicker').datepicker(config);
            $('#datepicker').datepicker(config);
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