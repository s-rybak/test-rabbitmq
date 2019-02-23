<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Transformer;

class ContactResourseTransformer implements ResourceTransformerInterface
{
    /**
     * Get entity type.
     *
     * @return string
     */
    public function getType(): string
    {
        return 'contact';
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
        return [
            'firstName' => $entity->getFirstName(),
            'lastName' => $entity->getLastName(),
            'phoneNumbers' => $entity->getPhoneNumbers(),
        ];
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
            'all' => [
                'href' => '/api/rows',
            ]
        ];
    }
}
