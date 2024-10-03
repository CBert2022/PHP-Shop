<?php

function sendOrderConfirmation($to, $orderDetails)
{
    $subject = 'Bestellbestätigung';
    $message = 'Vielen Dank für Ihre Bestellung!' . "\r\n\r\n" . $orderDetails;
    $headers = 'From: shop.lifestyle100@gmail.com' . "\r\n" .
        'Reply-To: shop.lifestyle100@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        //  echo 'Bestellbestätigung wurde gesendet';
    } else {
        //  echo 'Bestellbestätigung konnte nicht gesendet werden';
    }
}
