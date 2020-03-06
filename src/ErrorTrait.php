<?php

namespace Cryptopro;

use Cryptopro\Exception\ExceptionWithUuid;

trait ErrorTrait {
    private $errors;

    private function addError(ExceptionWithUuid $exceptionWithUuid) {
        $uuid = $exceptionWithUuid->getUuid();
        $this->errors[$uuid] = $exceptionWithUuid->getMessage();
    }

    /**
     * @param ExceptionWithUuid[] $exceptionsWithUuid
     * @author Zulfigarov Nuran <nuran@zulfigarov.tech>
     * Date: 2020-01-19
     */
    private function addErrorBatch(array $exceptionsWithUuid) {
        foreach ($exceptionsWithUuid as $exceptionWithUuid) {
            $this->addError($exceptionWithUuid);
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}