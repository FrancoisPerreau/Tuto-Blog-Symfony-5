<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello(): Response
    {
        // echo "Hello word";

        return new Response("Hello word !!!");
    }

    /**
     * @Route("/hello/{name}", name="hello_name")
     */
    public function helloName($name): Response
    {
        return new Response("Hello " . $name . " !!!");
    }
}
