<?php
    include_once 'header.php';
    require_once "models/Request.php";

    $requestModel = new Request;
    $rentals = $requestModel->findApprovedRentRequestsByUserID($_SESSION["userid"]);
    $pendingrentrequests = $requestModel->findPendingRentRequestsByUserID($_SESSION["userid"]);
?>


<section>
    <h3>Pending Requests</h3>
    <br/>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>Request Date</th>
            <th>Vehicle Info</th>
            <th>License Plate</th>
            <th>Rent Start Date</th>
            <th>Rent End Date</th>
            <th>Pick Up Location</th>
            <th>Approval Status</th>
        </tr>
        </thead>
        <?php if(!empty($pendingrentrequests)):?>
        <tbody>
            <?php
                foreach($pendingrentrequests as $rental) 
                {
                    echo "<tr>";
                        echo "<td>$rental->requestdate</td>";
                        $vehicleinfo = $rental->vehicleyear . " " . $rental->vehiclebrand . " " . $rental->vehiclemodel;
                        echo "<td>$vehicleinfo</td>";
                        echo "<td>$rental->vehiclelicenseplate</td>";
                        echo "<td>$rental->rentstart</td>";
                        echo "<td>$rental->rentend</td>";
                        echo "<td>$rental->vehiclelocation</td>";
                        echo "<td>$rental->approvalstatus</td>";
                        if ($rental->approvalstatus == "pending")
                        {
                            echo "<td>
                            <form action='controllers/Requests.ctrl.php' method='post'>
                            <input type='hidden' name='formtype' value='deleterentrequest'>
                            <button class='btn btn-danger' type='submit' name='requestid' value='$rental->requestid'>Cancel</button>
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
    <h3>My Approved Bookings</h3>
    <br/>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>Request Date</th>
            <th>Vehicle Info</th>
            <th>License Plate</th>
            <th>Rent Start Date</th>
            <th>Rent End Date</th>
            <th>Pick Up Location</th>
            <th>Approval Status</th>
        </tr>
        </thead>
        <?php if(!empty($rentals)):?>
        <tbody>
            <?php
                foreach($rentals as $rental) 
                {
                    echo "<tr>";
                        echo "<td>$rental->requestdate</td>";
                        $vehicleinfo = $rental->vehicleyear . " " . $rental->vehiclebrand . " " . $rental->vehiclemodel;
                        echo "<td>$vehicleinfo</td>";
                        echo "<td>$rental->vehiclelicenseplate</td>";
                        echo "<td>$rental->rentstart</td>";
                        echo "<td>$rental->rentend</td>";
                        echo "<td>$rental->vehiclelocation</td>";
                        echo "<td>$rental->approvalstatus</td>";
                    echo "</tr>";
                }  
            ?>
        </tbody>
        <?php endif;?>
    </table>
</section>


<?php
    include_once 'footer.php';
?>