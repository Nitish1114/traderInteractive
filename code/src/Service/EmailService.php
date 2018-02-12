<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Service/AbstractService.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Entity/Seller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Entity/SellerType.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Entity/SellerReview.php');

Class EmailService extends AbstractService 
{
    public static function sendEmail(string $emailAddress, string $subject, string $body)
    {
        // Send to email depending on environment. For now just output email and message.
        // Consider recording all outbound mails in DB.
        echo 'Email Address: '.$emailAddress;
        echo 'Email Subject: '.$subject;
        echo 'Email Body: '.$body;
        return true; // Return true assuming email send was successful.
    }
}