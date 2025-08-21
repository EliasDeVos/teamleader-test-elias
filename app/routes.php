<?php

use App\Application\Actions\Order\DiscountAction;
use Slim\App;

return function (App $app) {
    $app->get('/discounts', DiscountAction::class . ':action');
};
