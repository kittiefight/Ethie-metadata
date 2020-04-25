<?php
namespace Kittiefight;

class MetadataGenerator {
    protected $ethie;
    private $settings;
    public function __construct(Ethie $ethie, $settings){
        $this->ethie = $ethie;
        $this->settings = $settings;
    }

    function getMetadata(int $tokenId){
        $name = $this->ethie->name($tokenId);
        $properties = $this->ethie->properties($tokenId);
        $ethAmountStr = ($properties['ethAmount'] > 0.00005)?round($properties['ethAmount']-0.00005, 4):0; //round down with 4 decimal digits
        $unlockTime = $properties['creationTime']+$properties['lockPeriod'];
        $description = strtr($this->settings['tokenDescription'],[
            '{generation}' => $properties['generation'],
            '{ethAmount}'  => $properties['ethAmount'],
            '{unlockTime}' => date('d M Y, H:i', $unlockTime)            
        ]);
        return [
            'name' => $name,
            'description' => $description,
            'image' => $this->settings['imageBase'].$this->generateImageName($properties['ethAmount']),
            'attributes' => [
                ["trait_type" => "Value", "display_type" =>"number", "value" => $ethAmountStr],
                ["trait_type" => "Generation", "value" => $properties['generation']],
                ["trait_type" => "Created", "display_type" => "date", "value" => $properties['creationTime']],
                ["trait_type" => "Special benefits unlock", "display_type" => "date", "value" => $unlockTime],
            ]
        ];
    }

    function getContractLevelMetadata() {
        return [
            "name" => "Kittiefight Ethie",
            "description" => $this->settings['contractDescription'],
            "image" => $this->settings['imageBase'].'ethie.jpg',
            "external_link" => "https://www.kittiefight.io/"
        ];
    }

    function generateImageName($ethAmount) {
        $tear = floor(log10($ethAmount));
        $sign = ($tear >= 0)?'p':'m';
        $level = abs($tear);
        if($level > 5) $level = 5;
        return "t${sign}${level}.png";
    }

    // private static function seconds2text($ss) {
    //     $s = $ss%60;
    //     $m = floor(($ss%3600)/60);
    //     $h = floor(($ss%86400)/3600);
    //     $d = floor(($ss%2592000)/86400);
    //     $M = floor($ss/2592000);
    //     $text = "$s seconds";
    //     if($m > 0) $text = "$m minutes, ".$text;
    //     if($h > 0) $text = "$h hours, ".$text;
    //     if($d > 0) $text = "$d days, ".$text;
    //     if($M > 0) $text = "$M months, ".$text;
    //     return $text;
    // }
}

