<?php

namespace Mvaliolahi\Auth\Contracts;

interface ShortMessageService
{
    public function send($number, $message);
}
