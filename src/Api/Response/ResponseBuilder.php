<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Response;

use App\Api\Entity\ApiEntityInterface;
use App\Api\Transformer\ResourceTransformerInterface;

final class ResponseBuilder
{
    private $resourceTransformer;
    /**
     * @var Response
     */
    private $response;

    /**
     * Creates instance of builder and initializes response.
     *
     * @param ResourceTransformerInterface $resourceTransformer
     *
     * @return ResponseBuilder
     */
    public static function getInstance(ResourceTransformerInterface $resourceTransformer): self
    {
        $builder = new self($resourceTransformer);
        $builder->createResponse();

        return $builder;
    }

    public function __construct(ResourceTransformerInterface $resourceTransformer)
    {
        $this->resourceTransformer = $resourceTransformer;
    }

    public function createResponse(): self
    {
        $this->response = new Response();

        return $this;
    }

    public function setEntity(ApiEntityInterface $entity): self
    {
        $this->response->setData(
            (new Resource($this->resourceTransformer->getType()))
                ->setId($entity->getId())
                ->setAttributes($this->resourceTransformer->getAttributes($entity))
        );

        $this->response->setLinks($this->resourceTransformer->getLinks($entity));

        return $this;
    }

    /**
     * @param EntityInterface[] $entities
     *
     * @return ResponseBuilder
     */
    public function setEntities($entities, $total = false): self
    {
        $data = [
            'entities' => [],
            'total' => $total ?? count($entities),
        ];
        foreach ($entities as $entity) {
            $resource = new Resource($this->resourceTransformer->getType());
            $resource->setId($entity->getId());
            $resource->setAttributes($this->resourceTransformer->getAttributes($entity));
            $data['entities'][] = $resource;
        }

        $this->response->setData($data);
        $this->response->setLinks($this->resourceTransformer->getLinks());

        return $this;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
