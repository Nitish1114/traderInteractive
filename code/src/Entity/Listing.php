<?php
Class Listing 
{
    public $listingId;
    public $vehicleType; // Type VehicleType.
    public $sellerId;
    public $make;
    public $model;
    public $year;
    public $color;
    public $transmission;
    public $bodyType;
    public $images;
    
    public function getPrimaryImage()
    {
        foreach($this->images as $image) {
            if ($image->isPrimary == 0) {
                return $image;
            }  
        }
        // No image marked as primary. Consider 1st image as primary.
        if (isset($this->images) and !empty($this->images)) {
            return $this->images[0];
        }
    }
}