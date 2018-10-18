<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    // ...

    public function persistEntity($entity)
    {
        $this->updateSlug($entity);
        parent::persistEntity($entity);
    }

    public function updateEntity($entity)
    {
        $this->updateSlug($entity);
        parent::updateEntity($entity);
    }

    private function updateSlug($entity)
    {
        if (method_exists($entity, 'setSlug') and method_exists($entity, 'getTitle')) {
            $entity->setSlug($this->slugify($entity->getTitle()));
        }
    }

    private function slugify($string, $replace = array(), $delimiter = '-') 
    {
        // https://github.com/phalcon/incubator/blob/master/Library/Phalcon/Utils/Slug.php
        if (!extension_loaded('iconv')) {
            throw new Exception('iconv module not loaded');
        }
        // Save the old locale and set the new locale to UTF-8
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        if (!empty($replace)) {
            $clean = str_replace((array) $replace, ' ', $clean);
        }
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        // Revert back to the old locale
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }
}