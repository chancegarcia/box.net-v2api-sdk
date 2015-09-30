<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/30/15
 * Time: 10:05 AM
 */

namespace Box\Connection;

use Box\Exception\BoxException;
use Box\Factory\AbstractFactory;
use Box\Model\Connection\ConnectionInterface;
use Box\Model\Connection\Token\TokenInterface;

class ConnectionFactory extends AbstractFactory
{
    /**
     * @param null $options
     *
     * @return ConnectionInterface
     */
    static public function getConnection($options = null)
    {
        return parent::get('Box\Model\Connection\Connection', $options);
    }

    /**
     * @param null|array $options
     *                   required key/values:
     *                   'token' => TokenInterface
     *
     *                   optional key/values:
     *                   'additionalHeaders' => array
     *
     * @return ConnectionInterface
     * @throws \Box\Exception\BoxException
     */
    static public function getAuthorizedConnection($options = null)
    {
        if (!array_key_exists('token', $options))
        {
            throw new BoxException('token expected to create an authorized connection');
        }

        if (!$options['token'] instanceof TokenInterface)
        {
            throw new BoxException('instance of Box\Model\Connection\Token\TokenInterface expected');
        }

        /**
         * @var TokenInterface $token
         */
        $token = $options['token'];

        unset($options['token']);
        if (!is_string($token->getAccessToken()))
        {
            throw new BoxException('TokenInterface::getAccessToken() does not contain a string access token');
        }

        $additionalHeaders = null;
        if (array_key_exists('additionalHeaders', $options))
        {
            $additionalHeaders = $options['additionalHeaders'];
            unset($options['additionalHeaders']);
            if (!is_array($additionalHeaders))
            {
                throw new BoxException('additionalHeaders option must be an array');
            }
        }

        $headers = array("Authorization: Bearer " . $token->getAccessToken());

        if (is_array($additionalHeaders))
        {
            $headers = array_merge($headers, $additionalHeaders);
        }

        $connection = static::getConnection($options);
        $connection->setCurlOpts(array('CURLOPT_HTTPHEADER' => $headers));

        return $connection;
    }
}