<?php
namespace App;

class Validator {
    public static function isXSS($input) {
        return $input !== htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public static function isSQLInjection($input) {
        $patterns = [
            '/(\%27)|(\')|(\-\-)|(\%23)|(#)/i',
            '/\b(select|insert|update|delete|drop|union|--)\b/i'
        ];
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }
        return false;
    }
}
