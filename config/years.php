<?php

return [
    'available_years' => array_values(array_filter(array_map(
        fn($v) => trim($v),
        explode(',', env('AVAILABLE_YEARS', ''))
    ))),
];
