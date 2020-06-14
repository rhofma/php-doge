<?php

function send(string $to, string $subject, string $view, array $data = []): bool
{
    $from = config()['email']['from'];

    $headers = [
        'From' => $from,
        'Reply-To' => $to,
        'X-Mailer' => 'PHP/' . phpversion(),
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/html; charset=UTF-8'
    ];

    $message = template($view, $data);

    return mail($to, $subject, $message, $headers);
}
