<?php
$ch = curl_init();
// IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
// in most cases, you should set it to true
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'https://localhost/agenda/public/api/colaborador');
$return = curl_exec($ch);
curl_close($ch);
$colaboradores = json_decode($return);
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Felippe Lima">
    <link rel="icon" href="https://hosuldeminas.com.br/wp-content/uploads/2020/03/cropped-LOGO-OFICIAL-HO.png">

    <title>Incluir Agenda</title>

    <!-- importações do boostrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- toast -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />


    <!-- GIJGO widgets ex: datepicker -->
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css">

    <style>
        html body {
            margin: 0;
            padding: 0;
        }

        .form-add {
            width: 100%;
            max-width: 900px;
            padding: 15px;
            margin: auto;
        }

        .form-add .row {
            justify-content: space-between;
        }

        .form-add .form-group {
            width: 100%;
            max-width: 440px;
        }


        .form-add .form-group #obs {
            width: 100%;
            max-width: 900px;
        }
    </style>

</head>

<body>
    <?php require('./resources/navbar.php') ?>

    <form id="form-add" class="form-add">

        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">Preencha os dados abaixo para adicionar um evento na agenda.</h1>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="datepicker">Data</label>
                <input name="data" id="datepicker" autocomplete="off" />
            </div>

            <div class="form-group">
                <label for="inputMedico">Médico</label>
                <select name="id" class="form-control" id="inputMedico">
                    <option selected value="0">Selecione um médico</option>
                    <?php

                    foreach ($colaboradores as $colaborador) {
                        if ($colaborador->c_tipo == 1) {
                            echo ("
                            <option value=" . $colaborador->c_id . ">" . $colaborador->c_nome_completo . "</option>
                            ");
                        }
                    }
                    ?>
                </select>
            </div>

        </div>

        <div class="row">
            <div class="form-group">
                <label for="inputMedico">Unidade</label>
                <select name="unidade" class="form-control" id="inputMedico">
                    <option selected value="0">Selecione uma unidade</option>
                    <option value="Casa do Glaucoma - SL">Casa do Glaucoma - SL</option>
                    <option value="Casa do Glaucoma - VGA">Casa do Glaucoma - VGA</option>
                    <option value="Consultório - HO">Consultório - HO</option>
                    <option value="IOSUL - SL">IOSUL - SL</option>
                    <option value="Unidade - PC">Unidade - PC</option>
                    <option value="Triagem">Triagem</option>
                </select>
            </div>

            <div class="form-group">
                <label for="inputPeriodo">Período</label>
                <select name="periodos" class="form-control" id="inputPeriodo">
                    <option value="M">M - Manhã</option>
                    <option value="T">T - Tarde</option>
                    <option value="A">A - Ambos</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="inputCidade">Cidade</label>
                <input name="cidade" type="text" class="form-control" id="inputCidade" placeholder="Insira uma cidade">
            </div>

            <div class="form-group">
                <label for="inputProcedimento">Procedimento</label>
                <select name="procedimento" class="form-control" id="inputProcedimento">
                    <option value="Consulta">Consulta</option>
                    <option value="Cirurgia">Cirurgia</option>
                    <option value="Glaucoma">Glaucoma</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div id="obs" class="form-group">
                <label for="inputObs">Observações</label>
                <textarea name="obs" class="form-control" style="width: 900px" id="inputObs" rows="4"></textarea>
            </div>
        </div>

        <div class="row">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Adicionar</button>
        </div>

    </form>






</body>
<footer>
    <script src="./resources/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.pt-br.js" type="text/javascript"></script>

    <!-- toast -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script type="text/javascript">
        var datepicker, config;
        config = {
            locale: 'pt-br',
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'

        };
        $(document).ready(function() {
            // datepicker = $('#datepicker').datepicker(config);
            $('#datepicker').datepicker(config);
        });
    </script>

    <script>
        //ativa o quando o formulado seria enviado
        $("#form-add").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);

            $.ajax({
                type: "POST",
                url: "http://localhost/agenda/public/api/agenda",
                data: form.serialize(),
                success: function(msg) {
                    console.log(msg);
                    toastr.options.onHidden = function() {
                        //  location.reload();
                    }
                    toastr.success(msg.message, 'Concluído', {
                        timeOut: 1000
                    });


                },
                error: function(msg) {
                    toastr.error(msg.message, 'Falha', {
                        timeOut: 1000
                    });
                }
            });


        });
    </script>



</footer>

</html>