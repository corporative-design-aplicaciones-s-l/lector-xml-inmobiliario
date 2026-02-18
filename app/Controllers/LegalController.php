<?php
namespace App\Controllers;

class LegalController
{
    private function render(string $view, string $title, string $subtitle = ''): void
    {
        // variables disponibles en layout
        $pageTitle = $title;

        ob_start();
        require VIEW_PATH . "/legal/texts/{$view}.php";
        $content = ob_get_clean();

        // layout principal de toda la web
        require VIEW_PATH . "/layout/layout.php";
    }

    public function legal(): void
    {
        $this->render(
            view: 'legal',
            title: 'Legal Notice',
            subtitle: 'Website ownership and terms of use'
        );
    }

    public function privacy(): void
    {
        $this->render(
            view: 'privacy',
            title: 'Privacy Policy',
            subtitle: 'How we process and protect your personal data'
        );
    }

    public function cookies(): void
    {
        $this->render(
            view: 'cookies',
            title: 'Cookies Policy',
            subtitle: 'Information about cookies used on this website'
        );
    }
}
