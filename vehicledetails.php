<?php
    include_once 'header.php';
    include_once 'models/Vehicle.php';

    $vehiclesController = new Vehicle;
    $vehicle = $vehiclesController->findVehicleByID($_GET['vehicleid']);
?>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<?php
    echo("<div class='container'>");
    echo ("<div class='row'>");

    echo ("<div class='col-sm'>");

    ob_start();
    fpassthru($vehicle->vehicleimages);
    $contents = ob_get_contents();
    ob_end_clean(); 
    $dataUri = "data:image/png;base64," . base64_encode($contents);
    echo "<img style='margin-top: 30px; width: 1000px; height: 500px; object-fit: cover;' src='$dataUri'/>";
    echo "<br/><br/>";

    echo "<h2>";
    echo($vehicle->vehicleyear);
    echo (" ");
    echo($vehicle->vehiclebrand);
    echo (" ");
    echo($vehicle->vehiclemodel);
    echo (" ");
    if(isset($_SESSION['userid']))
    {
      echo "<a style='float:right;' href='rentvehicle.php?vehicleid=$vehicle->vehicleid'><button class='btn-primary'>   Rent Vehicle   </button></a>";
    }
    else
    {
      echo "<a style='float:right;' href='login.php'><button class='btn-primary'>   Log In Or Register To Rent   </button></a>";
    }

    echo "</h2>";
    echo "<br/>";

    echo("<table>");
    echo("<tr>");
    echo("    <th>Specification</th>");
    echo("    <th>Details</th>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>Brand:</td>");
    echo("    <td>$vehicle->vehiclebrand</td>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>Model:</td>");
    echo("    <td>$vehicle->vehiclemodel</td>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>Year:</td>");
    echo("    <td>$vehicle->vehicleyear</td>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>VIN:</td>");
    echo("    <td>$vehicle->vehiclevin</td>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>License Plate:</td>");
    echo("    <td>$vehicle->vehiclelicenseplate</td>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>Colour:</td>");
    echo("    <td>$vehicle->vehiclecolour</td>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>Type:</td>");
    echo("    <td>$vehicle->vehicletype</td>");
    echo("</tr>");
    echo("<tr>");
    echo("    <td>Pick Up Location:</td>");
    echo("    <td>$vehicle->vehiclelocation</td>");
    echo("</tr>");
    echo("</table>");

    echo ("</div>");
    echo ("</div>");
?>


<?php
    include_once 'footer.php';
?>