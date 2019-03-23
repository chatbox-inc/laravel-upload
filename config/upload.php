<?php

return [
    "routes" => [
        [
            "preifx" => "api/image",
            "driver" => "cache",
            "middleware" => ["api"]
        ]
    ],
    "drivers" => [
        "cache" => [
            "driver" => "cache",
            "options" => []
        ],
        "database" => [
            "driver" => "database",
            "options" => []
        ]
    ]
];
