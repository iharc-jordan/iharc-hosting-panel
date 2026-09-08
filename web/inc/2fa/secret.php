<?php

use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\QRServerProvider;

require_once __DIR__ . "/../vendor/autoload.php";
$issuer = !empty($argv[1]) ? $argv[1] : "Ceasar Control Panel";
$tfa = new TwoFactorAuth(new QRServerProvider(), $issuer);

$secret = $tfa->createSecret(160); // Though the default is an 80 bits secret (for backwards compatibility reasons) we recommend creating 160+ bits secrets (see RFC 4226 - Algorithm Requirements)
$qrcode = $tfa->getQRCodeImageAsDataUri(gethostname(), $secret);

echo $secret . "-" . $qrcode;
