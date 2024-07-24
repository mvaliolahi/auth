<?php

return [
    'slogan' => env('AUTH_SLOGAN', 'Authentication'),

    # If redirect_to sets to null Then use redirect_route
    # If redirect_to and redirect_route set to null then use url.intended session.
    'redirect_to' => '/',
    'redirect_route' => null,

    # second
    'token_expire' => 60,
];
