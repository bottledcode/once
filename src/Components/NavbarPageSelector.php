<?php

namespace Withinboredom\Once\Components;

use Bottledcode\SwytchFramework\Template\Attributes\Component;
use Bottledcode\SwytchFramework\Template\Traits\RegularPHP;

#[Component('NavbarPageSelector')]
class NavbarPageSelector
{
    use RegularPHP;

    public function render(string $href, string $label, bool $mobile = false, bool|null $onPage = null): string
    {
        $onPage = $onPage ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $href;

        $classes = match($mobile) {
            true => match($onPage) {
                true => 'bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium',
                false => 'text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium',
            },
            false => match($onPage) {
                true => 'bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium',
                false => 'text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium'
            }
        };

        $this->begin();
        ?>
        <a
                href="<?= $href ?>"
            <?= $onPage ? 'aria-current="page"' : '' ?>
                class="<?= $classes ?>"
        >
            {<?= $label ?>}
        </a>
        <?php
        return $this->end();
    }
}
