<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Example\Src;

/**
 * Description of Helper
 *
 * @author josel
 */
class Helper
{

    private $tamplate = [];

    public function template(array $template): Helper
    {
        $this->tamplate = $template;
        return $this;
    }

    public function formatTemplate(string $helper, array $options = null): string
    {
        $template = stripos($helper, '::') !== false ? $this->templater[substr(
                        $helper,
                        stripos($helper, "::") + 2
                )] : $helper;
        for ($a = 0; $a < substr_count($template, '%s'); $a++) {
            if (!isset($options[$a])) {
                $options[$a] = null;
            }
        }
        return vsprintf($template, $options);
    }

}
