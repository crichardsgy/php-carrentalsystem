<?php
session_start();

//Connects to the Models
require_once "../models/Vehicle.php";

class Vehicles 
{
    private $vehicleModel;

    //Creates an instance of the Vehicle model that allows us to access its functions
    public function __construct()
    {
        $this->vehicleModel = new Vehicle;
    }

    public function addVehicle()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        //stores data sent by POST from the form
        $fields = [
            'vehiclevin' => trim($_POST["vehiclevin"]),
            'vehiclelicenseplate' => trim($_POST["vehiclelicenseplate"]),
            'vehiclelicenseexpiration' => trim($_POST["vehiclelicenseexpiration"]),
            'vehiclefitnessexpiration' => trim($_POST["vehiclefitnessexpiration"]),
            'vehiclecolour' => trim($_POST["vehiclecolour"]),
            'vehiclebrand' => trim($_POST["vehiclebrand"]),
            'vehiclemodel' => trim($_POST["vehiclemodel"]),
            'vehicleyear' => trim($_POST["vehicleyear"]),
            'vehicletype' => trim($_POST["vehicletype"]),
            'vehiclelocation' => trim($_POST["vehiclelocation"]),
            'vehicleimages' => $_FILES["vehicleimages"],
            'vehiclestatus' => "On-Lot",
        ];

