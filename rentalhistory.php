<?php
    include_once 'header.php';
    require_once "models/Request.php";

    $requestModel = new Request;
    $nonpendingrentrequests = $requestModel->findAllNonPendingRentRequests();
?>

<?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"): ?>
    <section>
        <h3>Rent Request History</h3>
        <br/>
        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th>Request Date</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Vehicle Info</th>
                <th>License Plate</th>
                <th>Rent Start Date</th>
                <th>Rent End Date</th>
                <th>Pick Up Location</th>
                <th>Approval Status</th>
            </tr>
            </thead>
            <?php if(!empty($nonpendingrentrequests)):?>
            <tbody>
                <?php
                    foreach($nonpendingrentrequests as $rentrequest) 
                    {
                        echo "<tr>";
                            $userfullnameanduid = $rentrequest->userfname . " " . $rentrequest->userlname . " (" . $rentrequest->useruid . ")";
                            echo "<td>$rentrequest->requestdate</td>";
                            echo "<td>$userfullnameanduid</td>";
                            echo "<td>$rentrequest->useraddress</td>";
                            echo "<td>$rentrequest->useremail</td>";
                            echo "<td>$rentrequest->userphonenumber</td>";
                            $vehicleinfo = $rentrequest->vehicleyear . " " . $rentrequest->vehiclebrand . " " . $rentrequest->vehiclemodel;
                            echo "<td>$vehicleinfo</td>";
                            echo "<td>$rentrequest->vehiclelicenseplate</td>";
                            echo "<td>$rentrequest->rentstart</td>";
                            echo "<td>$rentrequest->rentend</td>";
                            echo "<td>$rentrequest->vehiclelocation</td>";
                            echo "<td>$rentrequest->approvalstatus</td>";
                            if ($rentrequest->approvalstatus == "approved" && date('Y-m-d') <= $rentrequest->rentstart)
                            {
                                echo "<td>
                                <form action='controllers/Requests.ctrl.php' method='post'>
                                <input type='hidden' name='formtype' value='undoapproverentrequest'>
                                <button class='btn btn-normal' type='submit' name='requestid' value='$rentrequest->requestid'>Undo Approve</button>
                                </form>
                                </td>";
                            }
                            else if ($rentrequest->approvalstatus == "denied" && date('Y-m-d') <= $rentrequest->rentstart)
                            {
                                echo "<td>
                                <form action='controllers/Requests.ctrl.php' method='post'>
                                <input type='hidden' name='formtype' value='undodenyrentrequest'>
                                <button class='btn btn-normal' type='submit' name='requestid' value='$rentrequest->requestid'>Undo Deny</button>
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

<?php endif;?>

<?php
    include_once 'footer.php';
?>