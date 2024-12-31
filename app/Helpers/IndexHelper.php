<?php

// Función para formatear los precios a euros
function _formatCurrency($value) {
    if (!$value) {
        return '0 €';  
    }
    return number_format($value, 2, ',', '.') . ' €';
}