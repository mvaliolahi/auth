<?php

return [
    'slogan' => env('AUTH_SLOGAN', 'Authentication'),

    # If redirect_to sets to null Then use redirect_route
    'redirect_to' => '/',
    'redirect_route' => null,

    # second
    'token_expire' => 60,
];