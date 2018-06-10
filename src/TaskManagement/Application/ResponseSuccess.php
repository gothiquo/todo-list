<?php

namespace TaskManagement\Application;

class ResponseSuccess
{
    const STATUS_OK = 200;
    const STATUS_CREATED= 201;
    const STATUS_ACCEPTED = 202;
    const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;
    const STATUS_NO_CONTENT= 204;

    private $status;
    private $messages;

    public function ResponseSuccess($status, $message = null)
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