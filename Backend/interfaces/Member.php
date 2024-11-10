<?php

interface memberInterface{
    public function editInfo($data);
    public function viewInfo();
    public function setAlarm($data);
    public function setSession($data);
    public function calcFoodCalor($data);
    public function calcBodCalcNeed($data);
}