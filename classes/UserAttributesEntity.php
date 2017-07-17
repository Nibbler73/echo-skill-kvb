<?php

/**
 * 
 */
class UserAttributesEntity
{
    private $userId                 = "amzn1.ask.account.AHKTH3ERBVTFPZAI7J4PKEG2L2GTROYNSBBUIVSXLJO5ENDUUC3UNEOI63BQNGBVX44V6EJ2YZPDHQM23J4YAQFXJUWON3SFTANGYCBXVHZZTWV2XBOUPKLUGH6PCLYNTBRQMT7OE2AXUQ7U7SSHXM2HGS7ELELUYHO7AE7SZ3YXWH4SFWCRJA5ULNHPUDC7PYWWXFUU7VI6KPQ";

    // http://www.kvb-koeln.de/german/hst/overview/178/
    private $defaultStationId       = 178;

    private $defaultStationName     = "Aachener Str./Gürtel, Köln-Braunsfeld";

    private $preferredLines         = array(1, 7);


    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getDefaultStationName()
    {
        return $this->defaultStationName;
    }

    /**
     * @param string $defaultStationName
     */
    public function setDefaultStationName($defaultStationName)
    {
        $this->defaultStationName = $defaultStationName;
    }

    /**
     * @return int
     */
    public function getDefaultStationId()
    {
        return $this->defaultStationId;
    }

    /**
     * @param int $defaultStationId
     */
    public function setDefaultStationId($defaultStationId)
    {
        $this->defaultStationId = $defaultStationId;
    }

    /**
     * @return array
     */
    public function getPreferredLines()
    {
        return $this->preferredLines;
    }

    /**
     * @param array $preferredLines
     */
    public function setPreferredLines($preferredLines)
    {
        $this->preferredLines = $preferredLines;
    }
}