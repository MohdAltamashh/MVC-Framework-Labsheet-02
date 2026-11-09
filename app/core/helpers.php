<?php
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function redirect(string $path): never { header('Location: '.BASE_URL.$path); exit; }
function flash(string $key, ?string $message=null): ?string {
    if ($message !== null) { $_SESSION['_flash'][$key]=$message; return null; }
    $value=$_SESSION['_flash'][$key]??null; unset($_SESSION['_flash'][$key]); return $value;
}
