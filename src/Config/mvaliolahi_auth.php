<?php

return [
    'slogan'       => env('AUTH_SLOGAN', 'Authentication'),

    'testing'      => false,
    'test_numbers' => [],

    # If redirect_to sets to null Then use redirect_route
    # If redirect_to and redirect_route set to null then use url.intended session.
    'redirect_to'    => '/',
    'redirect_route' => null,

    # second
    'token_expire' => 60,

    'login_validations'  => [],
    'verify_validations' => [],
    'verify_before_closures' => [],
    'send_token_before_closures' => [],

];
