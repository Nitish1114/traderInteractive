<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Service/ListingService.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Service/SellerService.php');
$listingId = $_GET["listingId"];
if (strlen ($listingId) == 0 )
{
    echo "Report to Log and redirect ";
    exit;
}

$listing = ListingService::getListing($listingId);
?>
<!DOCTYPE html>
<html>
<title>Assignment</title>
<body>
    <ul>
        
        <?php
            foreach($listing->images as $image)
            {      
        ?>
                 <li>
                    <img src="<? echo $image->url?>" alt="<? echo $image->url?>">
                </li>
        <?php  
            }
        ?>
    </ul>
    <div> 
        <div>
            Make: <? echo $listing->make?>
        </div>
         <div>
            Model: <? echo $listing->model?>
        </div>
         <div>
            Year: <? echo $listing->year?>
        </div>
         <div>
            Color: <? echo $listing->color?>
        </div>
         <div>
            Body Type: <? echo $listing->bodyType?>
        </div>
         <div>
            Vehicle Type: <? echo $listing->vehicleType->vehicleTypeCode?>
        </div>
         <div>
            Transmission: <? echo $listing->transmission?>
        </div>
         <div>
            Description: <? echo $listing->description?>
        </div> 
    </div>
    
    <?php
        $seller = SellerService::getSeller($listing->sellerId);
        $sellerReviews = SellerService::getSellerReviews($listing->sellerId);
    ?>
    
    <div>Seller: <? echo  "$seller->name  [".  $seller->sellerType->sellerTypeCode."]"?>  </div>
    <div>Reviews</div>
    <ol>
           <?php
                
                foreach($sellerReviews as $sellerReview)
                { 
            ?>
                    <li><? echo $sellerReview->sellerReview?></li>
            <?php  
                }
           ?>
    </ol>
    <div>Contact Seller</div>
    <div>
    <form action="ContactSeller.php" method="post">
        <input type="hidden" name="sellerId" value="<? echo $seller->sellerId?>"/>
        <!-- TODO Make an AJAX Call here for a better user experience -->
        <textarea name="message" rows="4" cols="50"> </textarea>
        <br/>
        <input type="submit" value="Email Seller"/>
    </form>
    </div>

<?php

?>
</body>
</html>