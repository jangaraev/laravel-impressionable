<?php

namespace Jangaraev\LaravelImpressionable\Contracts;

interface Impressionable
{
    public function incrementImpressions(): bool;
}
