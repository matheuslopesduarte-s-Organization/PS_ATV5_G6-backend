<?php
 function calcularVerificador($baseCpf)
    {
        /*
        Cálculo do primeiro dígito verificador:

        Multiplica-se cada um dos 9 primeiros dígitos do CPF por pesos que começam de 10 e vão até 2.
        Soma-se os resultados dessas multiplicações.
        Calcula-se o resto da divisão dessa soma por 11.
        Se o resto for menor que 2, o primeiro dígito verificador é 0. Caso contrário, é 11 menos esse resto.



        Cálculo do segundo dígito verificador:

        Repete-se o processo utilizando os 9 primeiros dígitos do CPF mais o primeiro dígito verificador obtido no passo anterior.
        Os pesos também variam de 11 a 2.
        Novamente, calcula-se o resto da divisão da soma por 11.
        Se o resto for menor que 2, o segundo dígito verificador é 0. Caso contrário, é 11 menos esse resto.

        fonte: https://chatgpt.com/share/119aebf8-5659-4e1a-a071-176745a88caf
        */

        // primeiro digito
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $baseCpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $primeiroDigito = ($resto < 2) ? 0 : 11 - $resto;

        // segundo digito
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $baseCpf[$i] * (11 - $i);
        }
        $soma += $primeiroDigito * 2;
        $resto = $soma % 11;
        $segundoDigito = ($resto < 2) ? 0 : 11 - $resto;

        return $primeiroDigito . $segundoDigito;
    }

    $cpf = "143.612.399-24";

    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    $cpfBase = substr($cpf, 0, 9);
    $verificador = substr($cpf, 9, 11);
    if(($verificador == calcularVerificador($cpfBase))){
        echo 'errado';
        echo $verificador;
        echo calcularVerificador($cpfBase);
    } else {  
        echo calcularVerificador($cpfBase);
        echo $verificador;
    }
