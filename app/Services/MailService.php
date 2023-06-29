<?php

namespace App\Services;

/* Client */
use App\Clients\MailClient;

/* Interfaces */
use App\Services\Interfaces\MailServiceInterface;

class MailService implements MailServiceInterface
{
    /**
     * Email template map.
     *
     * @var string[]
     */
    private $map = [
        'default'                   => 'emails.default',
        'invite-event'              => 'emails.invite-event',
        'email_rest'                => 'emails.email_rest',
        'invite-team'               => 'emails.invite-team',
        'join-teams'                => 'emails.join-team',
        'user-connection-request'   => 'emails.user-connection-request',
        'welcome'                   => 'emails.welcome',
        'contact-us'                => 'emails.contact-us',
        'message'                   => 'emails.message'
    ];
    
    /** @var MailClient */
    private $mailClient;

    /**
     * MailService constructor.
     *
     * @param MailClient    $mailClient
     */
    public function __construct(
        MailClient $mailClient
    ) {
        $this->mailClient = $mailClient;
    }

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
        return $this->mailClient->send($email, $subject, $this->map[$template], $data);
    }
}
