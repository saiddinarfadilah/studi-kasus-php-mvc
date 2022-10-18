<?php

namespace StudiKasus\PHP\MVC\Controller;

class ProductController
{
    public function categories(int $productId):void
    {
        echo "Product Id : $productId".PHP_EOL;
    }
}