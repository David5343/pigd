<?php

$isWindows = PHP_OS_FAMILY === 'Windows';

return [
    'legacy_photo_root' => env(
        'LEGACY_INSURED_PHOTOS_PATH',
        $isWindows
            ? '\\\\10.10.30.14\\Afiliacion\\pigd\\prestaciones\\fotos_titular'
            : '/mnt/nas/pigd/prestaciones/fotos_titular'
    ),
    'legacy_signature_root' => env(
        'LEGACY_INSURED_SIGNATURES_PATH',
        $isWindows
            ? '\\\\10.10.30.14\\Afiliacion\\pigd\\prestaciones\\firmas_titular'
            : '/mnt/nas/pigd/prestaciones/firmas_titular'
    ),
];
