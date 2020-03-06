<?php
namespace Cryptopro\Exception;

/**
 * @author Zulfigarov Nuran <nuran@zulfigarov.tech>
 * Date: 2020-01-19
 * Interface ExceptionWithUuid
 * @package Cryptopro\Exception
 * @method getMessage() \Exception $exception->getMessage()
 */
interface ExceptionWithUuid
{
    public function getUuid();
}