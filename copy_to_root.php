<?php
if (file_exists(__DIR__ . '/public/hki_umb_production.zip')) {
    copy(__DIR__ . '/public/hki_umb_production.zip', __DIR__ . '/hki_umb_production.zip');
    echo "Copied to root!";
}
