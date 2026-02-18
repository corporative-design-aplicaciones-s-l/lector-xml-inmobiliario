<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected static function config(): array
    {
        return require BASE_PATH . '/app/config/mail.php';
    }

    public static function send(string $subject, string $html, string $replyTo = null): bool
    {
        $cfg = self::config();

        $mail = new PHPMailer(true);

        try {

            // SMTP
            $mail->isSMTP();
            $mail->Host = $cfg['host'];
            $mail->Port = $cfg['port'];
            $mail->SMTPAuth = true;
            $mail->Username = $cfg['username'];
            $mail->Password = $cfg['password'];
            $mail->SMTPSecure = $cfg['encryption'];

            // Remitente
            $mail->setFrom($cfg['from_email'], $cfg['from_name']);
            $mail->addAddress($cfg['to_email']);

            if ($replyTo) {
                $mail->addReplyTo($replyTo);
            }

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;

            $mail->send();

            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}
