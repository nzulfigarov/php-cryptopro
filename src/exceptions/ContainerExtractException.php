<?php

namespace Cryptopro\Exception;

/**
 * @author Zulfigarov Nuran <zulfigarov@z-v.tech>
 * Date: 2020-01-18
 * Class ContainerExtractException
 * @package Cryptopro\Exception
 */
class ContainerExtractException extends \Exception implements ExceptionWithUuid
{

    public const UUID = '40f7382e-5ecc-486e-84dd-418bff10d0de';

    /**
     * @var string Невохможно разархивировать контейнер
     */
    protected $message = 'Unable to unzip the container.';

    protected $uuid = self::UUID;

    public function getUuid()
    {
        return $this->uuid;
    }
}
