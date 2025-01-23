<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Filament\Pages\Auth\Register as AuthRegister;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class Register extends AuthRegister
{

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getDocumentNumberFormComponent(),
                $this->getcellphoneNumberFormComponent(),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getDocumentNumberFormComponent(): Component
    {
        return Document::make('document_number')
            ->validation(false)
            ->dynamic()
            ->label('CPF / CNPJ')
            ->required();
    }

    protected function getcellphoneNumberFormComponent(): Component
    {
        return PhoneNumber::make('telephone')
            ->label('Telefone')
            ->mask('(99) 99999-9999')
            ->required();
        }
}
