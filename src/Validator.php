<?php
namespace App;

use Valitron\Validator as ValitronValidator;

class Validator extends ValitronValidator {
    
    protected static $_lang = "fr";
    
    public function __construct($data = array(), $fields = array(), $lang = null, $langDir = null)
    {
        parent::__construct($data, $fields, $lang, $langDir);
        self::addRule('image', function($field, $value, array $params, array $fields) {
            if ($value['size'] === 0) {
                return true;
            }
            $mimes = ['image/jpeg', 'image/png'];
            $finfo = new Finfo();
            $info = $finfo->file($value['tmp_name'], FILEINFO_MIME);
            return in_array($info, $mimes);
        }, 'Le fichier n\'est pas une valide');
    }
    
    protected function checkAndSetLabel($field, $message, $params)
    {
        return str_replace('{field}', '', $message);
    }
}
