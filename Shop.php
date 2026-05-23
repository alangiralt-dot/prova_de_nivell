<?php
declare(strict_types=1);
require_once('FatherProduct.php');
require_once('ChildProduct.php');
require_once('ToPlantUML.php');

class Shop {
  use ToPlantUML;
  // Properties
  private array $garments = [];
  // Getters
  private function getGarments(): array {return $this->garments;}
  // Methods
  public function getFatherProductWithMostSizes(): array {
    $names = [];
    $maximum = 0;
    foreach($this->getGarments() as $array) {
      foreach($array as $fp) {
        $total = count($fp->getSizes());
        if ($total > $maximum) {
          $maximum = $total;
          $names = [$fp->getName()];
        } elseif ($total === $maximum) {
          $names[] = $fp->getName();
        }
      }
    }
    return array_values(array_unique($names, SORT_REGULAR));
  }
  public function getFatherProductByPrice(float $price): array {
    $names = [];
    foreach($this->getGarments() as $array) {
      foreach($array as $fp) {
        if ($fp->getPrice() <= $price) {
          $names[] = $fp->getName();
        }
      }
    }
    return array_values(array_unique($names, SORT_REGULAR));
  }
  public function printTable(): void {
    printf("%-20s%-20s%10s%10s%10s%10s\n", 'CATEGORY', 'NAME', 'PRICE', 'SIZE', 'COLOR', 'STOCK');
    foreach($this->getGarments() as $category => $array) {
      foreach($array as $fp) {
        foreach($fp->getChildProducts() as $cp) {
          printf(
            "%-20s%-20s%10.2f%10s%10s%10s\n",
            $category,
            $fp->getName(),
            $fp->getPrice(),
            $cp->getSize(),
            $cp->getColor(),
            $cp->getStock()
          );
        }
      }
    }
  }
  public function addGarment(string $category, string $name, float $price, string $size, string $color, int $quantity): void {
    if ($category === '') throw new InvalidArgumentException('$category cannot be an empty string.');
    if ($name === '') throw new InvalidArgumentException('$name cannot be an empty string.');
    if ($price <= 0.0) throw new InvalidArgumentException('$price must be greater than zero.');
    if ($size === '') throw new InvalidArgumentException('$size cannot be an empty string.');
    if ($color === '') throw new InvalidArgumentException('$color cannot be an empty string.');
    if ($quantity <= 0.0) throw new InvalidArgumentException('$quantity must be greater than zero.');
    $fp = $this->findFatherProduct($category, $name, $price);
    if ($fp === null) {
      $this->addFatherProduct($category, $name, $price, $size, $color, $quantity);
    } else {
      $fp->addChildProduct($size, $color, $quantity);
    }
  }
  private function findFatherProduct(string $category, string $name, float $price): ?FatherProduct {
    if (!array_key_exists($category, $this->garments)) return null;
    foreach($this->garments[$category] as $fp) {
      if ($fp->getName() === $name && $fp->getPrice() === $price) return $fp;
    }
    return null;
  }
  private function addFatherProduct(
    string $category,
    string $name,
    float $price,
    string $size,
    string $color,
    int $quantity): void {
    $fp = new FatherProduct($name, $price);
    $fp->addChildProduct($size, $color, $quantity);
    $this->garments[$category][] = $fp;
  }
}