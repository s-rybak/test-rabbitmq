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
use App\Service\ContactServiceInterface;
use App\Transformers\ContactDTOToArrayTransformer;
use App\Transformers\RequestToContactDTOTransformer;
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
    /**
     * @var ContactServiceInterface
     */
    private $service;

    public function __construct(ContactServiceInterface $contactService)
    {
        $this->service = $contactService;
    }

    /**
     * Add new row to db
     * Add new task to rabbitmq queue.
     *
     * @param Request $request
     *
     * @return View
     *
     * @Rest\Post("/row/add")
     */
    public function postAddRow(Request $request): View
    {
        //TODO add validation

        $contact = (new RequestToContactDTOTransformer($request))->transform();

        $this->service->lazyCreate(
            (new RequestToContactDTOTransformer($request))
                ->transform()
        );

        return $this->view(
            ResponseBuilder::getInstance(new EmptyResourseTransformer())
                ->getResponse()
                ->setLinks([
                    'all' => [
                        'href' => '/api/rows',
                    ],
                ])
                ->setData((new ContactDTOToArrayTransformer($contact))->transform())
                ->setMessage('Task added')
                ->setStatus('success'),
            Response::HTTP_OK);
    }

    /**
     * Get all rows.
     *
     * @param Request $request
     *
     * @return View
     *
     * @Rest\Get("/rows")
     */
    public function getRows(Request $request): View
    {
        return $this->view(
            ResponseBuilder::getInstance(new EmptyResourseTransformer())
                ->getResponse()
                ->setMessage('Rows')
                ->setStatus('success'),
            Response::HTTP_OK);
    }
}
