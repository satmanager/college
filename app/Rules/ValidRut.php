<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ValidRut implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //$value = $rut
        $cleanRut = Str::of($value)->replace('.','')->replace('-','')->replace('k','K');
        $verifDigit  = substr($cleanRut, -1);
        $number = substr($cleanRut, 0, strlen($cleanRut)-1);
        $i = 2;
        $sum = 0;
        foreach(array_reverse(str_split($number)) as $digit)//$v digit
        {
            if($i==8) $i = 2;
            $sum += $digit * $i;
            ++$i;
        }
    
        $verifDigitRem = 11 - ($sum % 11);
        
        if($verifDigitRem == 11)
            $verifDigitRem = 0;
        if($verifDigitRem == 10)
            $verifDigitRem = 'K';
    
        if($verifDigitRem == strtoupper($verifDigit))
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid RUT number.';
    }
}
