<?php

namespace SpotOnLive\AccuRanker\Resources\Contracts;

use SpotOnLive\AccuRanker\Models\Domain;

interface DomainInterface
{
    /**
     * @return array
     */
    public function listDomains();

    /**
     * @param $name
     * @param $groupId
     * @param $searchLocal
     * @param $includeSubdomains
     * @param $displayName
     * @param array $optional
     * @return Domain
     */
    public function createDomain($name, $groupId, $searchLocal, $includeSubdomains, $displayName, $optional = []);

    /**
     * @param array $response
     * @return Domain
     */
    public function convertResponseToDomain(array $response);
}
