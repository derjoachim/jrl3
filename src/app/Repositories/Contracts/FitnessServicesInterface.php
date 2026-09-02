<?php namespace App\Repositories\Contracts;

interface FitnessServicesInterface
{
    
    public function __construct(string $name);
    public function latest();
}