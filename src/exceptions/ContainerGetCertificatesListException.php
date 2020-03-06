<?php

namespace Cryptopro\Exception;

/**
 * @author Zulfigarov Nuran <zulfigarov@z-v.tech>
 * Date: 2020-01-18
 * Class ContainerExtractException
 * @package Cryptopro\Exception
 */
class ContainerGetCertificatesListException extends \Exception implements ExceptionWithUuid
{

    public const UUID = 'f35e01b2-edbd-401b-9580-25a7321ed397';

    /**
     * @var string Невохможно разархивировать контейнер
     */
    protected $message = 'Unable to get containers list';

    protected $uuid = self::UUID;

    public function getUuid()
    {
        return $this->uuid;
    }
}
