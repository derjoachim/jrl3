<?php namespace App\Repositories\Contracts;

interface FitnessServicesInterface
{
    
    public function __construct($name);
    public function latest();
}