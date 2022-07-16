<?php
    include_once 'header.php';
    require_once "models/Request.php";

    $requestModel = new Request;
    $pendingrentrequests = $requestModel->findAllPendingRentRequests();
    $vehiclelist = $requestModel->findAllLeasedVehicles();
?>

<?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>

    <section>
        <h3>Pending Rental Requests</h3>
        <br/>
        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th>Request Date</th>
                <th>Vehicle Info</th>
                <th>License Plate</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Rent Start Date</th>
                <th>Rent End Date</th>
                <th>Pick Up Location</th>
                <th>Approval Status</th>
            </tr>
            </thead>
            <?php if(!empty($pendingrentrequests)):?>
            <tbody>
                <?php
                    foreach($pendingrentrequests as $rentrequest) 
                    {
                        echo "<tr>";
                            $userfullnameanduid = $rentrequest->userfname . " " . $rentrequest->userlname . " (" . $rentrequest->useruid . ")";
                            echo "<td>$rentrequest->requestdate</td>";
                            $vehicleinfo = $rentrequest->vehicleyear . " " . $rentrequest->vehiclebrand . " " . $rentrequest->vehiclemodel;
                            echo "<td>$vehicleinfo</td>";
                            echo "<td>$rentrequest->vehiclelicenseplate</td>";
                            echo "<td>$userfullnameanduid</td>";
                            echo "<td>$rentrequest->useraddress</td>";
                            echo "<td>$rentrequest->useremail</td>";
                            echo "<td>$rentrequest->userphonenumber</td>";
                            echo "<td>$rentrequest->rentstart</td>";
                            echo "<td>$rentrequest->rentend</td>";
                            echo "<td>$rentrequest->vehiclelocation</td>";
                            echo "<td>$rentrequest->approvalstatus</td>";
                            if ($rentrequest->approvalstatus == "pending")
                            {
                                echo "<td>
                                <form action='controllers/Requests.ctrl.php' method='post'>
                                <input type='hidden' name='formtype' value='approverentrequest'>
                                <button class='btn btn-normal' type='submit' name='requestid' value='$rentrequest->requestid'>Approve</button>
                                </form>
                                </td>";
                                echo "<td>
                                <form action='controllers/Requests.ctrl.php' method='post'>
                                <input type='hidden' name='formtype' value='denyrentrequest'>
                                <button class='btn btn-danger' type='submit' name='requestid' value='$rentrequest->requestid'>Deny</button>
                                </form>
                                </td>";
                            }
                        echo "</tr>";
                    }  
                ?>
            </tbody>
            <?php endif;?>
        </table>
    </section>

    <section>
        <h3>Vehicles On-Lease</h3>
        <br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Request Date</th>
                <th>Vehicle Info</th>
                <th>License Plate</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Rent Start Date</th>
                <th>Rent End Date</th>
                <th>Approval Status</th>
            </tr>
            </thead>
            <?php if(!empty($vehiclelist)):?>
            <tbody>
                <?php
                    foreach($vehiclelist as $rentrequest) 
                    {
                        echo "<tr>";
                        echo "<td>$rentrequest->requestdate</td>";
                        $vehicleinfo = $rentrequest->vehicleyear . " " . $rentrequest->vehiclebrand . " " . $rentrequest->vehiclemodel;
                        echo "<td>$vehicleinfo</td>";
                        echo "<td>$rentrequest->vehiclelicenseplate</td>";
                        $userfullnameanduid = $rentrequest->userfname . " " . $rentrequest->userlname . " (" . $rentrequest->useruid . ")";
                        echo "<td>$userfullnameanduid</td>";
                        echo "<td>$rentrequest->useraddress</td>";
                        echo "<td>$rentrequest->useremail</td>";
                        echo "<td>$rentrequest->userphonenumber</td>";
                        echo "<td>$rentrequest->rentstart</td>";
                        echo "<td>$rentrequest->rentend</td>";
                        echo "<td>$rentrequest->approvalstatus</td>";
                        echo "<td>
                        <a href='changevehiclestatus.php?vehicleid=$rentrequest->vehicleid'><button class='btn btn-primary'>Change Status</button></a>
                        </td>";
                        echo "</tr>";
                    }  
                ?>
            </tbody>
            <?php endif;?>
        </table>
    </section>

<?php endif;?>

<?php
    include_once 'footer.php';
?>