<?php

if (! function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($phoneNumber) {
        return preg_replace('/[^0-9+]/', '', $phoneNumber);
    }
}
