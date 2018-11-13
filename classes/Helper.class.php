<?php

class Helper {

    private $secretNr;
    public $publicNr;

    public function __construct($nr) {
        $this->secretNr = 4;
        $this->publicNr = $this->secretNr * $nr;
    }

    public function __destruct()
    {

    }

}

?>