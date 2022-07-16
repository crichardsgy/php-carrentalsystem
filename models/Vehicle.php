<?php

//connects to the database
require_once "Database.php"; 

class Vehicle 
{
    private $db;

    //Creates a database object that allows us to access its functions (see models/Database.php for more info)
    public function __construct()
    {
        $this->db = new Database;
    }

    public function addVehicle($fields)
    {
        //the query itself with placeholders for data we wish to push
        $this->db->query('INSERT INTO vehicles (vehiclevin,vehiclelicenseplate,vehiclelicenseexpiration,vehiclefitnessexpiration,vehiclecolour,vehiclebrand,vehiclemodel,vehicleyear,vehicletype,vehiclelocation,vehicleimages,vehiclestatus) VALUES (:vehiclevin,:vehiclelicenseplate,:vehiclelicenseexpiration,:vehiclefitnessexpiration,:vehiclecolour,:vehiclebrand,:vehiclemodel,:vehicleyear,:vehicletype,:vehiclelocation,:vehicleimages,:vehiclestatus)');

        //replaces those placeholders with the actual data we passed into this function
        $this->db->bind(':vehiclevin',$fields['vehiclevin']);
        $this->db->bind(':vehiclelicenseplate',$fields['vehiclelicenseplate']);
        $this->db->bind(':vehiclelicenseexpiration',$fields['vehiclelicenseexpiration']);
        $this->db->bind(':vehiclefitnessexpiration',$fields['vehiclefitnessexpiration']);
        $this->db->bind(':vehiclecolour',$fields['vehiclecolour']);
        $this->db->bind(':vehiclebrand',$fields['vehiclebrand']);
        $this->db->bind(':vehiclemodel',$fields['vehiclemodel']);
        $this->db->bind(':vehicleyear',$fields['vehicleyear']);
        $this->db->bind(':vehicletype',$fields['vehicletype']);
        $this->db->bind(':vehiclelocation',$fields['vehiclelocation']);
        $this->db->bind(':vehicleimages',$fields['vehicleimages'], PDO::PARAM_LOB);
        $this->db->bind(':vehiclestatus',$fields['vehiclestatus']);

        //the execution of the prepared statement
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }  

    public function updateVehicle($fields, $updateoptions)
    {

        if ($updateoptions == "images")
        {
            $this->db->query('UPDATE vehicles SET vehiclevin=:vehiclevin,vehiclelicenseplate=:vehiclelicenseplate,vehiclelicenseexpiration=:vehiclelicenseexpiration,vehiclefitnessexpiration=:vehiclefitnessexpiration,vehiclecolour=:vehiclecolour,vehiclebrand=:vehiclebrand,vehiclemodel=:vehiclemodel,vehicleyear=:vehicleyear,vehicletype=:vehicletype,vehiclelocation=:vehiclelocation,vehicleimages=:vehicleimages WHERE vehicleid = :vehicleid');
            $this->db->bind(':vehicleimages',$fields['vehicleimages'], PDO::PARAM_LOB);
        }
        elseif ($updateoptions == "noimages")
        {
            $this->db->query('UPDATE vehicles SET vehiclevin=:vehiclevin,vehiclelicenseplate=:vehiclelicenseplate,vehiclelicenseexpiration=:vehiclelicenseexpiration,vehiclefitnessexpiration=:vehiclefitnessexpiration,vehiclecolour=:vehiclecolour,vehiclebrand=:vehiclebrand,vehiclemodel=:vehiclemodel,vehicleyear=:vehicleyear,vehicletype=:vehicletype,vehiclelocation=:vehiclelocation WHERE vehicleid = :vehicleid');
        }

        //replaces those placeholders with the actual data we passed into this function
        $this->db->bind(':vehiclevin',$fields['vehiclevin']);
        $this->db->bind(':vehiclelicenseplate',$fields['vehiclelicenseplate']);
        $this->db->bind(':vehiclelicenseexpiration',$fields['vehiclelicenseexpiration']);
        $this->db->bind(':vehiclefitnessexpiration',$fields['vehiclefitnessexpiration']);
        $this->db->bind(':vehiclecolour',$fields['vehiclecolour']);
        $this->db->bind(':vehiclebrand',$fields['vehiclebrand']);
        $this->db->bind(':vehiclemodel',$fields['vehiclemodel']);
        $this->db->bind(':vehicleyear',$fields['vehicleyear']);
        $this->db->bind(':vehicletype',$fields['vehicletype']);
        $this->db->bind(':vehiclelocation',$fields['vehiclelocation']);
        $this->db->bind(':vehicleid',$fields['vehicleid']);

        //the execution of the prepared statement
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function changeVehicleStatus($fields)
    {
        $this->db->query('UPDATE vehicles SET vehiclelocation=:vehiclelocation,vehiclestatus=:vehiclestatus WHERE vehicleid = :vehicleid');

        //replaces those placeholders with the actual data we passed into this function
        $this->db->bind(':vehiclelocation',$fields['vehiclelocation']);
        $this->db->bind(':vehiclestatus',$fields['vehiclestatus']);
        $this->db->bind(':vehicleid',$fields['vehicleid']);
        $this->db->execute();

        $this->db->query('UPDATE requests SET returnstatus=:returnstatus WHERE vehicleid = :vehicleid');
        $this->db->bind(':returnstatus',$fields['returnstatus']);
        $this->db->bind(':vehicleid',$fields['vehicleid']);

        //the execution of the prepared statement
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }  

    public function deleteVehicle($vehicleid)
    {
        
        $this->db->query('DELETE FROM requests WHERE vehicleid = :vehicleid');
        $this->db->bind(':vehicleid',$vehicleid);
        $this->db->execute();

        $this->db->query('DELETE FROM vehicles WHERE vehicleid = :vehicleid');
        $this->db->bind(':vehicleid',$vehicleid);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function findAllAvailableVehicles()
    {
        $this->db->query("SELECT * FROM vehicles WHERE vehiclestatus != 'On-Lease'");
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

    public function findAllVehicles()
    {
        $this->db->query("SELECT * FROM vehicles");
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

    public function findVehiclesByStatus($vehiclestatus)
    {
        $this->db->query("SELECT * FROM vehicles WHERE vehiclestatus = :vehiclestatus");
        $this->db->bind(':vehiclestatus',$vehiclestatus);
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

    public function findVehicleByID($vehicleid)
    {
        $this->db->query("SELECT * FROM vehicles where vehicleid = :vehicleid");
        $this->db->bind(':vehicleid',$vehicleid);
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
}