<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $order = new Order();

        for ($i = 0; $i < 10; $i++) {
            $product = new Product("product$i", random_int(1, 100), "brand$i");
            $manager->persist($product);

            $item = new Item();
            $item->setQuantity(random_int(1, 10));
            $item->setProduct($product);
            $manager->persist($item);

            $order->addItem($item);
            $manager->persist($order);
        }

        $promotion = new Promotion(50, 10, true);
        $manager->persist($promotion);

        $manager->flush();
    }
}
