<?php
declare(strict_types=1);
require_once('ToPlantUML.php');

class ChildProduct {
  use ToPlantUML;
  // Constructor
  public function __construct(
    private string $size,
    private string $color,
    private int $stock
  ) {
    if ($size === '') throw new InvalidArgumentException('$size cannot be an empty string.');
    if ($color === '') throw new InvalidArgumentException('$color cannot be an empty string.');
    if ($stock < 0) throw new InvalidArgumentException('$stock must be greater than zero.');
  }
  // Getters
  public function getSize(): string {return $this->size;}
  public function getColor(): string {return $this->color;}
  public function getStock(): int {return $this->stock;}
  public function addQuantity(int $quantity): void {$this->stock += $quantity;}
}
