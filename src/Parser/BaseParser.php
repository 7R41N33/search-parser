<?php

namespace Acme\Parser;

use Acme\Request\BaseRequest;

abstract class BaseParser
{
    /** @var BaseRequest */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    abstract public function parse();
}
