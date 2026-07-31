<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class CompanyProfile
{
    /** Indicatif par défaut (Algérie) si le numéro commence par 0. */
    public const DEFAULT_COUNTRY_CODE = '212';

    public static function path(): string
    {
        return storage_path('app/settings/company.json');
    }

    public static function defaults(): array
    {
        return [
            'nom_societe' => 'BEAUMIEL',
            'nom_gerant' => '',
            'contact' => '',
            'whatsapp' => '',
            'whatsapp_indicatif' => self::DEFAULT_COUNTRY_CODE,
            'ville' => '',
            'frais_livraison' => 30,
        ];
    }

    public static function all(): array
    {
        $path = self::path();

        if (! File::isFile($path)) {
            return self::defaults();
        }

        $data = json_decode(File::get($path), true);

        return array_merge(self::defaults(), is_array($data) ? $data : []);
    }

    public static function put(array $data): void
    {
        $path = self::path();
        $dir = dirname($path);

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0775, true);
        }

        File::put(
            $path,
            json_encode(array_merge(self::defaults(), $data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * Convertit un numéro local (ex. 0772494544) en format international WhatsApp
     * (ex. 213772494544), sans le signe +.
     */
    public static function normalizeWhatsapp(string $whatsapp, ?string $indicatif = null): ?string
    {
        $digits = preg_replace('/\D+/', '', $whatsapp) ?: '';

        if ($digits === '') {
            return null;
        }

        // 00XXXXXXXX → XXXXXXXX
        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }

        $code = preg_replace('/\D+/', '', (string) ($indicatif ?: self::DEFAULT_COUNTRY_CODE)) ?: self::DEFAULT_COUNTRY_CODE;

        // Numéro local type 0XXXXXXXXX → indicatif + reste
        if (str_starts_with($digits, '0')) {
            $digits = $code.substr($digits, 1);
        } elseif (! str_starts_with($digits, $code)) {
            // Ex. 772494544 → 212772494544
            $digits = $code.$digits;
        }

        return $digits !== '' ? $digits : null;
    }

    public static function whatsappDigits(?array $company = null): ?string
    {
        $company ??= self::all();

        return self::normalizeWhatsapp(
            (string) ($company['whatsapp'] ?? ''),
            (string) ($company['whatsapp_indicatif'] ?? self::DEFAULT_COUNTRY_CODE)
        );
    }

    public static function whatsappUrl(?array $company = null): ?string
    {
        $digits = self::whatsappDigits($company);

        return $digits ? 'https://wa.me/'.$digits : null;
    }

    public static function whatsappDisplay(?array $company = null): ?string
    {
        $digits = self::whatsappDigits($company);

        return $digits ? '+'.$digits : null;
    }
}
