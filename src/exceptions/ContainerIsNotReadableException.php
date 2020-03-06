<?php
namespace Cryptopro\Exception;

/**
 * @author Zulfigarov Nuran <zulfigarov@z-v.tech>
 * Date: 2020-01-18
 * Class ContainerIsNotReadable
 * @package Cryptopro\Exception
 */
class ContainerIsNotReadableException extends \Exception implements ExceptionWithUuid
{
    public const UUID = '142facc7-83e3-485a-ae44-1b3193b05e28';

    /**
     * @var string Файл контейнера подписи не читается, проверьте существование файла и права доступа к нему
     */
    protected $message = 'The signature container file is unreadable, check the existence of the file and its access rights.';

    protected $uuid = self::UUID;

    public function getUuid()
    {
        return $this->uuid;
    }
}