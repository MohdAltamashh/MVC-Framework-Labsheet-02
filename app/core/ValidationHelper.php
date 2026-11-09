<?php
class ValidationHelper {
    public static function product(array $data): array {
        $errors=[];
        $name=trim($data['name']??'');
        if ($name==='' || mb_strlen($name)>100) $errors['name']='Product name is required (max 100 characters).';
        if (!isset($data['price']) || !is_numeric($data['price']) || (float)$data['price']<=0) $errors['price']='Enter a price greater than zero.';
        if (!isset($data['quantity']) || filter_var($data['quantity'],FILTER_VALIDATE_INT)===false || (int)$data['quantity']<0) $errors['quantity']='Quantity must be a non-negative whole number.';
        return $errors;
    }
}
