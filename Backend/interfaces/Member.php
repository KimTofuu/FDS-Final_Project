<?php

interface memberInterface{
    public function editInfo($data);
    public function viewInfo($data);
    public function setAlarm($data);
    public function setSession($data);
    public function calcFoodCalor($data);
    public function calcBodCalcNeed($data);
    public function getRecomm($data);
    public function enrollClass($data);
}