<?php
return [
    'errorHandler' => [
        'displayErrorDetails' => true,  // Should be set to false in production
        'logErrors' => true,            // Parameter is passed to the default ErrorHandler
        'logErrorDetails' => true,      // Display error details in error log
    ],
    'logger' => [
        'file' => __DIR__.'/../logs/app.log',
        'level' => \Monolog\Logger::WARNING
    ],
    'ethereum' => [
        'api' => 'https://rinkeby.infura.io/v3/615f9abed6d04d3abf8f2c3a66159ac5', //URL of ethereum node API
        'ethie' => '0x7abdb73a2ffb87479471489cc38e73301790cf43'    // Address of Ethie token smart contract
    ],
    'generator' =>[
        'imageBase' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/images/",
        'tokenDescription' => 'This Kittiefight Ethie token is a NFT CDP of Generation {generation} and initial amount of {ethAmount} ETH, that accumulates weekly interests yield of 20% and beyond. Special benefits will be unlocked after {unlockTime} for use in reedeming more Ether and expensive Cryptokitties NFT in KittieHELL via lottery.',
        'contractDescription' => 'Kittiefight Ethie tokens are NFT CDP\'s that represent an amount of ETH locked up, that accumulates weekly interests yield of 20% and beyond. Special benefits are also available after certain dates for use in reedeming more Ether and expensive Cryptokitties NFT in KittieHELL via lottery.',
        'contractLink' => 'https://kittiefight.io'
    ]

];

