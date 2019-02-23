<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Main pages site controller.
 *
 * Class MainController
 */
class MainController extends AbstractController
{
    /**
     * Home page.
     */
    public function index()
    {
        return $this->render('home.html.twig');
    }
}
