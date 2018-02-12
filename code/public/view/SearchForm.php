<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Service/ListingService.php');
$vehicleTypes = ListingService::getVehicleTypes();
?>
<!DOCTYPE html>
<html>
    
<title>Search</title>
<body>
    <form action="SearchResults.php" method="get">

    Vehicle Type
    <select name="vehicleTypeId"> 
        <?php 
            foreach($vehicleTypes as $vehicleType) {
            echo '<option value="'.$vehicleType->vehicleTypeId.'">'.$vehicleType->vehicleTypeCode.'</option>';
            }
        ?> 
    </select>
    <br/>
    Price Range: Min <input type="text" name="priceMin"/> Max <input type="text" name="priceMax"><br/>
    Keywords <input type="text" name="keywords"/><br>
    <input type="submit"/>
    </form> 
</body>
</html>