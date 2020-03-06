<?php

namespace Cryptopro;

class Configuration {

    private $keysDirectory;
    private $cryptoProDirectory;
    private $user;

    const DEFAULT_CRYPTOPRO_KEYS_DIRECTORY = '/var/opt/cprocsp/keys';
    const DEFAULT_CRYPTOPRO_DIRECTORY = '';
    const DEFAULT_CRYPTOPRO_USER = 'www-data';

    public function __construct($keysDirectory, $user, $cryptoProDirectory)
    {
        $this->setKeysDirectory($keysDirectory);
        $this->setUser($user);
        $this->setDirectory($cryptoProDirectory);
    }

    /**
     * @return mixed
     */
    public function getDirectory()
    {
        $trimmedDir = rtrim($this->cryptoProDirectory, '/');
        return $trimmedDir;
    }

    public function getCommandString($command)
    {
        $dir = $this->getDirectory();
        if (empty($dir)) {
            return $command;
        }

        $command = "{$dir}/{$command}";

        return $command;
    }

    /**
     * @param mixed $directory
     */
    public function setDirectory($directory): void
    {
        $this->cryptoProDirectory = $directory;
    }


    /**
     * @return Configuration
     * @author Zulfigarov Nuran <nuran@zulfigarov.tech>
     * Date: 2020-01-20
     */
    public static function makeDefaultConfiguration() {
        $configuration = new self(
            self::DEFAULT_CRYPTOPRO_KEYS_DIRECTORY,
            self::DEFAULT_CRYPTOPRO_USER,
            self::DEFAULT_CRYPTOPRO_DIRECTORY
        );

        return $configuration;
    }

    /**
     * @return string
     */
    public function getKeysDirectory()
    {
        return $this->keysDirectory;
    }

    /**
     * @param string $keysDirectory
     */
    public function setKeysDirectory($keysDirectory)
    {
        $this->keysDirectory = $keysDirectory;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    

}