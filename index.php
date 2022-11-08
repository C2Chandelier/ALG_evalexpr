<?php

function eval_expr($expr)
{

    $calculator = [];
    $number = [];
    $operator = [];
    $array = [];

    for ($j = 0; $j < strlen($expr); $j++) {
        if(preg_match('/[()+\-*\/%]/',$expr[$j])){
            array_push($operator, $expr[$j]);
            array_push($number, implode("", $array));
            $array = [];
        } else {
            array_push($array, $expr[$j]);
        }
    }
    array_push($number, implode("", $array));

    $compteur = 0;
    foreach ($number as $element) {
        if ($element != "") {
            array_push($calculator, floatval($element));
        }
        if ($compteur <= (count($operator) - 1)) {
            array_push($calculator, $operator[$compteur]);
            $compteur++;
        }
    };

    while (array_search("(", $calculator) !== false) {
        /* $array1 = array_keys($calculator, "(");
        $array2 = array_keys($calculator, ")");
        $offset1 = "";
        $offset2 = "";

        for ($i = 0; $i < count($array1); $i++) {
            if (isset($array1[$i + 1]) && $array1[$i] + 1 == $array1[$i + 1]) {
                $offset1 = $array1[$i];
            }
        }
        for ($i = 0; $i < count($array2); $i++) {
            if (isset($array2[$i + 1]) && $array2[$i] + 1 == $array2[$i + 1]) {
                $offset2 = $array2[$i + 1];
            }
        }
        if ($offset1 != "" && $offset2 != "") {
            $tempo = array_splice($calculator, $offset1 + 1, $offset2 - $offset1 - 1);

            while (array_search("(", $tempo) !== false) {
                $begin = array_search("(", $tempo);
                $end = array_search(")", $tempo);
                $precalc = array_splice($tempo, $begin + 1, $end - $begin - 1);
                $preres = calculate($precalc);
                $begin2 = array_search("(", $tempo);
                array_splice($tempo, $begin2, 2, $preres);
            }

            $tab1 = array_slice($calculator, array_search("(", $calculator), 1);
            $tab2 = array_slice($calculator, array_search("(", $calculator) + 1);
            for ($i = 0; $i < count($tempo); $i++) {
                array_push($tab1, $tempo[$i]);
            }
            $calculator = array_merge($tab1, $tab2);
        } */

        $begin = array_search("(", $calculator);
        $end = array_search(")", $calculator);
        $precalc = array_splice($calculator, $begin + 1, $end - $begin - 1);
        $preres = calculate($precalc);
        $begin2 = array_search("(", $calculator);
        array_splice($calculator, $begin2, 2, $preres);
    }

    return calculate($calculator);
}

function calculate($calculator)
{
    for ($i = 0; $i < count($calculator); $i++) {

        switch ($calculator[$i]) {

            case "*":
                $tempo = $calculator[$i - 1] * $calculator[$i + 1];
                array_splice($calculator, ($i - 1), 3, $tempo);
                break;

            case "/":
                $tempi = $calculator[$i - 1] / $calculator[$i + 1];
                array_splice($calculator, ($i - 1), 3, $tempi);
                break;

            case "%":
                $tempa = $calculator[$i - 1] % $calculator[$i + 1];
                array_splice($calculator, ($i - 1), 3, $tempa);
                break;
        }
    }

    for ($i = 0; $i < count($calculator); $i++) {

        switch ($calculator[$i]) {
            case "+":
                $tempe = $calculator[$i - 1] + $calculator[$i + 1];
                array_splice($calculator, ($i - 1), 3, $tempe);
                break;

            case "-":
                $tempu = $calculator[$i - 1] - $calculator[$i + 1];
                array_splice($calculator, ($i - 1), 3, $tempu);
                break;
        }
    }
    if (count($calculator) > 1) {
        calculate($calculator);
    } else {
        $result = $calculator[0];
        return $result;
    }
}


