<?php

$container->set('Ethie', function () use ($settings){
    return new Kittiefight\Ethie($settings['ethereum']);
});
$container->set('MetadataGenerator', function () use ($container, $settings){
    $ethie = $container->get('Ethie');
    return new Kittiefight\MetadataGenerator($ethie, $settings['generator']);
});