<?php

namespace AppBundle\Twig;

class ArrayToColumn extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('array2column', array($this, 'arrayToColumn')),
        ];
    }

    public function arrayToColumn(string $content): string
    {
        foreach ($this->getReplacements() as $replacement) {
            $content = preg_replace($replacement['search'], $replacement['replace'], $content);
        }

        return $content;
    }

    private function getReplacements()
    {
        yield ['search' => '/<table.*>(.*)<\/table>/Usi', 'replace' => '$1'];
        yield ['search' => '/<tr.*>(.*)<\/tr>/Usi', 'replace' => '<div class="row">$1</div>'];
        yield ['search' => '/<td.*>(.*)<\/td>/Usi', 'replace' => '<div class="col-md">$1</div>'];
    }
}
