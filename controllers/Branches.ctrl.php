<?php
session_start();

//Connects to the Models
require_once "../models/Branch.php";

class Branches 
{
    private $branchModel;

    //Creates an instance of the Vehicle model that allows us to access its functions
    public function __construct()
    {
        $this->branchModel = new Branch;
    }

    public function createBranch()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $branchstreet = $_POST['branchstreet'];
        $brancharea = $_POST['brancharea'];
        $branchsector = $_POST['branchsector'];

        if(empty($branchstreet) || empty($brancharea) || empty($branchsector))
        {
            header("location: ../createbranch.php?error=emptyFields");
            exit();
        }

        $branchaddress = $branchstreet . ', ' . $brancharea . ', ' . $branchsector;

        if($this->branchModel->createBranch($branchaddress))
        {
            header("location: ../index.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function deleteBranch()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $branchid = $_POST['branchid'];

        if($this->branchModel->deleteBranch($branchid))
        {
            header("location: ../managebranches.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function updateBranch()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = 
        [
            'branchid' => $_POST['branchid'],
            'branchaddress' => $_POST['branchaddress']
        ];

        if($this->branchModel->updateBranch($fields))
        {
            header("location: ../managebranches.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }



}

//START HERE
//When the form sends data to the page, a hidden input in the form will state its purpose. The below code will read that and call the necessary function that corresponds to the required purpose.
$init = new Branches;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['formtype'] == 'createbranch')
    {
        $init->createBranch();
    }
    else if($_POST['formtype'] == 'deletebranch')
    {
        $init->deleteBranch();
    }
    else if($_POST['formtype'] == 'updatebranch')
    {
        $init->updateBranch();
    }

}
