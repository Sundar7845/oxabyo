<?php

namespace App\Services\Interfaces;

interface MailServiceInterface
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
    public function send(string $email, string $subject, string $template, array $data);
}
