<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace SpotOnLive\AccuRanker;

use SpotOnLive\AccuRanker\Exceptions\InvalidAPICallException;
use SpotOnLive\AccuRanker\Exceptions\InvalidCredentialsException;
use SpotOnLive\AccuRanker\Options\ApiOptions;
use SpotOnLive\AccuRanker\Resources\Domain;
use SpotOnLive\AccuRanker\Services\CurlServiceInterface;
use SpotOnLive\AccuRanker\Resources\Keywords;

class AccuRanker
{
    const ACCURANKER_API_VERSION = 'v3';
    const ACCURANKER_BASE_URL = 'https://app.accuranker.com/api/' . self::ACCURANKER_API_VERSION . '/';

    /** @var  CurlServiceInterface */
    private $curlService;

    /**
     * @param array $config
     * @param CurlServiceInterface $curlService
     */
    public function __construct(array $config, CurlServiceInterface $curlService)
    {
        $this->config = new ApiOptions($config);
        $this->curlService = $curlService;
    }

    /**
     * @return Keywords
     */
    public function keywords()
    {
        return new Keywords($this);
    }

    /**
     * @return Domain
     */
    public function domain()
    {
        return new Domain($this);
    }

    /**
     * Call the CURL get service
     *
     * @param string $url
     * @return array
     * @throws InvalidAPICallException
     * @throws InvalidCredentialsException
     */
    public function get($url)
    {
        $result = $this->curlService->get(
            $this->getUrl() . $url,
            $this->getToken()
        );

        return $this->parse($result);
    }

    /**
     * Call the CURL post service
     *
     * @param string $url
     * @param array $body
     * @return array
     * @throws InvalidAPICallException
     * @throws InvalidCredentialsException
     */
    public function post($url, $body)
    {
        $result = $this->curlService->post(
            $this->getUrl() . $url,
            $this->getToken(),
            $body
        );

        return $this->parse($result);
    }

    /**
     * Call the CURL delete service
     *
     * @param $url
     * @return array
     */
    public function delete($url)
    {
        $result = $this->curlService->delete(
            $this->getUrl() . $url,
            $this->getToken()
        );

        return $this->parse($result);
    }

    /**
     * Parse result
     *
     * @param $result
     * @return array
     * @throws InvalidAPICallException
     */
    public function parse($result)
    {
        $array = json_decode($result, true);

        if (isset($array['detail'])) {
            throw new InvalidAPICallException(
                sprintf(
                    'AccuRanker API error: %s',
                    $array['detail']
                )
            );
        }

        return $array;
    }

    /**
     * Get AccuRanker token
     *
     * @return string
     * @throws InvalidCredentialsException
     */
    protected function getToken()
    {
        /** @var string|null $token */
        $token = $this->getConfig()->get('api_key');

        if (is_null($token)) {
            throw new InvalidCredentialsException('Please insert your accuranker token in the config file');
        }

        return $token;
    }

    /**
     * Get API Url
     * @return string
     */
    public function getUrl()
    {
        return self::ACCURANKER_BASE_URL;
    }

    /**
     * @param ApiOptions $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return ApiOptions
     */
    public function getConfig()
    {
        return $this->config;
    }
}
