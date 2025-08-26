<?php


//data atual por extenso

$meses = array(
    1 => 'janeiro',
    2 => 'fevereiro',
    3 => 'março',
    4 => 'abril',
    5 => 'maio',
    6 => 'junho',
    7 => 'julho',
    8 => 'agosto',
    9 => 'setembro',
    10 => 'outubro',
    11 => 'novembro',
    12 => 'dezembro'
);

$dia = date('d');
$mes_numero = date('n');
$ano = date('Y');

$data_atual=$dia . ' de ' . $meses[$mes_numero] . ' de ' . $ano;



