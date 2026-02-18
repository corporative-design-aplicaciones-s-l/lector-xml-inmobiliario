<?php
namespace App\Controllers;

use App\Services\Mailer;
use App\Services\LeadStorage;

class ContactController
{
    public function send(): void
    {
        // ===== Validación básica =====
        $ref = trim($_POST['property_ref'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $message = trim($_POST['auto_message'] ?? '');
        $propId = trim($_POST['property_id'] ?? ''); // Asumimos que el ref es el ID de la propiedad para redirigir

        if (!$name || !$email || !$ref) {
            http_response_code(422);
            echo 'Missing required fields';
            return;
        }

        // Honeypot
        if (!empty($_POST['website'])) {
            http_response_code(400);
            exit('Spam detected');
        }

        $ts = (int) ($_POST['ts'] ?? 0);

        if (!$ts || time() - $ts < 2) {
            http_response_code(400);
            exit('Too fast');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(422);
            exit('Invalid data');
        }

        // ===== Guardar lead =====
        $lead = [
            'date' => date('Y-m-d H:i:s'),
            'property_ref' => $ref,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
        ];

        LeadStorage::save($lead);

        // ===== Email HTML =====
        $html = "
                <h2>New lead from Resales Costa Blanca</h2>
                <p><strong>Reference:</strong> {$ref}</p>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Phone:</strong> {$phone}</p>
                <pre>{$message}</pre>
            ";
        Mailer::send(
            subject: "Nuevo lead propiedad {$ref}",
            html: $html,
            replyTo: $email
        );

        // ===== Redirección =====
        header("Location: /property/{$propId}?sent=1");
        exit;
    }
}
