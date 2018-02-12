<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Service/AbstractService.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Entity/Listing.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Entity/VehicleType.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Entity/ListingImage.php');

Class ListingService extends AbstractService 
{   
    public static function getVehicleTypes()
    {
        $sql = "Select * from VEHICLE_TYPE";
        $result = self::getConnection()->query($sql);
        $i = 0;
        $vehicleTypes = [];
        while ($row = $result->fetch_assoc()) 
        {
            $vehicleType = new VehicleType;
            $vehicleType->vehicleTypeId = $row['VEHICLE_TYPE_ID'];
            $vehicleType->vehicleTypeCode = $row['VEHICLE_TYPE_CODE'];
            $vehicleTypes[$i] = $vehicleType;
            $i++;
        }
        return $vehicleTypes;
    }
    
    /*
    This is a very rudimentary search. A better search would more complex and is discussed in the design document.
    */
    public static function doSearch(int $vehicleTypeId, $priceMin, $priceMax, $keywords)
    {
        $sql = "select * from LISTING ";
        // Assuming that all listing have atleast one image.
        $sql .= " inner join LISTING_IMAGE on LISTING.LISTING_ID = LISTING_IMAGE.LISTING_ID ";
        $sql .= " inner join VEHICLE_TYPE on LISTING.VEHICLE_TYPE_ID = VEHICLE_TYPE.VEHICLE_TYPE_ID ";
        $sql .= " where VEHICLE_TYPE.VEHICLE_TYPE_ID=$vehicleTypeId";
          
        if ($priceMin) {
            $sql .= " and PRICE >= $priceMin";
        }
        if ($priceMax) {
            $sql .= " and PRICE <= $priceMax";    
        }
        if($keywords)
        {
            $sql .= " and MAKE like '%$keywords%'";    
        }
        $sql .= " and LISTING_IMAGE.IS_PRIMARY = 1";
        $result = self::getConnection()->query($sql);

        $i = 0;
        $listings = [];
        while ($row = $result->fetch_assoc()) 
        { 
            $listing = self::buildListing($row);
            // Since the Listing class already has a images attribute, repurpose that to store the primary image as the first image.
            $listing->images = [];
            $listing->images[0] = new ListingImage();
            $listing->images[0]->listingId = $row['LISTING_ID'];
            $listing->images[0]->imageId = $row['IMAGE_ID'];
            $listing->images[0]->url = $row['IMAGE_URL'];
            $listings[$i] = $listing;
            $i++;
        }
        return $listings;
    }
    
    public static function getListing($listingId)
    {
        $sql = "Select * from LISTING inner join VEHICLE_TYPE on LISTING.VEHICLE_TYPE_ID = VEHICLE_TYPE.VEHICLE_TYPE_ID where LISTING_ID =           $listingId";
        $result = self::getConnection()->query($sql);
        $row = $result->fetch_assoc();
        if(!$row)
        {
            echo 'Listing not found for id='.$listingId;
            exit;
        }
        $listing = self::buildListing($row);
        $listing->images = ListingService::getImages($listingId);

        return $listing;
    }
    
    public static function getImages($listingId)
    {
        $sql = "Select * from LISTING_IMAGE where LISTING_ID = $listingId";
        $result = self::getConnection()->query($sql);
        
        $i = 0;
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $image = new ListingImage();
            $image->imageId = $row['IMAGE_ID'];
            $image->listingId = $row['LISTING_ID'];
            $image->url = $row['IMAGE_URL'];
            $image->isPrimary = $row['IS_PRIMARY'];
            $images[$i] = $image;
            $i++;
        }
        return $images;
    }  
    
    private static function buildListing($row) {
        // Ideally we'd use an ORM like Laravel with Eloquent so such mappings here and in the other services would not be required.
        $listing = new Listing();
        $listing->listingId = $row['LISTING_ID'];
        $listing->sellerId = $row['SELLER_ID'];
        $listing->make = $row['MAKE'];
        $listing->model = $row['MODEL'];
        $listing->year = $row['YEAR'];
        $listing->color = $row['COLOR'];
        $listing->vehicleType = new VehicleType();
        $listing->vehicleType->vehicleTypeId = $row['VEHICLE_TYPE_ID'];
        $listing->vehicleType->vehicleTypeCode = $row['VEHICLE_TYPE_CODE'];
        $listing->transmission = $row['TRANSMISSION'];
        $listing->description = $row['DESCRIPTION'];
        $listing->bodyType = $row['BODY_TYPE'];
        return $listing;
    }
}