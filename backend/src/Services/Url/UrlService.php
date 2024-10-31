<?php

namespace Me_Qr\Services\Url;

class UrlService
{
    public static function checkUrl(
        string $mainSearchUrl,
        array $needles = [],
        array $exclusions = []
    ): bool {
        $uri = sanitize_url($_SERVER['REQUEST_URI']);
        if (!$uri) {
            return false;
        }

        if ($exclusions) {
            foreach ($exclusions as $exclusion) {
                if (!is_string((string) $exclusion)) {
                    continue;
                }

                if (str_contains($uri, $exclusion)) {
                    return false;
                }
            }
        }

        $isExistMain = str_contains($uri, $mainSearchUrl);
        if (!$isExistMain) {
            return false;
        }

        if ($needles) {
            foreach ($needles as $needle) {
                if (!is_string((string) $needle)) {
                    continue;
                }

                if (!str_contains($uri, $needle)) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function isPostPage(): bool
    {
        $phpSelf = basename($_SERVER['PHP_SELF'] ?? null);
        $action = $_GET['action'] ?? null;

        return $phpSelf === "post-new.php" || ($phpSelf === "post.php" && $action === "edit");
    }

    public static function isGutenbergPage(): bool
    {
        if (!self::isPostPage()) {
            return false;
        }
        $post = get_post($_GET['post']);
        if (!$post) {
            return false;
        }
        $postType = $post->post_type;

        return $postType === 'page' || $postType === 'post';
    }

    public static function isWoocommercePage(): bool
    {
        if (!function_exists('is_plugin_active') || !is_plugin_active('woocommerce/woocommerce.php')) {
            return false;
        }

        if (!self::isPostPage()) {
            return false;
        }
        $post = get_post($_GET['post']);
        if (!$post) {
            return false;
        }
        $postType = $post->post_type;

        return $postType === 'product';
    }
}
