<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Service/AbstractService.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Service/EmailService.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Entity/Seller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Entity/SellerType.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Assignment/src/Entity/SellerReview.php');

Class SellerService extends AbstractService 
{
    public static function getSellerReviews(int $sellerId)
    {
        $sql = "Select * from SELLER_REVIEW where SELLER_ID = $sellerId";
        $result = self::getConnection()->query($sql);
         
        $i = 0;
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
             $review = new SellerReview();
             $review->sellerReviewId = $row['SELLER_REVIEW_ID'];
             $review->sellerId = $row['SELLER_ID'];
             $review->sellerReview = $row['REVIEW'];
             $reviews[$i] = $review;
             $i++;
        }
        return $reviews;
    }
    
    public static function getSeller(int $sellerId)
    {
        $sql = "Select * from SELLER inner join SELLER_TYPE on SELLER_TYPE.SELLER_TYPE_ID = SELLER.SELLER_TYPE_ID where SELLER_ID = $sellerId";
        $result = self::getConnection()->query($sql);
        
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $seller = new Seller();
            $seller->sellerId = $row['SELLER_ID'];
            $seller->name = $row['NAME'];
            $seller->sellerType = new SellerType();
            $seller->sellerType->sellerID =  $row['SELLER_ID'];
            $seller->sellerType->sellerTypeCode =  $row['SELLER_TYPE_CODE'];
            $seller->address = $row['ADDRESS'];
            $seller->phone = $row['PHONE'];
            $seller->email = $row['EMAIL'];
            $seller->website = $row['WEBSITE'];
            $i++;
        }
        return $seller;
    }
    
    public static function emailSeller(int $sellerId, string $message) 
    {
        $seller = self::getSeller($sellerId);
        return EmailService::sendEmail($seller->email, 'Message from potential buyer', $message);
    }
    
}