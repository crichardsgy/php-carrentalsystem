<?php

//connects to the database
require_once "Database.php"; 

class User 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function register($fields)
    {
        
        $this->db->query('INSERT INTO users (useruid,userfname,userlname,userpassword,usertype,useraddress,userphonenumber,useremail) VALUES (:useruid,:userfname,:userlname,:userpassword,:usertype,:useraddress,:userphonenumber,:useremail)');
        $this->db->bind(':useruid',$fields['useruid']);
        $this->db->bind(':userfname',$fields['userfname']);
        $this->db->bind(':userlname',$fields['userlname']);
        $this->db->bind(':userpassword',$fields['userpassword']);
        $this->db->bind(':usertype',$fields['usertype']);
        $this->db->bind(':useraddress',$fields['useraddress']);
        $this->db->bind(':userphonenumber',$fields['userphonenumber']);
        $this->db->bind(':useremail',$fields['useremail']);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateUser($fields, $updateoptions)
    {
        if ($updateoptions == "pass")
        {
            $this->db->query('UPDATE users SET userfname = :userfname, userlname = :userlname, userpassword = :userpassword, usertype = :usertype, useraddress = :useraddress, userphonenumber = :userphonenumber, useremail = :useremail WHERE userid = :userid');
            $this->db->bind(':userpassword',$fields['userpassword']);
        }
        elseif ($updateoptions == "nopass")
        {
            $this->db->query('UPDATE users SET userfname = :userfname, userlname = :userlname, usertype = :usertype, useraddress = :useraddress, userphonenumber = :userphonenumber, useremail = :useremail WHERE userid = :userid');
        }

        $this->db->bind(':userfname',$fields['userfname']);
        $this->db->bind(':userlname',$fields['userlname']);
        $this->db->bind(':usertype',$fields['usertype']);
        $this->db->bind(':useraddress',$fields['useraddress']);
        $this->db->bind(':userphonenumber',$fields['userphonenumber']);
        $this->db->bind(':useremail',$fields['useremail']);
        $this->db->bind(':userid',$fields['userid']);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteUser($userid)
    {
        
        $this->db->query('DELETE FROM requests WHERE userid = :userid');
        $this->db->bind(':userid',$userid);
        $this->db->execute();

        $this->db->query('DELETE FROM users WHERE userid = :userid');
        $this->db->bind(':userid',$userid);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function findUserByUID($useruid)
    {
        $this->db->query("SELECT * FROM users WHERE useruid = :useruid");
        $this->db->bind(':useruid',$useruid);

        $row = $this->db->getRecord();

        if($this->db->getRowCount() > 0)
        {
            return $row;
        }
        else
        {
            return false;
        }
    }

    public function findAllUsers()
    {
        $this->db->query("SELECT * FROM users");

        $rows = $this->db->getRecordSet();

        if($this->db->getRowCount() > 0)
        {
            return $rows;
        }
        else
        {
            return false;
        }
    }
   
}