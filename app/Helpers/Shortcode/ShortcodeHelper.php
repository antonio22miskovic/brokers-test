<?php

namespace App\Helpers\Shortcode;

class ShortcodeHelper
{
    protected static $shortcodes = [
        'tree_brokers' => \App\Shortcodes\Tree\Brokers::class,
        // Agrega aquí más shortcodes con su ruta
    ];

    /**
     * Carga y ejecuta un shortcode dinámicamente con parámetros.
     */
    public static function load($tag, $params = [])
    {
        // Convierte los parámetros a un string para pasarlos como atributos
        $attributes = '';
        foreach ($params as $key => $value) {
            $attributes .= " {$key}=\"{$value}\"";
        }

        // Genera el contenido a procesar como un shortcode
        $shortcode = "[{$tag}{$attributes}]";

        // Procesa el contenido para obtener el resultado
        return self::process($shortcode);
    }

    /**
     * Procesa un contenido buscando y reemplazando shortcodes.
     */
    public static function process($content)
    {
        return preg_replace_callback('/\[(\w+)([^\]]*)\]/', function ($matches) {
            $tag = $matches[1];
            $attrs = self::parseAttributes($matches[2] ?? '');

            try {
                return self::execute($tag, $attrs);
            } catch (\Exception $e) {
                return $matches[0]; // Si no está registrado, devuelve el shortcode original
            }
        }, $content);
    }

    /**
     * Ejecuta el shortcode con los atributos proporcionados.
     */
    protected static function execute($tag, $params)
    {
        if (!isset(self::$shortcodes[$tag])) {
            throw new \Exception("Shortcode '$tag' no registrado.");
        }

        $shortcode = self::$shortcodes[$tag];

        // Si el shortcode está registrado como una clase, llama a su método render
        if (is_string($shortcode) && class_exists($shortcode) && method_exists($shortcode, 'render')) {
            return call_user_func([$shortcode, 'render'], $params);
        }

        // Si es un callback, lo ejecuta directamente
        if (is_callable($shortcode)) {
            return call_user_func($shortcode, $params);
        }

        throw new \Exception("Shortcode '$tag' no tiene un método válido para renderizar.");
    }

    /**
     * Analiza los atributos de un shortcode.
     */
    private static function parseAttributes($text)
    {
        $attrs = [];
        preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $attrs[$match[1]] = $match[2];
        }

        return $attrs;
    }
    
}
