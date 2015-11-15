<?php namespace Jrl3\Repositories\Contracts;

interface FitnessServicesInterface
{
    
    public function __construct($name);
    public function latest();
}