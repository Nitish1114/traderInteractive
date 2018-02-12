<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Service/ListingService.php');

$vehicleTypeId = $_GET["vehicleTypeId"];
$priceMin = $_GET["priceMin"];
$priceMax = $_GET["priceMax"];
$keywords = $_GET["keywords"];

if (strlen ($vehicleTypeId) == 0)
{
    echo "Missing required param vehicleTypeId";
    exit;
}
if (strlen ($priceMin) > 0 and !is_numeric($priceMin)) 
{
    echo "Invalid value for param priceMin";
    exit;
}
if (strlen ($priceMax) > 0 and !is_numeric($priceMax)) 
{
    echo "Invalid value for param priceMax";
    exit;
}
$listings = ListingService::doSearch($vehicleTypeId,$priceMin,$priceMax,$keywords);
?>
<!DOCTYPE html>
<html>
<title>Listing</title>
<body>
    <ol>
        
            <?php
            if($listings)
            {
                foreach($listings as $listing)
                { 
            ?>
                 <li>
                     <a href="<? echo "ListingDetail.php?listingId=".$listing->listingId;?>"><? echo $listing->images[0]->url;?><br></a> 
                     <br>
                     <a href="<? echo "ListingDetail.php?listingId=".$listing->listingId;?>"><? echo $listing->year;?><br></a> 
                     <a href="<? echo "ListingDetail.php?listingId=".$listing->listingId;?>"><? echo $listing->make;?><br></a> 
                     <a href="<? echo "ListingDetail.php?listingId=".$listing->listingId;?>"><? echo $listing->model;?><br></a> 
                </li>
            <br><br>
            <?php 
                    
                }
            }
            else 
            {
                echo 'No listing found';
            }
        ?>
    </ol>
</body>
</html>
    

