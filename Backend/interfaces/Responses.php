<?php
interface ResponseInterfacePHPTemp{
    public function responsePayload($payload, $remarks, $message, $code);
    public function notFound();
    public function getIDFromToken();
    public function getUserTypeFromToken($data);
    public function getUserTypeFromTokenBackendHandler();

    public function errorhandling($data);
}