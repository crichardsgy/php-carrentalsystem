<?php 

    include_once "Database.php";
    $db = new Database;

    $createStatements = 
    [
      " CREATE TABLE IF NOT EXISTS vehicles(
          vehicleid serial PRIMARY KEY,
          vehiclevin varchar(128) NOT NULL,
          vehiclelicenseplate varchar(128) NOT NULL,
          vehiclelicenseexpiration varchar(128),
          vehiclefitnessexpiration varchar(128),
          vehiclecolour varchar(128),
          vehiclebrand varchar(128),
          vehiclemodel varchar(128),
          vehicletype varchar(128),
          vehicleyear varchar(128),
          vehicleimages BYTEA,
          vehiclelocation varchar(128),
          vehiclestatus varchar(128)
        );",

        
      " CREATE TABLE IF NOT EXISTS users(
          userid serial PRIMARY KEY,
          useruid varchar(128) NOT NULL,
          userfname varchar(128) NOT NULL,
          userlname varchar(128) NOT NULL,
          userpassword varchar(128) NOT NULL,
          useraddress varchar(128) NOT NULL,
          useremail varchar(128) NOT NULL,
          userphonenumber varchar(128) NOT NULL,
          usertype varchar(128) NOT NULL
        );",

        "CREATE TABLE IF NOT EXISTS requests(
          requestid serial PRIMARY KEY,
          userid serial,
          vehicleid serial,
          requestdate varchar(30),
          rentstart varchar(30),
          rentend varchar(30),
          approvalstatus varchar(20),
          returnstatus varchar(20),
          FOREIGN KEY (userid) REFERENCES users(userid),
          FOREIGN KEY (vehicleid) REFERENCES vehicles(vehicleid)
        );",

        "CREATE TABLE IF NOT EXISTS branches(
          branchid serial PRIMARY KEY,
          branchaddress varchar(128)
        );",
    ];

    try 
    {
      foreach($createStatements as $statement) {
          $db->query($statement);
          $db->execute();
      }
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $fields = [
      'useruid' => "admin",
      'userfname' => "admin",
      'userlname' => "admin",
      'userpassword' => "admin",
      'usertype' => "admin",
      'useraddress' => "admin",
      'userphonenumber' => "0000000",
      'useremail' => "admin@admin.com",
    ];

  $fields['userpassword'] = password_hash($fields['userpassword'], PASSWORD_DEFAULT);


  //add default admin user
  $db->query("SELECT * FROM users WHERE usertype = 'admin'");
  $db->execute();
  if($db->getRowCount() > 0)
  {
    return;
  }
  else
  {
    $db->query('INSERT INTO users (useruid,userfname,userlname,userpassword,usertype,useraddress,userphonenumber,useremail) VALUES (:useruid,:userfname,:userlname,:userpassword,:usertype,:useraddress,:userphonenumber,:useremail)');
    $db->bind(':useruid',$fields['useruid']);
    $db->bind(':userfname',$fields['userfname']);
    $db->bind(':userlname',$fields['userlname']);
    $db->bind(':userpassword',$fields['userpassword']);
    $db->bind(':usertype',$fields['usertype']);
    $db->bind(':useraddress',$fields['useraddress']);
    $db->bind(':userphonenumber',$fields['userphonenumber']);
    $db->bind(':useremail',$fields['useremail']);
    
    try
    {
      $db->execute();
      echo "<h4>Default Username/Password Is admin/admin.</h4>";
      echo "<h5>Please Change Accordingly. This Message Will Not Be Displayed Again.</h5>";
    }
    catch (PDOException $e)
    {
      echo $e->getMessage();
    }
  }

  unset($db);




