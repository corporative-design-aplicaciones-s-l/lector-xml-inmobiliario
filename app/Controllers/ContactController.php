<?php
namespace App\Controllers;

use App\Services\Mailer;
use App\Services\LeadStorage;

class ContactController
{
    public function send(): void
    {
        // ================= CONTEXT =================
        $context = $_POST['context'] ?? 'property';

        // ================= CAMPOS =================
        $ref = trim($_POST['property_ref'] ?? '');
        $propId = trim($_POST['property_id'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $message = trim($_POST['auto_message'] ?? $_POST['message'] ?? '');

        // ================= VALIDACIÓN =================
        if (!$name || !$email) {
            http_response_code(422);
            exit('Missing required fields');
        }

        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(422);
            exit('Invalid data');
        }

        // ================= ANTISPAM =================

        // Honeypot
        if (!empty($_POST['website'])) {
            http_response_code(400);
            exit('Spam detected');
        }

        // Timer
        $ts = (int) ($_POST['ts'] ?? 0);
        if (!$ts || time() - $ts < 2) {
            http_response_code(400);
            exit('Too fast');
        }

        // ================= MENSAJE FINAL =================

        if ($context === 'property') {
            $finalMessage = "
PROPERTY ENQUIRY

Reference: {$ref}
Name: {$name}
Email: {$email}
Phone: {$phone}

Message:
{$message}
";
        } else {
            $finalMessage = "
GENERAL CONTACT REQUEST

Name: {$name}
Email: {$email}
Phone: {$phone}

Message:
{$message}
";
        }

        // ================= GUARDAR LEAD =================
        $lead = [
            'date' => date('Y-m-d H:i:s'),
            'context' => $context,
            'property_ref' => $ref ?: null,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
        ];

        LeadStorage::save($lead);

        // ================= EMAIL =================
        $html = nl2br(htmlspecialchars($finalMessage));

        Mailer::send(
            subject: $context === 'property'
            ? "New lead for property {$ref}"
            : "New general contact lead",
            html: $html,
            replyTo: $email
        );

        // ================= REDIRECCIÓN =================
        if ($context === 'property' && $propId) {
            header("Location: /property/{$propId}?sent=1");
        } else {
            header("Location: /?sent=1");
        }

        exit;
    }
}
