<?php

namespace Afonso\Emt;

/**
 * The base SDK client for the EMT OpenData API.
 *
 * @author Carlos Afonso Pérez <carlos.afonso.perez@gmail.com>
 */
abstract class Client
{
    /**
     * The request launcher instance.
     *
     * @var \Afonso\Emt\RequestLauncher
     */
    protected $launcher;

    /**
     * Create a new Client instance with the given client ID and passkey.
     *
     * @param string $clientId
     * @param string $passkey
     */
    public function __construct($clientId, $passkey)
    {
        $this->launcher = new RequestLauncher($clientId, $passkey);
    }
}
