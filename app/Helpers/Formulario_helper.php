<?php

function exibeTitulo(
    $titulo, 
    $parametro = ['acao' => 'lista']
) {
    return "<h2>" . $titulo . "</h2>";
}