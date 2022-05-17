<?php

if (!function_exists('userAgentIsBot')) {
    function userAgentIsBot(): bool {
        return false !== stripos(request()->userAgent(), 'bot');
    }
}
