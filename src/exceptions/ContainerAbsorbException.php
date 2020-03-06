<?php
namespace Cryptopro\Exception;

/**
 * @author Zulfigarov Nuran <zulfigarov@z-v.tech>
 * Date: 2020-01-18
 * Class ContainerAbsorbException
 * @package Cryptopro\Exception
 */
class ContainerAbsorbException extends \Exception implements ExceptionWithUuid
{
    public const UUID = 'bb55e357-49e8-4bf4-80ba-d1f600febcbd';
    /**
     * @var string Невохможно получить сертификат из контейнера
     */
    protected $message = 'Unable to absorb certificates from container.';

    protected $uuid = self::UUID;

    public function getUuid()
    {
        return $this->uuid;
    }
}



