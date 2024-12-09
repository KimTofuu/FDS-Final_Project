<?php

interface coachInterface{
    public function seeMemDet($data);
    public function sendMessage($data);
    public function getAllClients();
    public function updateInfo($data);
    public function viewInfo();
}