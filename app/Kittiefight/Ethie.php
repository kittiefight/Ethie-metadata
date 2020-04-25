<?php
namespace Kittiefight;

use \Web3\Web3;
use \Web3\Contract;
use \Web3\Utils;

class Ethie extends Web3Contract {

    public function __construct(array $settings){
        parent::__construct(
            $settings['api'], 
            'EthieToken', 
            $settings['ethie']
        );
    }

    public function name(int $tokenId) {
        @$this->contract->call(
            'name', 
            $tokenId, 
            function($err, $responce) use($tokenId, &$result){
                if($responce[0] == ''){
                    throw new KittiefightException("Ethie id {$tokenId} not found", KittiefightException::ERR_NOT_FOUND);
                }
                $result = $responce[0];
            }
        );
        return $result;
    }

    public function properties(int $tokenId) {
        @$this->contract->call(
            'properties', 
            $tokenId, 
            function($err, $responce) use($tokenId, &$result){
                $result = [
                    'ethAmount' => self::fromWei($responce['ethAmount']),
                    'generation' => intval(Utils::toString($responce['generation'])),
                    'creationTime' => intval(Utils::toString($responce['creationTime'])),
                    'lockPeriod' => intval(Utils::toString($responce['lockPeriod']))
                ];
            }
        );
        return $result;
    }

}

