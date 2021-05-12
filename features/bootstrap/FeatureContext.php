<?php

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class FeatureContext implements Context
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * @var bool
     */
    private $force;

    /**
     * @var array
     */
    private $parameters = array();

    /**
     * @var array
     */
    private $files = array();

    /**
     * @var array
     */
    private $server = array();

    /**
     * @var Response
     */
    private $response;

    /**
     * FeatureContext constructor.
     * @param Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Set the request body to a string
     *
     * @param string $body The content to set as the request body
     * @return self
     *
     * @Given the request body is:
     */
    public function setRequestBody($body)
    {
        $this->content = $body;

        return $this;
    }

    /**
     * Request a path
     *
     * @param string $path   The path to request
     * @param string $method The HTTP method to use
     * @return void
     *
     * @When I request :path
     * @When I request :path using HTTP :method
     */
    public function requestPath($path, $method = null)
    {
        $this->setRequestPath($path);
        if (null === $method) {
            $this->setRequestMethod('GET', false);
        } else {
            $this->setRequestMethod($method);
        }

        $this->sendRequest();
    }

    /**
     * Update the path of the request
     *
     * @param string $path The path to request
     * @return self
     */
    private function setRequestPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Update the HTTP method of the request
     *
     * @param string  $method The HTTP method
     * @param boolean $force  Force the HTTP method. If set to false the method set CAN be
     *                        overridden (this occurs for instance when adding form parameters to the
     *                        request, and not specifying HTTP POST for the request)
     * @return self
     */
    private function setRequestMethod($method, $force = true)
    {
        $this->method = $method;
        $this->force = $force;

        return $this;
    }

    /**
     * @return void
     */
    private function sendRequest()
    {
        $this->client->request($this->method, $this->path, $this->parameters, $this->files, $this->server, $this->content);
        $this->response = $this->client->getResponse();
    }

    /**
     * Assert the HTTP response code
     *
     * @param string $code The HTTP response code
     * @return void
     *
     * @Then the response code is :code
     */
    public function assertResponseCodeIs($code)
    {
        $this->requireResponse();
        Assert::assertSame(
            $this->response->getStatusCode(),
            $this->validateResponseCode(intval($code))
        );
    }

    /**
     * @return void
     */
    private function requireResponse()
    {
        Assert::assertNotNull(
            $this->response,
            'The request has not been made yet, so no response object exists.'
        );
    }

    /**
     * @param int $code
     * @return int
     */
    private function validateResponseCode($code)
    {
        Assert::assertGreaterThanOrEqual(100, $code, 'Status code must be greater than or equal 100');
        Assert::assertLessThan(600, $code, 'Status code must be less than 600');

        return $code;
    }

    /**
     * @param string $expected The expected JSON content
     * @return void
     *
     * @Then the response content is equal to:
     */
    public function assertResponseContentIsEqual($expected)
    {
        Assert::assertEquals(
            $content = json_decode($this->response->getContent(), true),
            $expected = json_decode($expected, true),
            sprintf(
                'Response content different from expectation: received [%s] instead of [%s]',
                json_encode($content, JSON_PRETTY_PRINT),
                json_encode($expected, JSON_PRETTY_PRINT)
            )
        );
    }

    /**
     * @return void
     *
     * @Then the response content is empty
     */
    public function assertResponseContentIsEmpty()
    {
        Assert::assertEmpty(
            $this->response->getContent(),
            sprintf('Response content is not empty: [%s]', $this->response->getContent())
        );
    }
}