        if($_FILES['vehicleimages']['error'] > 0)
        {
            $updateoptions = "noimages";
        }
        else
        {
            $errors= array();
            $file_name = $_FILES['vehicleimages']['name'];
            $file_size =$_FILES['vehicleimages']['size'];
            $file_tmp =$_FILES['vehicleimages']['tmp_name'];
            $file_type=$_FILES['vehicleimages']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['vehicleimages']['name'])));
            
            $extensions= array("jpeg","jpg","png");
            
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if($file_size > 2097152){
                $errors[]='File size must be less than 2 MB';
            }
    
            $randomname = uniqid();
            
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,"../images/".$randomname);
                echo "Success";
            }else{
                print_r($errors);
            }
        
    
            $img = fopen("../images/".$randomname, 'r') or die("cannot read image\n");
            $fields['vehicleimages'] = fread($img, filesize("../images/".$randomname));
            fclose($img);

            $updateoptions = "images";
        }

        //checks if a field in the form is empty
        if(empty($fields['vehiclevin']) || empty($fields['vehiclebrand']) || empty($fields['vehicleyear']) || empty($fields['vehiclemodel']) || empty($fields['vehicletype']) || empty($fields['vehiclelicenseplate']) || empty($fields['vehiclelocation']))
        {
            //returns the user to the form if successful with the GET "error" variable showing the reason
            header("location: ../addvehicle.php?error=emptyFields");
            exit();
        }

        //checks size of string in specific field of the form (change the 128 to the max size of the database column)
        if(preg_match('/\S{128,}/',$fields['vehiclevin'])) 
        {
                header("location: ../addvehicle.php?error=tooManyCharsInVIN");
                exit();
        }

        //sends the validated data from the fields to the addVehicle function in the model which will push it to the database
        if ($this->vehicleModel->addVehicle($fields))
        {
            if ($updateoptions == "images")
            {
                unlink('../images/'.$randomname); 
            }
            //returns the user to the homescreen if successful
            header("location: ../managevehicles.php?error=none");
            exit();
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }

    }

    public function updateVehicle()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        //stores data sent by POST from the form
        $fields = [
            'vehicleid' => trim($_POST["vehicleid"]),
            'vehiclevin' => trim($_POST["vehiclevin"]),
            'vehiclelicenseplate' => trim($_POST["vehiclelicenseplate"]),
            'vehiclelicenseexpiration' => trim($_POST["vehiclelicenseexpiration"]),
            'vehiclefitnessexpiration' => trim($_POST["vehiclefitnessexpiration"]),
            'vehiclecolour' => trim($_POST["vehiclecolour"]),
            'vehiclebrand' => trim($_POST["vehiclebrand"]),
            'vehiclemodel' => trim($_POST["vehiclemodel"]),
            'vehicleyear' => trim($_POST["vehicleyear"]),
            'vehicletype' => trim($_POST["vehicletype"]),
            'vehiclelocation' => trim($_POST["vehiclelocation"]),
            'vehicleimages' => $_FILES["vehicleimages"],
            'vehiclestatus' => $_POST["vehiclestatus"],
        ];

        if($_FILES['vehicleimages']['error'] > 0)
        {
            $updateoptions = "noimages";
        }
        else
        {
            $errors= array();
            $file_name = $_FILES['vehicleimages']['name'];
            $file_size =$_FILES['vehicleimages']['size'];
            $file_tmp =$_FILES['vehicleimages']['tmp_name'];
            $file_type=$_FILES['vehicleimages']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['vehicleimages']['name'])));
            
            $extensions= array("jpeg","jpg","png");
            
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if($file_size > 2097152){
                $errors[]='File size must be less than 2 MB';
            }
    
            $randomname = uniqid();
            
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,"../images/".$randomname);
                echo "Success";
            }else{
                print_r($errors);
            }
        
    
            $img = fopen("../images/".$randomname, 'r') or die("cannot read image\n");
            $fields['vehicleimages'] = fread($img, filesize("../images/".$randomname));
            fclose($img);

            $updateoptions = "images";
        }

        //checks if a field in the form is empty
        if(empty($fields['vehiclevin']) || empty($fields['vehiclebrand']) || empty($fields['vehicleyear']) || empty($fields['vehiclemodel']) || empty($fields['vehicletype']) || empty($fields['vehiclelicenseplate']) || empty($fields['vehiclelocation']))
        {
            //returns the user to the form if successful with the GET "error" variable showing the reason
            header("location: ../addvehicle.php?error=emptyFields&vehicleid=".$fields["vehicleid"]."&vehiclebrand=".$fields["vehiclebrand"]."&vehiclemodel=".$fields["vehiclemodel"]."&vehicleyear=".$fields["vehicleyear"]."&vehiclevin=".$fields["vehiclevin"]."&vehiclelicenseplate=".$fields["vehiclelicenseplate"]."&vehiclelicenseexpiration=".$fields["vehiclelicenseexpiration"]."&vehiclefitnessexpiration=".$fields["vehiclefitnessexpiration"] . "&vehiclecolour=".$fields["vehiclecolour"]."&vehicletype=".$fields["vehicletype"]."&vehiclelocation=".$fields["vehiclelocation"]."&vehiclestatus=".$fields["vehiclestatus"]);
            exit();
        }

        //checks size of string in specific field of the form (change the 128 to the max size of the database column)
        if(preg_match('/\S{128,}/',$fields['vehiclevin'])) 
        {
            header("location: ../addvehicle.php?error=tooManyCharsInVIN&vehicleid=".$fields["vehicleid"]."&vehiclebrand=".$fields["vehiclebrand"]."&vehiclemodel=".$fields["vehiclemodel"]."&vehicleyear=".$fields["vehicleyear"]."&vehiclevin=".$fields["vehiclevin"]."&vehiclelicenseplate=".$fields["vehiclelicenseplate"]."&vehiclelicenseexpiration=".$fields["vehiclelicenseexpiration"]."&vehiclefitnessexpiration=".$fields["vehiclefitnessexpiration"]."&vehiclecolour=".$fields["vehiclecolour"]."&vehicletype=".$fields["vehicletype"]."&vehiclelocation=".$fields["vehiclelocation"]."&vehiclestatus=".$fields["vehiclestatus"]);
            exit();
        }

        //sends the validated data from the fields to the addVehicle function in the model which will push it to the database
        if ($this->vehicleModel->updateVehicle($fields, $updateoptions))
        {
            if ($updateoptions == "images")
            {
                unlink('../images/'.$randomname); 
            }

            //returns the user to the homescreen if successful
            header("location: ../managevehicles.php?error=none");
            exit();
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }

    }

    public function deleteVehicle()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $vehicleid = $_POST['vehicleid'];

        if($this->vehicleModel->deleteVehicle($vehicleid))
        {
            header("location: ../managevehicles.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

    public function changeVehicleStatus()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        //stores data sent by POST from the form
        $fields = [
            'vehicleid' => trim($_POST["vehicleid"]),
            'vehiclelocation' => trim($_POST["vehiclelocation"]),
            'vehiclestatus' => $_POST["vehiclestatus"],
            'returnstatus' => "",
        ];

        if($fields["vehiclestatus"] == "On-Lot")
        {
            $fields["returnstatus"] = "RETURNED";
        }
        else
        {
            $fields["returnstatus"] = "NA";
        }

        //checks if a field in the form is empty
        if( empty($fields['vehiclestatus']) || empty($fields['vehiclelocation']))
        {
            //returns the user to the form if successful with the GET "error" variable showing the reason
            header("location: ../changevehiclestatus.php?error=emptyFields&vehicleid=".$fields["vehicleid"]);
            exit();
        }

        //sends the validated data from the fields to the addVehicle function in the model which will push it to the database
        if ($this->vehicleModel->changeVehicleStatus($fields))
        {
            //returns the user to the homescreen if successful
            header("location: ../managerentals.php?error=none");
            exit();
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }

    }

}

//START HERE
//When the form sends data to the page, a hidden input in the form will state its purpose. The below code will read that and call the necessary function that corresponds to the required purpose.
$init = new Vehicles;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['formtype'] == 'addvehicle')
    {
        $init->addVehicle();
    }
    else if($_POST['formtype'] == 'updatevehicle')
    {
        $init->updateVehicle();
    }
    else if($_POST['formtype'] == 'deletevehicle')
    {
        $init->deleteVehicle();
    }
    else if($_POST['formtype'] == 'changevehiclestatus')
    {
        $init->changeVehicleStatus();
    }

}
