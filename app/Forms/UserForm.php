<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $id = $this->getData('id');

        $this
            ->add('cpfcnpj', 'text', [
                'label' => 'CPF / CNPJ',
                'rules' => "required|max:18|unique:users,cpfcnpj"
            ])
            ->add('name', 'text', [
                'label' => 'Nome',
                'rules' => 'required|max:255'
            ])
            ->add('email', 'email', [
                'label' => 'E-mail',
                'rules' => "required|max:255|unique:users,email,{$id}"
            ]);
    }
}
