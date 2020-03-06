<?php

namespace Cryptopro;

class Subject {
    private const EMAIL_TAG = 'E';
    private const OGRNIP_TAG = 'OGRNIP';
    private const INN_TAG = 'INN';
    private const SNILS_TAG = 'SNILS';
    private const CITY_TAG = 'L';
    private const REGION_TAG = 'S';
    private const COUNTRY_TAG = 'C';
    private const COMMON_NAME_TAG = 'CN';
    private const LAST_NAME_TAG = 'SN';
    private const FIRST_AND_MIDDLE_NAME_TAG = 'G';

    private $firstAndMiddleName;
    private $lastName;
    private $commonName;
    private $email;
    private $ogrnip;
    private $inn;
    private $snils;
    private $city;
    private $country;
    private $region;
    private $rawBody;

    /**
     * @return mixed
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * @param mixed $rawBody
     */
    public function setRawBody($rawBody): void
    {
        $this->rawBody = $rawBody;
    }



    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region): void
    {
        $this->region = $region;
    }


    public static function createSubjectFromRaw($rawSubjectText) : self
    {
        $subject = new self();
        $subject->setRawBody($rawSubjectText);
        $values = Helper::extractValuesFromRawInfo($rawSubjectText);

        $subject->setCity($values[self::CITY_TAG]);
        $subject->setRegion($values[self::REGION_TAG]);
        $subject->setFirstAndMiddleName($values[self::FIRST_AND_MIDDLE_NAME_TAG]);
        $subject->setCommonName($values[self::COMMON_NAME_TAG]);
        $subject->setLastName($values[self::LAST_NAME_TAG]);
        $subject->setEmail($values[self::EMAIL_TAG]);
        $subject->setCountry($values[self::COUNTRY_TAG]);
        $subject->setInn($values[self::INN_TAG]);
        $subject->setOgrnip($values[self::OGRNIP_TAG]);
        $subject->setSnils($values[self::SNILS_TAG]);

        return $subject;
    }


    /**
     * @return string
     */
    public function getFirstAndMiddleName()
    {
        return $this->firstAndMiddleName;
    }

    /**
     * @param string $firstAndMiddleName
     */
    public function setFirstAndMiddleName($firstAndMiddleName): void
    {
        $this->firstAndMiddleName = $firstAndMiddleName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getCommonName()
    {
        return $this->commonName;
    }

    /**
     * @param string $commonName
     */
    public function setCommonName($commonName): void
    {
        $this->commonName = $commonName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getOgrnip()
    {
        return $this->ogrnip;
    }

    /**
     * @param string $ogrnip
     */
    public function setOgrnip($ogrnip): void
    {
        $this->ogrnip = $ogrnip;
    }

    /**
     * @return string
     */
    public function getInn()
    {
        return $this->inn;
    }

    /**
     * @param string $inn
     */
    public function setInn($inn): void
    {
        $this->inn = $inn;
    }

    /**
     * @return string
     */
    public function getSnils()
    {
        return $this->snils;
    }

    /**
     * @param string $snils
     */
    public function setSnils($snils): void
    {
        $this->snils = $snils;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    
}
