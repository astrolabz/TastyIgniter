<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines (Dutch)
    |--------------------------------------------------------------------------
    */

    'accepted' => ':attribute moet geaccepteerd worden.',
    'active_url' => ':attribute is geen geldige URL.',
    'after' => ':attribute moet een datum na :date zijn.',
    'alpha' => ':attribute mag alleen letters bevatten.',
    'alpha_dash' => ':attribute mag alleen letters, nummers, underscores (_) en streepjes (-) bevatten.',
    'alpha_num' => ':attribute mag alleen letters en nummers bevatten.',
    'array' => ':attribute moet geselecteerde elementen bevatten.',
    'before' => ':attribute moet een datum voor :date zijn.',
    'between' => [
        'numeric' => ':attribute moet tussen :min en :max zijn.',
        'file' => ':attribute moet tussen :min en :max kilobytes zijn.',
        'string' => ':attribute moet tussen :min en :max karakters zijn.',
        'array' => ':attribute moet tussen :min en :max items bevatten.',
    ],
    'email' => ':attribute is geen geldig e-mailadres.',
    'required' => ':attribute is verplicht.',
    'max' => [
        'numeric' => ':attribute mag niet hoger dan :max zijn.',
        'file' => ':attribute mag niet meer dan :max kilobytes zijn.',
        'string' => ':attribute mag niet uit meer dan :max tekens bestaan.',
        'array' => ':attribute mag niet meer dan :max items bevatten.',
    ],
    'min' => [
        'numeric' => ':attribute moet minimaal :min zijn.',
        'file' => ':attribute moet minimaal :min kilobytes zijn.',
        'string' => ':attribute moet minimaal :min tekens zijn.',
        'array' => ':attribute moet minimaal :min items bevatten.',
    ],
    'numeric' => ':attribute moet een getal zijn.',
    'string' => ':attribute moet een tekst zijn.',
    'unique' => ':attribute is al in gebruik.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes (Dutch)
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'naam',
        'email' => 'e-mailadres',
        'password' => 'wachtwoord',
        'password_confirmation' => 'wachtwoord bevestiging',
        'telephone' => 'telefoonnummer',
        'address' => 'adres',
        'city' => 'stad',
        'postcode' => 'postcode',
        'country' => 'land',
    ],

];
