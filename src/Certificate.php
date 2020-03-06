<?php

namespace Cryptopro;


use mikehaertl\shellcommand\Command;

class Certificate
{

    private $issuer; //object
    /**
     * @var Subject $subject
     */
    private $subject; //object
    private $serial; //string
    private $thumbprint; //string
    private $notValidBefore;
    private $notValidAfter;
    /**
     * @var Container $container
     */
    private $container;
    private $OCSPUrl;
    private $providerName;
    private $providerInfo;
    private $CACertUrl;
    private $privateKeyLink;
    private $password;

    /**
     * @return mixed
     */
    public function getThumbprint()
    {
        return $this->thumbprint;
    }

    /**
     * @param mixed $thumbprint
     */
    public function setThumbprint($thumbprint): void
    {
        $this->thumbprint = $thumbprint;
    }

    /**
     * @return Subject
     */
    public function getSubject(): Subject
    {
        return $this->subject;
    }

    /**
     * @param Subject $subject
     */
    public function setSubject(Subject $subject): void
    {
        $this->subject = $subject;
    }



    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }



    public static function convertPlainCertificateTextToObject($plainCertificateText, $container)
    {
        $certificate = new self();
        $certificate->container = $container;
        $certificateData = explode("\n", $plainCertificateText);
        foreach ($certificateData as $certificateDatum) {
            $res = preg_match('/^\s{0,}([\sa-zA-Z\d]+?)\s?[:](.*?)$/msui', $certificateDatum, $matches);
            if ($res) {
                $key = trim($matches[1] ?? '');
                $value = trim($matches[2] ?? '');

                if ($key == 'Subject') {
                    $value = Subject::createSubjectFromRaw($value);
                    $certificate->setSubject($value);
                }

                if ($key == 'SHA1 Hash') {
                    //$value = Subject::createSubjectFromRaw($value);
                    $certificate->setThumbprint($value);
                }
            }
        }


        return $certificate;
    }

    public function signDetached($pathToFile, $outputPath)
    {
        $pin = $this->container->getPassword();
        $thumbprint = $this->getThumbprint();
        $commandString = "cryptcp -signf ${pathToFile} -cert -pin {$pin} -detached  -thumbprint {$thumbprint}";

        $command = $this->container
            ->getConfig()
            ->getCommandString($commandString);

        $command = new Command("cd {$outputPath} && {$command} ");
        $res = $command->execute();

        return $res;
    }
}