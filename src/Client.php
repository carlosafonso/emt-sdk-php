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
     * The base API endpoint.
     *
     * @var string
     */
    const ENDPOINT = 'https://openbus.emtmadrid.es:9443';

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

    /**
     * Set the RequestLauncher instance to be used by this client.
     *
     * @param \Afonso\Emt\RequestLauncher $launcher
     */
    public function setRequestLauncher(RequestLauncher $launcher)
    {
        $this->launcher = $launcher;
    }
}
