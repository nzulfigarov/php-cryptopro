<?php

namespace Cryptopro;

use Cryptopro\Exception\ContainerAbsorbException;
use Cryptopro\Exception\ContainerExtractException;
use Cryptopro\Exception\ContainerFileFormatException;
use Cryptopro\Exception\ContainerGetCertificatesListException;
use Cryptopro\Exception\ContainerIsNotCreatedException;
use mikehaertl\shellcommand\Command;

class Container {
    use ErrorTrait;

    private $currentPathToContainer;
    private $password = '';
    private $config = null;
    private $containerName = null;

    /**
     * Container constructor.
     * @param $currentPathToContainer
     * @param Configuration|null $config
     */
    public function __construct($currentPathToContainer, Configuration $config)
    {
        $pathIsSet = $this->setCurrentPathToContainer($currentPathToContainer);

        if (!$pathIsSet) {
            return;
        }

        $this->setConfig($config);
    }

    public function getCertificateList()
    {

        $containerName = $this->getContainerName();
        if (is_null($containerName)) {
            $this->addError(new ContainerIsNotCreatedException());
            return false;
        }

        $commandString = $this->getConfig()->getCommandString('certmgr -list');

        $command = new Command($commandString);
        $res = $command->execute();

        if (!$res) {
            $this->addError(new ContainerGetCertificatesListException());
            return false;
        }

        $output = $command->getOutput();

        $pattern = '/[=]{1,}\n\d{1,}[-]{1,}(.*?Container.*?HDIMAGE.*?' . $this->getContainerName() . '.*?)[=]{1,}/msui';

        $pregMatchResult = preg_match_all($pattern, $output, $certificates);


        if (!$pregMatchResult || !key_exists( 1, $certificates)) {
            $this->addError(new ContainerGetCertificatesListException());
            return false;
        }

        $certificatesWithoutSymbols = $certificates[1];

        $certificates = [];

        foreach ($certificatesWithoutSymbols as $plainCertificate) {
            $certificate = Certificate::convertPlainCertificateTextToObject($plainCertificate, $this);
            $certificates[] = $certificate;
        }

        return $certificates;
    }

    public function absorbCertificatesFromContainer() {
        $containerName = $this->getContainerName();
        if (is_null($containerName)) {
            $this->addError(new ContainerIsNotCreatedException());
            return false;
        }

        $commandString = $this->getConfig()->getCommandString('csptestf -absorb -certs');
        $command = new Command($commandString);
        $result = $command->execute();

        $output = $command->getOutput();
        $pattern = '/Match.*?HDIMAGE.*?' . $containerName .'/msui';


        if (!preg_match($pattern, $output)) {
            $this->addError(new ContainerAbsorbException());
            return false;
        }

        if (!$result) {
            $this->addError(new ContainerAbsorbException());
            return false;
        }

        return true;
    }

    private function setCurrentPathToContainer($currentPathToContainer) {
        $errors = [];

        $fileIsReadable = is_readable($currentPathToContainer);
        if (!$fileIsReadable) {
            $errors[] = new Exception\ContainerIsNotReadableException();
        }

        $acceptableFilesPattern = '/\.(zip|tar|gz|tgz|tar\.gzip|tar\.bz2|tar\.bzip2|tbz2|tb2|tbz)$/msui';

        if (!preg_match($acceptableFilesPattern, $currentPathToContainer)) {
            $errors[] = new ContainerFileFormatException();
        }

        if (!empty($errors)) {
            $this->addErrorBatch($errors);

            return false;
        }

        $this->currentPathToContainer = $currentPathToContainer;

        return true;
    }

    private function getCurrentPathToContainer() {
        return $this->currentPathToContainer;
    }


    public function unPackContainer() {
        $keysDirectory = $this->getConfig()->getKeysDirectory();
        $user = $this->getConfig()->getUser();

        $pathToExtract = "{$keysDirectory}/{$user}";


        $currentPath = $this->getCurrentPathToContainer();
        $newDirname = Helper::createRandomDirectoryIfNotExists($pathToExtract);
        $this->setContainerName($newDirname);


        if ($this->isZip($currentPath)) {
            $command = new Command("unzip -j {$currentPath} -d {$pathToExtract}/{$newDirname}");
        } else {
            $command = new Command("tar -xvf {$currentPath} --strip-components 1 --directory {$pathToExtract}/{$newDirname}");
        }

        $result = $command->execute();

        if (!$result) {
            $this->removeContainer();
            $this->addError(new ContainerExtractException());
        }

        return $result;
    }

    /**
     * @return null
     */
    public function getContainerName()
    {
        return $this->containerName;
    }

    public function removeContainer() {
        $containerName = $this->getContainerName();
        if (is_null($containerName)) {
            $this->addError(new ContainerIsNotCreatedException());
            return false;
        }

        $keysDirectory = $this->getConfig()->getKeysDirectory();
        $user = $this->getConfig()->getUser();
        $containerName = $this->getContainerName();

        $containerPath = "{$keysDirectory}/{$user}/{$containerName}";


        $command = new Command("rm -rf {$containerPath}");
        $res = $command->execute();

        if ($res) {
            $this->setContainerName(null);
        }

        return $res;
    }

    /**
     * @param null $containerName
     */
    public function setContainerName($containerName): void
    {
        $this->containerName = $containerName;
    }



    public function isZip($currentPathToContainer) {
        $acceptableFilesPattern = '/([.]zip)$/msui';
        if (!preg_match($acceptableFilesPattern, $currentPathToContainer)) {
            return false;
        }

        return true;
    }



    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;

    }

    /**
     * @return Configuration|null
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param null $config
     * @return self
     */
    public function setConfig($config): self
    {
        $this->config = $config;

        return $this;
    }



}