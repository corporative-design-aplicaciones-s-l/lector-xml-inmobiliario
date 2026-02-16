<?php

namespace App\Services;

class TextNormalizer
{
    public static function description(?string $text): string
    {
        if (!$text) {
            return '';
        }

        // Convertir entidades CR/LF del XML
        $text = str_replace(['&#13;', '&#10;'], "\n", $text);

        // Decodificar entidades HTML
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Normalizar saltos
        $text = preg_replace("/\r\n|\r/", "\n", $text);

        // Limitar saltos múltiples
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return trim($text);
    }

    /**
     * Devuelve HTML limpio listo para imprimir
     */
    public static function descriptionHtml(?string $text): string
    {
        $text = self::description($text);

        if ($text === '') {
            return '';
        }

        // 🧠 Detectar si ya contiene HTML
        if (strip_tags($text) !== $text) {

            // Limpiar atributos basura de editores/XML
            $text = preg_replace('/\sdata-[^=]+="[^"]*"/i', '', $text);

            // Permitir solo etiquetas seguras
            return strip_tags($text, '<p><br><ul><ol><li><strong><b><em><i>');
        }

        // Si es texto plano → convertir a párrafos
        $paragraphs = explode("\n\n", $text);

        $paragraphs = array_map(
            fn($p) => '<p>' . nl2br(htmlspecialchars(trim($p))) . '</p>',
            $paragraphs
        );

        return implode("\n", $paragraphs);
    }
}
