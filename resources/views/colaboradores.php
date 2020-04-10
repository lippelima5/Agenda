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

    <title>Colaboradores</title>

    <!-- importações do boostrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- toast -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

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

        .space {
            margin-top: 100px;
        }

        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Add animation to "page content" */
        .animate-bottom {
            position: relative;
            -webkit-animation-name: animatebottom;
            -webkit-animation-duration: 1s;
            animation-name: animatebottom;
            animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0px;
                opacity: 1
            }
        }

        @keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0;
                opacity: 1
            }
        }
    </style>

</head>

<body>
    <?php require('./resources/navbar.php') ?>

    <div id="loader" style="display: none"></div>

    <div id="conteudoPrincipal">


        <div class="container">

            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Colaboradores Cadastrados no sistema </h1>
            </div>


            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Senha</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Deletar</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($colaboradores as $colaborador) {

                        echo ('<tr>
                    <td>' . $colaborador->c_nome_completo . '</td>
                    <td>' . $colaborador->c_email . '</td>
                    <td>' . $colaborador->c_usuario . '</td>
                    <td>' . $colaborador->c_senha . '</td>
                    <td>' . $colaborador->c_tipo . '</td>
                    <td><button onclick="Deletar(' . $colaborador->c_id . ')" type="button" class="btn btn-outline-danger">Deletar</button> </td>
                </tr>');
                    }
                    ?>

                </tbody>
            </table>



        </div>
        <form id="form-add" class="form-add space" method="POST">

            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Preencha os campos abaixo para adicionar um novo colaborador.</h1>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="inputNome">Nome Completo</label>
                    <input type="text" name="nome_completo" class="form-control" id="inputNome" placeholder="Insira o nome completo" required>
                </div>

                <div class="form-group">
                    <label for="inputEmail">Insira um email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Insira um email" required>
                </div>
            </div>



            <div class="row">
                <div class="form-group">
                    <label for="inputTipo">Selecione o tipo de usuário</label>
                    <select name="tipo" class="form-control" style="width: 900px" id="inputTipo" required>
                        <option selected value="0">Selecione</option>
                        <option value="1">1 - Médico</option>
                        <option value="2">2 - Recepção</option>
                        <option value="3">3 - Gerencia</option>
                        <option value="4">4 - Administrador</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Adicionar</button>
            </div>

        </form>



        <div class="text-center" style="margin-top: 60px;">
            <p class="mt-5 mb-3 text-muted">&copy; Felippe Lima - <strong><a href="https://markwareco.com">Markware</a></strong> - 2019-2021</p>
        </div>
    </div>
</body>
<footer>
    <!-- bootstrap -->
    <script src="./resources/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- toast -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        function toggleLoading(loading) {
            if (loading) {
                document.getElementById("loader").style.display = "block";
                document.getElementById("conteudoPrincipal").style.display = "none";
            } else {
                document.getElementById("loader").style.display = "none";
                document.getElementById("conteudoPrincipal").style.display = "block";
            }

        }

        function Deletar(id) {
            // alert(id);


            $.ajax({
                type: "DELETE",
                url: "http://localhost/agenda/public/api/colaborador/" + id,
                success: function(msg) {
                    toastr.options.onHidden = function() {
                        location.reload();
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




        }

        $("#form-add").submit(function(e) {
            toggleLoading(true);
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);

            $.ajax({
                type: "POST",
                url: "http://localhost/agenda/public/api/colaborador",
                data: form.serialize(),
                success: function(msg) {
                    toggleLoading(false);
                    toastr.options.onHidden = function() {
                        location.reload();
                    }
                    toastr.success(msg.message, 'Concluído', {
                        timeOut: 1000
                    });


                },
                error: function(msg) {
                    toggleLoading(false);
                    toastr.error(msg.message, 'Falha', {
                        timeOut: 1000
                    });
                }
            });


        });
    </script>


</footer>

</html>