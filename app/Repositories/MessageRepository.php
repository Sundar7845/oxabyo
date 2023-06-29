<?php 

namespace App\Repositories;

/* Interfaces */
use App\Repositories\Interfaces\MessageRepositoryInterface;

/* Model */
use App\Message;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Create a new Message
     * 
     * @param array $data         - [ key => value ]
     *
     * @return Message
     */    
    public function create($data): Message
    {
        return Message::create($data);
    }

    /**
     * Find a Message
     * 
     * @param int   $id           - message.id
     *
     * @return Message
     */
    public function find(int $id)
    {
        return Message::find($id);
    }

    /**
     * Find all Message
     *
     * @return Collection
     */
    public function findAll()
    {
        return Message::get();
    }

    /**
     * Delete a Message
     * 
     * @param int   $id           - message.id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Message::find($id)->delete();
    }

}
