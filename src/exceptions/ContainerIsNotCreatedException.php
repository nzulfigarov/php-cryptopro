<?php
namespace Cryptopro\Exception;

/**
 * @author Zulfigarov Nuran <zulfigarov@z-v.tech>
 * Date: 2020-01-18
 * Class ContainerAbsorbException
 * @package Cryptopro\Exception
 */
class ContainerIsNotCreatedException extends \Exception implements ExceptionWithUuid
{
    public const UUID = 'f1581585-c592-4f7a-ae92-be1866fff172';


    /**
     * @var string Контейнер не был создан
     */
    protected $message = 'Container is not created.';

    protected $uuid = self::UUID;

    public function getUuid()
    {
        return $this->uuid;
    }
}



