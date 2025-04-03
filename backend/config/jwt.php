<?php

return [
    'secret' => env('JWT_SECRET'),
    'ttl' => 60 * 24, // 24 hours
    'refresh_ttl' => 20160, // 2 weeks
    'algo' => 'HS256'
]; 