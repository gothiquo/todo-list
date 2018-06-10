<?php

namespace TaskManagement\Application\Errors;

class ResponseError
{
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_REQUEST_RATE_EXCEEDED= 429;
    const STATUS_UNPROCESSABLE_ENTITY = 422;
    const STATUS_UNSUPPORTABLE_FILE_TYPE = 415;
    const STATUS_DATA_CHANGED_BEFORE = 409;
    const STATUS_RESOURCE_NOT_FOUND = 404;
    const STATUS_AUTHENTICATION_FAILURE = 401;

    private $status;
    private $messages;

    public function ResponseError($status, $message = null)
    {
        $this->status = $status;

        if (isset($message)) {
            $this->messages = array(
                'general' => array($message)
            );
        } else {
            $this->messages = array();
        }
    }

    public function addMessage($key, $message)
    {
        if (!isset($message)) {
            $message = $key;
            $key = 'general';
        }

        if (!isset($this->messages[$key])) {
            $this->messages[$key] = array();
        }

        $this->messages[$key][] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getStatus()
    {
        return $this->status;
    }
}