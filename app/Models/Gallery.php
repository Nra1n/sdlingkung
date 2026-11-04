<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public const CATEGORIES = ['Fasilitas', 'Kegiatan', 'Pembelajaran', 'Prestasi'];

    protected $fillable = [
        'title',
        'category',
        'image',
        'video_url',
        'description',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $category ? $query->where('category', $category) : $query;
    }

    public function scopePhotos(Builder $query): Builder
    {
        return $query->whereNotNull('image')->where('image', '!=', '');
    }

    public function scopeVideos(Builder $query): Builder
    {
        return $query->whereNotNull('video_url');
    }

    public function getImageUrlAttribute(): string
    {
        return Media::url($this->image);
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        return self::youtubeEmbedUrl($this->video_url);
    }

    public function getYoutubeThumbnailUrlAttribute(): ?string
    {
        $videoId = self::youtubeVideoId($this->video_url);

        return $videoId ? 'https://i.ytimg.com/vi/'.$videoId.'/hqdefault.jpg' : null;
    }

    public static function youtubeEmbedUrl(?string $url): ?string
    {
        $videoId = self::youtubeVideoId($url);

        return $videoId ? 'https://www.youtube.com/embed/'.$videoId : null;
    }

    private static function youtubeVideoId(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $parts = parse_url($url);
        if (
            ! is_array($parts)
            || ! in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)
        ) {
            return null;
        }

        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        $videoId = null;

        if (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com'], true)) {
            if ($path === 'watch') {
                parse_str($parts['query'] ?? '', $query);
                $videoId = $query['v'] ?? null;
            } elseif (preg_match('~^(?:embed|shorts|live)/([^/]+)$~', $path, $matches)) {
                $videoId = $matches[1];
            }
        } elseif (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $videoId = $path;
        }

        if (! is_string($videoId) || ! preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId)) {
            return null;
        }

        return $videoId;
    }
}
