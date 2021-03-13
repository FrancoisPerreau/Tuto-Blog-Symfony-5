<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;


class HelloController
{
    public function hello(): Response
    {
        // echo "Hello word";

        return new Response("Hello word !!!");
    }

    public function helloName($name): Response
    {
        return new Response("Hello " . $name . " !!!");
    }
}
