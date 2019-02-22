<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Api\Response\ResponseBuilder;
use App\Api\Transformer\EmptyResourseTransformer;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Main api controller.
 *
 * Class MainController
 */
class MainController extends FOSRestController
{
    public function __construct()
    {
    }

    /**
     * Add new row to db
     * Add new task to rabbitmq queue.
     *
     * @param Request $request
     *
     * @return View
     *
     * @Rest\Get("/row/add")
     */
    public function getAddRow(Request $request): View
    {
        return $this->view(
            ResponseBuilder::getInstance(new EmptyResourseTransformer())
                ->getResponse()
            ->setMessage('Test')
            ->setStatus('success'),
            Response::HTTP_OK);
    }
}
