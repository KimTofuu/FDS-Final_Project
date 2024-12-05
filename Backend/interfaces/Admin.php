<?php

interface adminInterface{
    public function createAcc($data);
    public function getOneAcc($data);
    public function getAllAcc();
    public function delAcc($data);
    public function archStat($data);
    public function coachCreate($data);
    public function delCoach($data);
    public function getAllCoach();
    public function setMemSubPlan($data);
    public function changePaymentStatus();
    public function setPaid($data);
}