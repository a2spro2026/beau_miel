<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class SiteSettings
{
    public static function path(): string
    {
        return storage_path('app/settings/site.json');
    }

    public static function defaults(): array
    {
        return [
            'habillage' => '',
            'titre' => 'Notre histoire',
            'description' => 'Vidéo bientôt disponible',
            'video_url' => '',
            'video_file' => '',
            'use_url' => false,
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
     * @return array{type: string, src: string}|null
     */
    public static function videoPlayer(array $settings): ?array
    {
        if (! empty($settings['use_url']) && ! empty($settings['video_url'])) {
            $url = trim($settings['video_url']);

            if ($id = self::youtubeId($url)) {
                return [
                    'type' => 'youtube',
                    'src' => 'https://www.youtube.com/embed/'.$id.'?rel=0&modestbranding=1',
                ];
            }

            if ($id = self::vimeoId($url)) {
                return [
                    'type' => 'vimeo',
                    'src' => 'https://player.vimeo.com/video/'.$id,
                ];
            }

            return [
                'type' => 'file',
                'src' => $url,
            ];
        }

        if (! empty($settings['video_file'])) {
            return [
                'type' => 'file',
                'src' => asset('storage/'.$settings['video_file']),
            ];
        }

        return null;
    }

    public static function videoSrc(array $settings): ?string
    {
        $player = self::videoPlayer($settings);

        return $player['src'] ?? null;
    }

    public static function youtubeId(string $url): ?string
    {
        if (preg_match('~(?:youtube\.com/watch\?.*v=|youtu\.be/|youtube\.com/embed/|youtube\.com/shorts/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    public static function vimeoId(string $url): ?string
    {
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    public static function habillageSrc(array $settings): string
    {
        if (! empty($settings['habillage'])) {
            return asset('storage/'.$settings['habillage']);
        }

        return asset('images/hero.png');
    }
}
