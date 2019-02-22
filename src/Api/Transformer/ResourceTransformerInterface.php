<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Transformer;

/**
 * Transorm entity to resource interface.
 */
interface ResourceTransformerInterface
{
    /**
     * Get entity type.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Gets entity attributes.
     *
     * @param $entity
     *
     * @return iterable
     */
    public function getAttributes($entity): iterable;

    /**
     * Gets entity links.
     *
     * @param $entity
     *
     * @return iterable
     */
    public function getLinks($entity): iterable;
}
