<?php

namespace App\Repositories\Interfaces;

/* Model */
use App\Message;

interface MessageRepositoryInterface
{
    /**
     * Create a new Message
     * 
     * @param array $data         - [ key => value ]
     *
     * @return Message
     */
    public function create($input): Message;

    /**
     * Find a Message
     * 
     * @param int   $id           - message.id
     *
     * @return Message
     */
    public function find(int $id);

    /**
     * Find all Message
     *
     * @return Collection
     */
    public function findAll();

    /**
     * Delete a Message
     * 
     * @param int   $id           - message.id
     *
     * @return bool
     */
    public function delete(int $id): bool;
}
