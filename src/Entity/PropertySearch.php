<?php
namespace App\Entity;

class  PropertySearch{

    /**
     * *@var int|null
     */

private $maxAge;
 /**
  * *@var int|null
  */

private $minAge;

    /**
 * @return int|null
 */
public function getMaxAge(): ?int
{
    return $this->maxAge;
}/**
 * @param int|null $maxAge
 */
public function setMaxAge(int $maxAge): void
{
    $this->maxAge = $maxAge;
}/**
 * @return int|null
 */
public function getMinAge(): ?int
{
    return $this->minAge;
}/**
 * @param int|null $minAge
 */
public function setMinAge(int $minAge): void
{
    $this->minAge = $minAge;
}




}