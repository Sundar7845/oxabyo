<?php

namespace App\Clients;

/* Facades */
use Mail;
use Log;

/**
 * Class MailClient
 *
 * @package App\Clients
 */
class MailClient
{
    /**
     * Send Mail
     *
     * @param string $email     - To Address
     * @param string $subject   - Subject
     * @param string $template  - Mail Template
     * @param array  $data      - body data
     *
     * @return void
     * @throws Exception
     */
    public function send(string $email, string $subject, string $template, array $data): void
    {
        try {
            Mail::send($template, ['data' => $data], function ($message) use ($email, $subject) {
                $message->to($email);
                $message->sender(env('MAIL_FROM_ADDRESS'));
                $message->subject($subject);
            });
        } catch (\Exception $exception) {
            Log::error("unexpected exception: ", [
                'exception'   => $exception->getMessage(),
                'stack_trace' => $exception->getTraceAsString()
            ]);
        }
    }
}
