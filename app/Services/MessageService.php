<?php

namespace App\Services;

/* Interfaces */
use App\Services\Interfaces\MessageServiceInterface;

class MessageService implements MessageServiceInterface
{

    // /**
    //  * @var FileService
    //  */
    // private $fileService;
    

    // /**
    //  * MessageService constructor.
    //  *
    //  * @param MailClient    $mailClient
    //  */
    // public function __construct(
    //     MailClient $mailClient
    // ) {
    //     $this->mailClient = $mailClient;
    // }

    /**
     * Send Mail
     *
     * @param string $email     - To Address
     * @param string $subject   - Subject
     * @param string $template  - Mail Template
     * @param array  $data      - body data
     *
     * @return $this
     * @throws Exception
     */
    public function send(string $email, string $subject, string $template, array $data)
    {
       // return $this->mailClient->send($email, $subject, $this->map[$template], $data);
    }
}
