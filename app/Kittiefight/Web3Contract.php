<?php
namespace Kittiefight;

use \Web3\Web3;
use \Web3\Contract;
use \Web3\Utils;
use \phpseclib\Math\BigInteger;


class Web3Contract {
    protected $web3;
    protected $contract;

    public function __construct(string $apiUrl, string $contractName, string $contractAddress=null){
        $this->web3 = new Web3($apiUrl);
        $abi = self::loadABI($contractName);
        $this->contract = new Contract($this->web3->getProvider(), $abi);
        if(!$contractAddress == null) {
            $this->contract = $this->contract->at($contractAddress);
        }
    }

    private static function loadABI(string $contract) {
        if(preg_match("/^[a-z0-9_-]+$/i", $contract) !== 1){
            throw new Exception("Error loading ABI: ".htmlspecialchars($contract));
        }
        $file = __DIR__ . "/abi/{$contract}.json";
        if(!file_exists($file)){
            throw new Exception("Error loading ABI (no file): ".htmlspecialchars($contract));   
        }
        $json = json_decode(file_get_contents($file));
        return $json;
    }

    public static function fromWei(BigInteger $value){
        list($quotient, $residue) = Utils::fromWei($value,'ether');
        $residiqueStr = str_pad($residue->toString(), 18, '0', STR_PAD_LEFT);
        return floatval($quotient->toString().'.'.$residiqueStr);
    }

}

