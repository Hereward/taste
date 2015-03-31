<?php

include __DIR__.'/config/config.php';

require_once __DIR__.'/app.php';
require_once __DIR__.'/controllers/base_controller.php';
require_once __DIR__.'/models/base_model.php';
require_once __DIR__.'/models/recipe_model.php';
require_once __DIR__.'/models/ingredients_model.php';

$app = new App($config);

$app->init();
$app->run();

