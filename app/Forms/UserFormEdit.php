<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserFormEdit extends Form
{
    public function buildForm()
    {
        $id = $this->getData('id');

        $this
            ->add('cpfcnpj', 'text', [
                'label' => 'CPF / CNPJ',
                'rules' => "required|max:18|unique:users,cpfcnpj,{$id}"
            ])
            ->add('name', 'text', [
                'label' => 'Nome',
                'rules' => 'required|max:255'
            ])
            ->add('email', 'email', [
                'label' => 'E-mail',
                'rules' => "required|max:255|email|unique:users,email,{$id}"
            ]);
    }
}
