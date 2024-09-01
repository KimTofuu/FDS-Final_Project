<?php
function bmiCalc($w, $h){
    $bmi = $w / pow($h, 2);
    return $bmi;
}       