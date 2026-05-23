<?php
declare(strict_types=1);
require_once('Shop.php');

$shop = new Shop();
echo $shop->toPlantUML();
echo (new FatherProduct('abc', 12.3))->toPlantUML();
echo (new ChildProduct('abc', 'abc', 123))->toPlantUML();

$data = [
    // --- CATEGORIA: UNDERWEAR ---
    ['underwear', 'Boxer Briefs', 8.50, 'S', 'black', 4],   // Entrada inicial
    ['underwear', 'Boxer Briefs', 8.50, 'S', 'white', 7],   // Mateix pare, nova variant fill
    ['underwear', 'Boxer Briefs', 8.50, 'S', 'black', 2],   // REPETIT: Ha de sumar estoc al primer (total: 6)
    ['underwear', 'Boxer Briefs', 8.50, 'M', 'black', 10],  // Mateix pare, nova talla
    ['underwear', 'Socks Pack x3', 12.00, 'L', 'grey', 15], // Nou pare a la mateixa categoria

    // --- CATEGORIA: JACKET ---
    ['jacket', 'Winter Parka', 89.95, 'XL', 'green', 5],
    ['jacket', 'Winter Parka', 89.95, 'L', 'green', 3],       // Nova variant de talla
    ['jacket', 'Leather Jacket', 120.00, 'M', 'black', 2],   // Nou pare de jaqueta

    // --- CATEGORIA: TSHIRT ---
    ['tshirt', 'Graphic Tee', 19.99, 'M', 'white', 20],
    ['tshirt', 'Graphic Tee', 19.99, 'L', 'white', 15],
    ['tshirt', 'Graphic Tee', 19.99, 'M', 'black', 12],     // Nova variant de color
    ['tshirt', 'Graphic Tee', 19.99, 'M', 'white', 5],      // REPETIT: Sumarà estoc (total: 25)
    ['tshirt', 'V-Neck Shirt', 15.50, 'S', 'blue', 8],

    // --- CATEGORIA: JEANS ---
    ['jeans', 'Slim Fit Denim', 49.99, '40', 'blue', 14],
    ['jeans', 'Slim Fit Denim', 49.99, '42', 'blue', 18],
    ['jeans', 'Slim Fit Denim', 49.99, '40', 'grey', 6],
    ['jeans', 'Regular Fit', 39.99, '44', 'blue', 22],

    // --- CATEGORIA: FOOTWEAR ---
    ['footwear', 'Running Shoes', 75.00, '42', 'red', 4],
    ['footwear', 'Running Shoes', 75.00, '43', 'red', 6],
    ['footwear', 'Running Shoes', 75.00, '42', 'black', 8],
    ['footwear', 'Running Shoes', 75.00, '42', 'red', 2],   // REPETIT: Sumarà estoc (total: 6)
    ['footwear', 'Casual Sneakers', 60.00, '41', 'white', 11],
];

foreach($data as $d){
  $shop->addGarment($d[0], $d[1], $d[2], $d[3], $d[4], $d[5]);
}

echo 'The following table is a reflection of the products that are on sale and in stock:' . PHP_EOL;
$shop->printTable();

echo PHP_EOL .'The products that have the most sizes are the following:' . PHP_EOL;
foreach($shop->getFatherProductWithMostSizes() as $name) {
  echo ' - ' . $name . PHP_EOL;
};

$price = 30.0;
echo PHP_EOL ."The products that have a price equal to or less than $price are the following." . PHP_EOL;
foreach($shop->getFatherProductByPrice($price) as $name) {
  echo ' - ' . $name . PHP_EOL;
};

$array = $shop->getGarments();
$array['underwear'][0]->addChildProduct('', '', -1000);
$shop->printTable();
