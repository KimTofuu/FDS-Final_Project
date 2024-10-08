<?php

interface adminInterface{
    public function createAcc($data);
    public function getOneAcc($data);
    public function getAllAcc();
    public function delAcc($data);
    public function archStat($data);
    public function coachCreate($data);
}