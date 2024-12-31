<?php

use App\Helpers\Shortcode\ShortcodeHelper;
use App\Controllers\BrokerController;

// Definir la ruta de los brokers
Flight::route('/',  [BrokerController::class, 'index']);