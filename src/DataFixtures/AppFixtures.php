<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\FarmitooShippingFees;
use App\Entity\GallagherShippingFees;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\VAT;
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

        $vat = new VAT();
        $vat->setRate(20);

        $shippingFees = new FarmitooShippingFees();
        $shippingFees->setPrice(20);
        $shippingFees->setSlice(3);

        $brand1 = new Brand();
        $brand1->setTitle('Farmitoo');
        $brand1->setShippingFees($shippingFees);
        $brand1->addVAT($vat);
        $manager->persist($brand1);

        $vat = new VAT();
        $vat->setRate(5);

        $shippingFees = new GallagherShippingFees();
        $shippingFees->setPrice(15);

        $brand2 = new Brand();
        $brand2->setTitle('Gallagher');
        $brand2->setShippingFees($shippingFees);
        $brand2->addVAT($vat);
        $manager->persist($brand2);

        $brands = [$brand1, $brand2];

        for ($i = 0; $i < 10; $i++) {
            $brand = $brands[array_rand($brands)];

            $product = new Product("product$i", random_int(1, 100), $brand);
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
