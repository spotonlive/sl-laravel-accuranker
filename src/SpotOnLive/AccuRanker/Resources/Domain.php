<?php

namespace SpotOnLive\AccuRanker\Resources;

use SpotOnLive\AccuRanker\Exceptions\DomainNotUniqueException;
use SpotOnLive\AccuRanker\Models\Domain as DomainModel;

class Domain extends AbstractResource
{

    /**
     * List all of the domains
     * @return array
     */
    public function listDomains()
    {
        $results = $this->Accuranker->get('domains/');

        return $results;
    }


    /**
     * @param $name
     * @param $groupId
     * @param $searchLocal
     * @param $includeSubdomains
     * @param $displayName
     * @param array $optional
     * @return DomainModel
     * @throws DomainNotUniqueException
     */
    public function createDomain($name, $groupId, $searchLocal, $includeSubdomains, $displayName, $optional = [])
    {
        $body = array_merge([
            'name' => $name,
            'group' => (int) $groupId,
            'include_subdomains' => (boolean) $includeSubdomains,
            'default_search_locale' => $searchLocal,
            'display_name' => $displayName
        ], $optional);

        $response = $this->Accuranker->post('domains/', $body);

        if (isset($response['non_field_errors'])) {
            throw new DomainNotUniqueException($response['non_field_errors'][0]);
        }
        return $this->convertResponseToDomain($response);
    }

    private function convertResponseToDomain(array $response)
    {
        $domain = new DomainModel();
        $domain->setGroupId($response['group']);
        $domain->setDateOfFirstRank($response['date_of_first_rank']);
        $domain->setDefaultSearchLocale($response['default_search_locale']);
        $domain->setDisplayName($response['display_name']);
        $domain->setIncludeSubdomains($response['include_subdomains']);
        $domain->setName($response['name']);
        $domain->setTags($response['tags']);
        $domain->setCompetitors($response['competitors']);
        $domain->setScreenshotUrl($response['screenshot_url']);
        $domain->setCreatedAt($response['created_at']);
        $domain->setFaviconUrl($response['favicon_url']);
        $domain->setPaused($response['paused']);
        $domain->setPublicReportUrl($response['public_report_url']);
        $domain->setSlug($response['slug']);

        return $domain;
    }
}
