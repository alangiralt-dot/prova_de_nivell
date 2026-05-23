<?php
declare(strict_types=1);
require_once('ChildProduct.php');
require_once('ToPlantUML.php');

class FatherProduct {
  use ToPlantUML;
  // Properties
  private array $childProducts = [];
  // Constructor
  public function __construct(
    private string $name,
    private float $price
  ) {}
  // Getters
  public function getName(): string {return $this->name;}
  public function getPrice(): float {return $this->price;}
  public function getChildProducts(): array {return $this->childProducts;}
  // Method
  public function addChildProduct(string $size, string $color, int $quantity): void {
    $cp = $this->findChildProduct($size, $color);
    if ($cp === null) {
      $this->childProducts[] = new ChildProduct($size, $color, $quantity);
    } else {
      $cp->addQuantity($quantity);
    }
  }
  public function getSizes(): array {
    $sizes = [];
    foreach($this->childProducts as $cp) {
      $sizes[] = $cp->getSize();
    }
    $sizes = array_unique($sizes, SORT_REGULAR);
    sort($sizes);
    return $sizes;
  }
  private function findChildProduct(string $size, string $color): ?ChildProduct {
    foreach($this->childProducts as $cp) {
      if ($cp->getSize() === $size && $cp->getColor() === $color) return $cp;
    }
    return null;
  }
}