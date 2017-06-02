<?php

namespace SpotOnLive\AccuRanker\Models;

use DateTime;

class Domain
{
    /** @var integer */
    protected $id;

    /** @var  integer */
    protected $groupId;

    /** @var   string*/
    protected $name;

    /** @var  string */
    protected $display_name;

    /** @var   boolean */
    protected $includeSubdomains;

    /** @var   integer */
    protected $defaultSearchLocale;

    /** @var  DateTime */
    protected $createdAt;

    /** @var  int */
    protected $type;

    /** @var  string */
    protected $publicReportUrl;

    /** @var  string */
    protected $slug;

    /** @var  boolean */
    protected $paused;

    /** @var  array */
    protected $competitors;

    /** @var  string */
    protected $faviconUrl;

    /** @var  string */
    protected $screenshotUrl;

    /** @var  array */
    protected $tags;

    /** @var   DateTime|null */
    protected $dateOfFirstRank;

    /**
     * Domain constructor.
     * @param int $id
     * @param int $groupId
     * @param string $name
     * @param string $display_name
     * @param bool $includeSubdomains
     * @param int $defaultSearchLocale
     * @param DateTime|string $createdAt
     * @param int $type
     * @param string $publicReportUrl
     * @param string $slug
     * @param bool $paused
     * @param array $competitors
     * @param string $faviconUrl
     * @param string $screenshotUrl
     * @param array $tags
     * @param DateTime $dateOfFirstRank
     */
    public function __construct(
        $id,
        $groupId,
        $name,
        $display_name,
        $includeSubdomains,
        $defaultSearchLocale,
        $createdAt,
        $type,
        $publicReportUrl,
        $slug,
        $paused,
        array $competitors,
        $faviconUrl,
        $screenshotUrl,
        array $tags,
        DateTime $dateOfFirstRank = null
    ) {
        $this->id = $id;
        $this->groupId = $groupId;
        $this->name = $name;
        $this->display_name = $display_name;
        $this->includeSubdomains = $includeSubdomains;
        $this->defaultSearchLocale = $defaultSearchLocale;
        $this->dateOfFirstRank = $dateOfFirstRank;
        $this->createdAt = ($createdAt instanceof DateTime) ? $createdAt : new DateTime($createdAt);
        $this->type = $type;
        $this->publicReportUrl = $publicReportUrl;
        $this->slug = $slug;
        $this->paused = $paused;
        $this->competitors = $competitors;
        $this->faviconUrl = $faviconUrl;
        $this->screenshotUrl = $screenshotUrl;
        $this->tags = $tags;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    /**
     * @param string $display_name
     */
    public function setDisplayName(string $display_name)
    {
        $this->display_name = $display_name;
    }

    /**
     * @return bool
     */
    public function isIncludeSubdomains(): bool
    {
        return $this->includeSubdomains;
    }

    /**
     * @param bool $includeSubdomains
     */
    public function setIncludeSubdomains(bool $includeSubdomains)
    {
        $this->includeSubdomains = $includeSubdomains;
    }

    /**
     * @return int
     */
    public function getDefaultSearchLocale(): int
    {
        return $this->defaultSearchLocale;
    }

    /**
     * @param int $defaultSearchLocale
     */
    public function setDefaultSearchLocale(int $defaultSearchLocale)
    {
        $this->defaultSearchLocale = $defaultSearchLocale;
    }

    /**
     * @return DateTime|null
     */
    public function getDateOfFirstRank()
    {
        return $this->dateOfFirstRank;
    }

    /**
     * @param DateTime|null $dateOfFirstRank
     */
    public function setDateOfFirstRank(DateTime $dateOfFirstRank = null)
    {
        $this->dateOfFirstRank = $dateOfFirstRank;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getScreenshotUrl(): string
    {
        return $this->screenshotUrl;
    }

    /**
     * @param string $screenshotUrl
     */
    public function setScreenshotUrl(string $screenshotUrl)
    {
        $this->screenshotUrl = $screenshotUrl;
    }

    /**
     * @return string
     */
    public function getFaviconUrl(): string
    {
        return $this->faviconUrl;
    }

    /**
     * @param string $faviconUrl
     */
    public function setFaviconUrl(string $faviconUrl)
    {
        $this->faviconUrl = $faviconUrl;
    }

    /**
     * @return array
     */
    public function getCompetitors(): array
    {
        return $this->competitors;
    }

    /**
     * @param array $competitors
     */
    public function setCompetitors(array $competitors)
    {
        $this->competitors = $competitors;
    }

    /**
     * @return bool
     */
    public function isPaused(): bool
    {
        return $this->paused;
    }

    /**
     * @param bool $paused
     */
    public function setPaused(bool $paused)
    {
        $this->paused = $paused;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getPublicReportUrl(): string
    {
        return $this->publicReportUrl;
    }

    /**
     * @param string $publicReportUrl
     */
    public function setPublicReportUrl(string $publicReportUrl)
    {
        $this->publicReportUrl = $publicReportUrl;
    }
}
