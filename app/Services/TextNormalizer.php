<?php

namespace App\Services;

class TextNormalizer
{
    public static function description(?string $text): string
    {
        if (!$text) {
            return '';
        }

        // 1️⃣ Convertir entidades CR explícitas del XML
        $text = str_replace(['&#13;', '&#10;'], "\n", $text);

        // 2️⃣ Decodificar por si hay más entidades HTML
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 3️⃣ Normalizar saltos
        $text = preg_replace("/\r\n|\r/", "\n", $text);

        // 4️⃣ Limitar saltos múltiples
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return trim($text);
    }



    /**
     * Devuelve HTML con <p>
     */
    public static function descriptionHtml(?string $text): string
    {
        $text = self::description($text);

        if ($text === '') {
            return '';
        }

        // Separar por párrafos
        $paragraphs = explode("\n\n", $text);

        // Envolver en <p>
        $paragraphs = array_map(
            fn($p) => '<p>' . nl2br(htmlspecialchars(trim($p))) . '</p>',
            $paragraphs
        );

        return implode("\n", $paragraphs);
    }
}
