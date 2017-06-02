<?php

namespace SpotOnLive\AccuRanker\Resources;

use JamesHalsall\Hydrator\ObjectConstructorFromArrayHydrator;
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
        return $this->accuRanker->get('domains/');
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

        $response = $this->accuRanker->post('domains/', $body);

        if (isset($response['non_field_errors'])) {
            throw new DomainNotUniqueException(implode(",", $response['non_field_errors']));
        }

        return $this->convertResponseToDomain($response);
    }

    /**
     * @param array $response
     * @return \SpotOnLive\AccuRanker\Models\Domain
     */
    private function convertResponseToDomain(array $response)
    {
        $hydrator = new ObjectConstructorFromArrayHydrator();
        $response['group_id'] = $response['group'];

        return $hydrator->hydrate(DomainModel::class, $response);
    }
}
