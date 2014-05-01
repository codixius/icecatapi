<?php

namespace Wk\IcecatApi\Lib;

use Monolog\Logger;
use Wk\GuzzleCommandClient\Lib\GuzzleCommandClient;

/**
 * Class IcecatConnection
 */
class IcecatConnection extends GuzzleCommandClient
{

    protected $logger;

    /**
     * Constructor of the class
     */
    public function __construct()
    {
        $json = file_get_contents(__DIR__. "/../Resources/config/service.json");
        parent::__construct($json);
    }

    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }
}