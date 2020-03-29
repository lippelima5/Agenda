<?php
//nome recebido para transformar em usuario
$nome  = "Fêlíppe Lima de oliveira";

//transforma o nome tudo em minusculo
$nome = strtolower($nome);

//remove toda a acentuação do nome
$nome = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $nome);


//transforma a string em array separado por ' ' espaço
$parte = explode(" ", $nome);


$usuario = "";

if (count($parte) > 1) {
    //pega o primeiro item do array, e o ultimo e une com '.'
    $usuario = $parte[0] . "." . $parte[count($parte) - 1];
} else {
    //pega somente o primeiro
    $usuario = $parte[0]; 
}

return $usuario;
