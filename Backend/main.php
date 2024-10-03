<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With,  Origin, Content-Type,");
header("Access-Control-Max-Age: 86400");

date_default_timezone_set("Asia/Manila");
set_time_limit(1000);

$rootPath = $_SERVER["DOCUMENT_ROOT"];
$apiPath = $rootPath . "/Olympus/Backend";

require_once($apiPath .'/configs/Connection.php');

//Models
require_once($apiPath .'/model/Global.model.php');
require_once($apiPath .'/model/Admin.model.php');
require_once($apiPath .'/model/Auth.model.php');

$db = new ConnectionFinProj();
$pdo = $db->connect();

//Model Instantiates
$rm = new ResponseMethodsProj();
$adminCon = new adminControls($pdo, $rm);
$auth = new Auth($pdo, $rm);

$data = json_decode(file_get_contents("php://input"));

$req = [];
if (isset($_REQUEST['request']))
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
else $req = array("errorcatcher");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if($req[0]=='Get'){
            if($req[1]=='One') {echo json_encode($adminCon->getOneAcc($data));return;} 
            if($req[1]=='All') {echo json_encode($adminCon->getAllAcc());return;} 
        }
        
        $rm->notFound();
        break;

    case 'POST':
        if($req[0] == 'Create'){
            if($req[1] == 'Admin'){echo json_encode($auth->adminReg($data)); return;}
            echo json_encode($adminCon->createAcc($data)); 
            return;}
        if($req[0]== 'Login') {
            if($req[1]== 'Admin') {echo json_encode($auth->adminLogin($data));return;}
            if($req[1]== 'Member') {echo json_encode($auth->memLogin($data));return;}
        }

        $rm->notFound();
        break;
    
    case 'PUT':
        if($req[0]=='UpdateStat'){echo json_encode($adminCon->archStat($data)); return;}
        break;

    case 'DELETE':
        if($req[0]=='Delete'){echo json_encode($adminCon->delAcc($data));return;} 
        break;

    default:
        $rm->notFound();
        break;
}
