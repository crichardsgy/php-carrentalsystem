<?php

//connects to the database
require_once "Database.php"; 

class Branch 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function findAllBranches()
    {
        
        $this->db->query('SELECT * FROM branches');
        
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

    public function createBranch($branchaddress)
    {
        
        $this->db->query('INSERT INTO branches (branchaddress) VALUES (:branchaddress)');
        $this->db->bind(':branchaddress',$branchaddress);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteBranch($branchid)
    {
        
        $this->db->query('DELETE FROM branches WHERE branchid = :branchid');
        $this->db->bind(':branchid',$branchid);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateBranch($fields)
    {
            $this->db->query('UPDATE branches SET branchaddress = :branchaddress WHERE branchid = :branchid');
            $this->db->bind(':branchaddress',$fields['branchaddress']);
            $this->db->bind(':branchid',$fields['branchid']);

            if($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
    }
}