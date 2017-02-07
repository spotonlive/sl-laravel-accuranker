<?php

namespace SpotOnLive\AccuRanker\Models;

class Keyword
{
    /** @var integer */
    protected $id;

    /** @var integer */
    protected $domain;

    /** @var string */
    protected $keyword;

    /** @var string */
    protected $location;

    /** @var integer */
    protected $searchEngine;

    /** @var boolean */
    protected $ignoreLocalResults;

    /** @var \DateTime */
    protected $createdAt;

    /** @var integer */
    protected $searchLocale;

    /** @var boolean */
    protected $starred;

    /** @var array */
    protected $tags = [];

    /** @var integer */
    protected $searchVolume;

    /** @var Rank */
    protected $rank;

    /** @var Rank[]|array */
    protected $history;

    public function __construct()
    {
        $this->history = [];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param int $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getSearchEngine()
    {
        return $this->searchEngine;
    }

    /**
     * @param int $searchEngine
     */
    public function setSearchEngine($searchEngine)
    {
        $this->searchEngine = $searchEngine;
    }

    /**
     * @return boolean
     */
    public function isIgnoreLocalResults()
    {
        return $this->ignoreLocalResults;
    }

    /**
     * @param boolean $ignoreLocalResults
     */
    public function setIgnoreLocalResults($ignoreLocalResults)
    {
        $this->ignoreLocalResults = $ignoreLocalResults;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getSearchLocale()
    {
        return $this->searchLocale;
    }

    /**
     * @param int $searchLocale
     */
    public function setSearchLocale($searchLocale)
    {
        $this->searchLocale = $searchLocale;
    }

    /**
     * @return boolean
     */
    public function isStarred()
    {
        return $this->starred;
    }

    /**
     * @param boolean $starred
     */
    public function setStarred($starred)
    {
        $this->starred = $starred;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return int
     */
    public function getSearchVolume()
    {
        return $this->searchVolume;
    }

    /**
     * @param int $searchVolume
     */
    public function setSearchVolume($searchVolume)
    {
        $this->searchVolume = $searchVolume;
    }

    /**
     * @return Rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param Rank $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return array|Rank[]
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param array|Rank[] $history
     */
    public function setHistory($history)
    {
        $this->history = $history;
    }

    /**
     * Add rank
     *
     * @param Rank $rank
     */
    public function addHistory(Rank $rank)
    {
        $this->history[] = $rank;
    }
}
