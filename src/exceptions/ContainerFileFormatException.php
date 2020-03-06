<?php
namespace Cryptopro\Exception;



/**
 * @author Zulfigarov Nuran <zulfigarov@z-v.tech>
 * Date: 2020-01-18
 * Class ContainerFileFormatIsNotAcceptable
 * @package Cryptopro\Exception
 */
class ContainerFileFormatException extends \Exception implements ExceptionWithUuid
{

    public const UUID = '12896a14-783a-4eb9-b4de-e579f4ca84c8';

    /**
     * @var string Файл контейнера подписи имеет не верный формат. Допустимый формат .zip, .tar.gz, .tgz, .tar.gzip а так же другие форматы поддерживаемые утилитой tar.
     */
    protected $message = 'The signature container file is not in the correct format. The allowed formats are .zip,  .tar.gz, .tgz, .tar.gzip, .tar.bz2, .tar.bzip2, .tbz2, .tb2, .tbz.';

    protected $uuid = self::UUID;

    public function getUuid()
    {
        return $this->uuid;
    }
}