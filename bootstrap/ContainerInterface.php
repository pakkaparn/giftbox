<?php

namespace Bootstrap;

use Closure;

interface ContainerInterface
{
    public function __invoke(): Closure;
}
