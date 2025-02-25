<?php

function detectUserLocale() {


// Verificar si hay un idioma especificado en la URL
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'es'])) {
    return $_GET['lang']; // Usar el idioma especificado en la URL
}
    
    // Detectar el idioma del navegador 
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); // Extraer los 2 primeros caracteres
    
    
    // Definir los idiomas soportados
    $supportedLanguages = ['en' => 'en', 'es' => 'es'];

    // Si el idioma está en la lista, usarlo; si no, usar inglés por defecto
    return $supportedLanguages[$lang] ?? 'es';


}

// Detectar el idioma del usuario
$locale = detectUserLocale();


// Cargar el archivo de traducción correspondiente
$translations = require __DIR__ . "../../locales/$locale.php";


// Retornar las traducciones para que `index.php` las use
return $translations;
