<?php

function detectUserLocale() {
    // Verificar si hay un idioma especificado en la URL
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'es'])) {
        return $_GET['lang']; // Usar el idioma especificado en la URL
    }
    
    // Detectar el idioma del navegador 
    $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en'; // Usa 'en' si no está definido
    $language = substr($language, 0, 2) ?: 'en'; // Previene error si $language es null

    // Definir los idiomas soportados
    $supportedLanguages = ['en' => 'en', 'es' => 'es'];

    // Si el idioma está en la lista, usarlo; si no, usar español por defecto
    return $supportedLanguages[$language] ?? 'es';
}

// Detectar el idioma del usuario
$locale = detectUserLocale();

// Cargar el archivo de traducción correspondiente
$translations = require __DIR__ . "/../locales/$locale.php";

// Retornar las traducciones para que `index.php` las use
return $translations;
