<?php

namespace App\Core;

class Form
{
    private string $formContent = '';

    public function create(): string
    {
        return $this->formContent;
    }

    public function formStart(string $method = 'post', string $action = '', array $attributes = []): self
    {
        $attr = $attributes ? $this->addAttributes($attributes) : '';

        $this->formContent .= "<form action='$action' method='$method' $attr>";

        return $this;
    }

    public function endForm(): self
    {
        $this->formContent .= '</form>';

        return $this;
    }

    public function addLabel(string $for, string $text, array $attributes = []): self
    {
        $attr = $attributes ? $this->addAttributes($attributes) : '';

        $this->formContent .= "<label for='$for' $attr>$text</label>";

        return $this;

    }

    public function addInput(string $type, string $name, string $id, array $attributes = []): self
    {
        $attr = $attributes ? $this->addAttributes($attributes) : '';

        $this->formContent .= "<input type='$type' name='$name' id='$id' $attr>";

        return $this;
    }

    public function addButton(string $type, string $text, array $attributes = []): self
    {
        $attr = $attributes ? $this->addAttributes($attributes) : '';

        $this->formContent .= "<button type='$type' $attr>$text</button>";

        return $this;
    }

    public static function validate(array $form, array $champs): bool
    {
        // On parcourt les champs
        foreach($champs as $champ){
            // Si le champ est absent ou vide on retourne false
            if(empty($form[$champ])){
                return false;
            }
        }
        return true;
    }

    private function addAttributes(array $attributes): string
    {
        // On initialise une chaine vide
        $str = '';

        // On liste les attributs courts
        $courts = ['checked', 'selected', 'readonly', 'disabled', 'multiple', 'required', 'novalidate', 'autofocus'];

        // On parcourt les attributs transmis ($attributes)
        foreach($attributes as $attribute => $valeur){
            // Si l'attribut est dans les courts
            if(in_array($attribute, $courts) && $valeur === true){
                $str .= " $attribute";
            }else{
                $str .= " $attribute=\"$valeur\"";
            }
        }
        return $str;
    }

}