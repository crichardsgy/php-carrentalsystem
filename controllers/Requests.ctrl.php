<?php
session_start();

//Connects to the Models
require_once "../models/Request.php";

class Requests 
{
    private $requestModel;

    //Creates an instance of the Vehicle model that allows us to access its functions
    public function __construct()
    {
        $this->requestModel = new Request;
    }

    public function submitRentRequest()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $rentstart = new DateTime($_POST['rentstart']);
        $rentend = new DateTime($_POST['rentend']);

        if ($rentend < $rentstart)
        {
            header("location: ../rentvehicle.php?error=rentOutOfBounds");
            exit();  
        }

        $fields = 
        [
            'userid' => intval($_SESSION['userid']),
            'vehicleid' => intval($_POST['vehicleid']),
            'rentstart' => $_POST['rentstart'],
            'rentend' => $_POST['rentend'],
            'approvalstatus' => "pending",
            'returnstatus' => "NA",
            'requestdate' => date('Y-m-d H:i:s')
        ];

        if(empty($fields['rentstart']) || empty($fields['rentend']))
        {
            header("location: ../rentvehicle.php?error=emptyFields");
            exit();
        }

        if($this->requestModel->submitRentRequest($fields))
        {
            header("location: ../index.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function changeRentRequestStatus($action)
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $requestid = $_POST['requestid'];

        if($this->requestModel->changeRentRequestStatus($requestid,$action))
        {
            header("location: ../managerentals.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function deleteRentRequest()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $requestid = $_POST['requestid'];

        if($this->requestModel->deleteRentRequest($requestid))
        {
            header("location: ../mybookings.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }



}

//START HERE
//When the form sends data to the page, a hidden input in the form will state its purpose. The below code will read that and call the necessary function that corresponds to the required purpose.
$init = new Requests;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['formtype'] == 'submitrentrequest')
    {
        $init->submitRentRequest();
    }
    if($_POST['formtype'] == 'deleterentrequest')
    {
        $init->deleteRentRequest();
    }
    else if ($_POST['formtype'] == 'approverentrequest')
    {
        $init->changeRentRequestStatus("approve");
    }
    else if ($_POST['formtype'] == 'denyrentrequest')
    {
        $init->changeRentRequestStatus("deny");
    }
    else if ($_POST['formtype'] == 'undoapproverentrequest')
    {
        $init->changeRentRequestStatus("undoapprove");
    }
    else if ($_POST['formtype'] == 'undodenyrentrequest')
    {
        $init->changeRentRequestStatus("undodeny");
    }
}
