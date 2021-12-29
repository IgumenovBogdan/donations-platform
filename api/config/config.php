<?php

declare(strict_types=1);

use App\Http\Action;

return [
    Action\HomeAction::class => function () {
        return new Action\HomeAction();
    },
    Action\TestAction::class => function () {
        return new Action\TestAction();
    },
];