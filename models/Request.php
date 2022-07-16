<?php

//connects to the database
require_once "Database.php"; 

class Request 
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function submitRentRequest($fields)
    {
        
        $this->db->query('INSERT INTO requests (userid,vehicleid,requestdate,rentstart,rentend,approvalstatus,returnstatus) VALUES (:userid,:vehicleid,:requestdate,:rentstart,:rentend,:approvalstatus,:returnstatus)');
        $this->db->bind(':userid',$fields['userid']);
        $this->db->bind(':vehicleid',$fields['vehicleid']);
        $this->db->bind(':requestdate',$fields['requestdate']);
        $this->db->bind(':rentstart',$fields['rentstart']);
        $this->db->bind(':rentend',$fields['rentend']);
        $this->db->bind(':approvalstatus',$fields['approvalstatus']);
        $this->db->bind(':returnstatus',$fields['returnstatus']);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteRentRequest($requestid)
    {
        
        $this->db->query('DELETE FROM requests WHERE requestid = :requestid');
        $this->db->bind(':requestid',$requestid);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function findAllLeasedVehicles()
    {
        $this->db->query("SELECT * FROM requests t1 INNER JOIN users t2 ON t1.userid = t2.userid INNER JOIN vehicles t3 ON t1.vehicleid  = t3.vehicleid WHERE t3.vehiclestatus = 'On-Lease' AND t1.returnstatus = 'NA'");
        
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

    public function findApprovedRentRequestsByUserID($userid)
    {
        $this->db->query("SELECT * FROM requests t1 INNER JOIN users t2 ON t1.userid = t2.userid INNER JOIN vehicles t3 ON t1.vehicleid  = t3.vehicleid WHERE t1.approvalstatus = 'approved' AND t2.userid = :userid");
        $this->db->bind(':userid',$userid);

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

    public function findPendingRentRequestsByUserID($userid)
    {
        $this->db->query("SELECT * FROM requests t1 INNER JOIN users t2 ON t1.userid = t2.userid INNER JOIN vehicles t3 ON t1.vehicleid  = t3.vehicleid WHERE t1.approvalstatus = 'pending' AND t2.userid = :userid");
        $this->db->bind(':userid',$userid);

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

    public function findAllPendingRentRequests()
    {
        $this->db->query("SELECT * FROM requests t1 INNER JOIN users t2 ON t1.userid = t2.userid INNER JOIN vehicles t3 ON t1.vehicleid  = t3.vehicleid WHERE t1.approvalstatus = 'pending'");
        
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

    public function findAllNonPendingRentRequests()
    {
        $this->db->query("SELECT * FROM requests t1 INNER JOIN users t2 ON t1.userid = t2.userid INNER JOIN vehicles t3 ON t1.vehicleid  = t3.vehicleid WHERE t1.approvalstatus != 'pending'");
        
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

    public function changeRentRequestStatus($requestid,$action)
    {
        if ($action == "approve")
        {
            $this->db->query("SELECT vehicleid FROM requests WHERE requestid = :requestid");
            $this->db->bind(':requestid',$requestid);
            $rows = $this->db->getRecord();

            $this->db->query("UPDATE requests SET approvalstatus='approved' WHERE requestid = :requestid");
            $this->db->bind(':requestid',$requestid);
            $this->db->execute();

            $this->db->query("UPDATE vehicles SET vehiclestatus = 'On-Lease' WHERE vehicleid = $rows->vehicleid");
    
            if($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }   

        }
        elseif ($action == "deny")
        {
            $this->db->query("UPDATE requests SET approvalstatus='denied' WHERE requestid = :requestid");
            $this->db->bind(':requestid',$requestid);
            if($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }   
        }
        elseif ($action == "undoapprove")
        {
            $this->db->query("SELECT vehicleid FROM requests WHERE requestid = :requestid");
            $this->db->bind(':requestid',$requestid);
            $rows = $this->db->getRecord();

            $this->db->query("UPDATE requests SET approvalstatus='pending' WHERE requestid = :requestid");
            $this->db->bind(':requestid',$requestid);
            $this->db->execute();

            $this->db->query("UPDATE vehicles SET vehiclestatus = 'On-Lot' WHERE vehicleid = $rows->vehicleid");
    
            if($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }   
        }
        elseif ($action == "undodeny")
        {
            $this->db->query("UPDATE requests SET approvalstatus='pending' WHERE requestid = :requestid");
            $this->db->bind(':requestid',$requestid);
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

}