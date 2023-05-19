<?php

namespace App\Controller\Traits;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

trait FormErrorsTrait
{
    /**
     * @param Form $form
     * @return array
     */
    protected function getGeneralFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }
}