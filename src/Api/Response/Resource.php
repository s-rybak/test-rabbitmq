<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Response;

/**
 * Response resource.
 */
class Resource implements \JsonSerializable
{
    private $id;
    private $type;
    private $attributes;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @param int $id
     *
     * @return resource
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param iterable $attributes
     *
     * @return resource
     */
    public function setAttributes(iterable $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'attributes' => $this->attributes,
        ];
    }

    /**
     * Magic method.
     * Returns existing attribute.
     *
     * @param string $name
     *
     * @return string
     *
     * @throws \LogicException
     */
    public function __get(string $name): string
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        throw new \LogicException(
            \sprintf(
                'Attribute "%s" not found in resource of type "%s"',
                $name,
                $this->type
            )
        );
    }
}
