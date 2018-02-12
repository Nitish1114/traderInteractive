<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/code/src/Service/SellerService.php');

$sellerId = $_POST["sellerId"];
$message = $_POST["message"];

if (!$sellerId)
{
    echo "Missing required param sellerId";
    exit;
}
if (strlen ($message) == 0) 
{
    echo "Missing required param message";
    exit;
}

$sentMessage = SellerService::emailSeller($sellerId, $message);
?>
<!DOCTYPE html>
<html>
<title>Contact Seller</title>
<body>
<?php
    if($sentMessage)
    {
        echo 'Sent message to seller.';
    }
    else 
    {
        echo 'Could not send message to seller.';
    }
?>
</body>
</html>
    

