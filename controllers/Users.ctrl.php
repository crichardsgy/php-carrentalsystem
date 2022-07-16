<?php
session_start();
require_once "../models/User.php";



class Users 
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    //(Qixotl LFC, 2021)
    //https://www.youtube.com/watch?v=lSVGLzGBEe0
    public function register()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = [
            'useruid' => trim($_POST["useruid"]),
            'userfname' => trim($_POST["userfname"]),
            'userlname' => trim($_POST["userlname"]),
            'userpassword' => trim($_POST["userpassword"]),
            'userpasswordconfirm' => trim($_POST["userpasswordconfirm"]),
            'usertype' => "",
            'useraddress' => trim($_POST["useraddress"]),
            'userphonenumber' => trim($_POST["userphonenumber"]),
            'useremail' => trim($_POST["useremail"]),
        ];

        if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin")
        {
            $fields['usertype'] = trim($_POST["usertype"]);
        }
        else
        {
            $fields['usertype'] = "user";
        }

        if(empty($fields['useruid']) || empty($fields['userfname']) || empty($fields['userlname']) || empty($fields['userpassword']) || empty($fields['userpasswordconfirm']) || empty($fields['useraddress']) || empty($fields['userphonenumber']))
        {
            header("location: ../createuser.php?error=emptyFields");
            exit();
        }

        if(preg_match('/\S{128,}/',$fields['useruid'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../createuser.php?error=tooManyCharsInUid");
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['userfname']))
        {
            header("location: ../createuser.php?error=tooManyCharsInFName");
            exit();
        }
        if(preg_match('/\S{128,}/',$fields['userlname'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../createuser.php?error=tooManyCharsInLName");
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['userpassword']))
        {
            header("location: ../createuser.php?error=tooManyCharsInPwd");
            exit();
        }
        if(preg_match('/\S{128,}/',$fields['useraddress']))
        {
            header("location: ../createuser.php?error=tooManyCharsInAddress");
            exit();
        }
        if(preg_match('/\S{10,}/',$fields['userphonenumber']))
        {
            header("location: ../createuser.php?error=tooManyCharsInPhone");
            exit();
        }
        if ($fields['userpassword'] !== $fields['userpasswordconfirm'])
        {
            header("location: ../createuser.php?error=invalidPwdMatch");
            exit();
        }

        if ($this->userModel->findUserByUID($fields['useruid']) !== false)
        {
            header("location: ../createuser.php?error=usernameTaken");
            exit();
        }

        $fields['userpassword'] = password_hash($fields['userpasswordconfirm'], PASSWORD_DEFAULT);

        if ($this->userModel->register($fields))
        {
            if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin")
            {
                header("location: ../manageusers.php?error=none");
            }
            else
            {
                header("location: ../index.php?error=none");
            }
            exit();
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }

    }

    public function login()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = [
            'useruid' => trim($_POST["useruid"]),
            'userpassword' => trim($_POST["userpassword"])
        ];

        if(empty($fields['useruid']) || empty($fields['userpassword']))
        {
            header("location: ../index.php?error=emptyFields");
            exit();
        }

        $row = $this->userModel->findUserByUID($fields['useruid']);

        if ($row == false)
        {
            header("location: ../index.php?error=invalidLogin");
            exit();
        }

        $hashedpwd = $row->userpassword;

        if (password_verify($fields['userpassword'],$hashedpwd) === false)
        {
            header("location: ../index.php?error=invalidLogin");
            exit();
        }
        else if (password_verify($fields['userpassword'],$hashedpwd) === true)
        {
            session_start();
            $_SESSION["userid"] = $row->userid;
            $_SESSION["userfullname"] = $row->userfname . " " . $row->userlname;
            $_SESSION["useruid"] = $row->useruid;
            $_SESSION["usertype"] = $row->usertype;
            header("location: ../index.php");
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("location: ../index.php");
        exit();
    }

    public function updateUser()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $fields = [
            'useruid' => trim($_POST["useruid"]),
            'userid' => trim($_POST["userid"]),
            'userfname' => trim($_POST["userfname"]),
            'userlname' => trim($_POST["userlname"]),
            'userpassword' => trim($_POST["userpassword"]),
            'userpasswordconfirm' => trim($_POST["userpasswordconfirm"]),
            'usertype' => "",
            'useraddress' => trim($_POST["useraddress"]),
            'userphonenumber' => trim($_POST["userphonenumber"]),
            'useremail' => trim($_POST["useremail"]),
        ];

        if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin")
        {
            $fields['usertype'] = trim($_POST["usertype"]);
        }
        else
        {
            $fields['usertype'] = "user";
        }

        if(empty($fields['userfname']) || empty($fields['userlname']) || empty($fields['useraddress']) || empty($fields['userphonenumber']))
        {
            header("location: ../updateuser.php?error=emptyFields&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
            exit();
        }

        if(preg_match('/\S{128,}/',$fields['useruid'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../updateuser.php?error=tooManyCharsInUid&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['userfname']))
        {
            header("location: ../updateuser.php?error=tooManyCharsInFName&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
            exit();
        }
        if(preg_match('/\S{128,}/',$fields['userlname'])) //https://stackoverflow.com/questions/12414258/how-to-find-out-if-some-word-in-a-string-is-bigger-than-50-characters-in-php
        {
                header("location: ../updateuser.php?error=tooManyCharsInLName&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
                exit();
        }
        if(preg_match('/\S{128,}/',$fields['userpassword']))
        {
            header("location: ../updateuser.php?error=tooManyCharsInPwd&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
            exit();
        }
        if(preg_match('/\S{128,}/',$fields['useraddress']))
        {
            header("location: ../updateuser.php?error=tooManyCharsInAddress&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
            exit();
        }
        if(preg_match('/\S{10,}/',$fields['userphonenumber']))
        {
            header("location: ../updateuser.php?error=tooManyCharsInPhone&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
            exit();
        }

        if (!empty($fields['userpassword']) && !empty($fields['userpasswordconfirm']))
        {
            if ($fields['userpassword'] !== $fields['userpasswordconfirm'])
            {
                header("location: ../updateuser.php?error=invalidPwdMatch&userid=".$fields["userid"]."&userfname=".$fields["userfname"]."&userlname=".$fields["userlname"]."&useruid=".$fields["useruid"]."&useraddress=".$fields["useraddress"]."&userphonenumber=".$fields["userphonenumber"]."&useremail=".$fields["useremail"]."&usertype=".$fields["usertype"]);
                exit();
            }
            $fields['userpassword'] = password_hash($fields['userpasswordconfirm'], PASSWORD_DEFAULT);
            $updateoptions = "pass";
        }
        else
        {
            $updateoptions = "nopass";
        }

        if ($this->userModel->updateUser($fields, $updateoptions))
        {
            header("location: ../manageusers.php?error=none");
            exit();
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }

    }

    public function deleteUser()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $userid = $_POST['userid'];

        if($this->userModel->deleteUser($userid))
        {
            header("location: ../manageusers.php?error=none");
        }
        else
        {
            die("Something Went Wrong. Please Try Again Later");
        }
    }

}

$init = new Users;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['formtype'] == 'register')
    {
        $init->register();
    }
    else if ($_POST['formtype'] == 'login')
    {
        $init->login();
    }
    else if ($_POST['formtype'] == 'updateuser')
    {
        $init->updateUser();
    }
    else if ($_POST['formtype'] == 'deleteuser')
    {
        $init->deleteUser();
    }
}
else
{
    if($_GET['state'] == 'logout')
    {
        $init->logout();
    }
    else
    {
        header("location: ../index.php");
    }
}