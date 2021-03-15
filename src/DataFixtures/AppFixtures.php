<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();

        $users = [];
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setUsername($faker->name)
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword($faker->password())
                ->setCreatedAt(new \DateTime());

            $manager->persist($user);
            $users[] = $user;
        }

        $categories = [];
        for ($i = 0; $i < 15; $i++) {
            $category = new Category();
            $category->setTitle($faker->text(50))
                ->setDescription($faker->text(250))
                ->setImage($faker->imageUrl());
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < 100; $i++) {
            $article = new Article();
            $article->setTitle($faker->text(50))
                ->setContent($faker->text(6000))
                // ->setImage($faker->imageUrl())
                // ->setImage("https://loremflickr.com/320/240")
                ->setImage($faker->image($dir = '/tmp', $width = 640, $height = 480))
                ->setCreatedAt(new \DateTime())
                ->addCategory($categories[$faker->numberBetween(0, 14)])
                ->setAuthor($users[$faker->numberBetween(0, 49)]);
            $manager->persist($article);
        }


        $manager->flush();
    }
}
