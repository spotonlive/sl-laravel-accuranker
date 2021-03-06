<?php

namespace SpotOnLive\AccuRanker\Models;

use DateTime;

class Rank
{
    /** @var DateTime */
    protected $searchDate;

    /** @var integer */
    protected $rank;

    /** @var string */
    protected $url;

    /** @var  integer */
    protected $estTraffic;

    /** @var string */
    protected $extraRanks;

    /**
     * @return DateTime
     */
    public function getSearchDate()
    {
        return $this->searchDate;
    }

    /**
     * @param DateTime $searchDate
     */
    public function setSearchDate($searchDate)
    {
        $this->searchDate = $searchDate;
    }

    /**
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getEstTraffic()
    {
        return $this->estTraffic;
    }

    /**
     * @param int $estTraffic
     */
    public function setEstTraffic($estTraffic)
    {
        $this->estTraffic = $estTraffic;
    }

    /**
     * @return string
     */
    public function getExtraRanks()
    {
        return $this->extraRanks;
    }

    /**
     * @param string $extraRanks
     */
    public function setExtraRanks($extraRanks)
    {
        $this->extraRanks = $extraRanks;
    }
}
