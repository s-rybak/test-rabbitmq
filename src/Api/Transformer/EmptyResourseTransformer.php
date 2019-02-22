<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Transformer;

class EmptyResourseTransformer implements ResourceTransformerInterface
{
    /**
     * Get entity type.
     *
     * @return string
     */
    public function getType(): string
    {
        return 'no_resource';
    }

    /**
     * Gets entity attributes.
     *
     * @param $entity
     *
     * @return iterable
     */
    public function getAttributes($entity): iterable
    {
        return [];
    }

    /**
     * Gets entity links.
     *
     * @param $entity
     *
     * @return iterable
     */
    public function getLinks($entity): iterable
    {
        return [
            'api_docs' => '/docs/api',
        ];
    }
}
