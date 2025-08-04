<?php

if (!function_exists('getProductImage')) {
    /**
     * Get product image URL with fallback to placeholder
     *
     * @param string|null $imagePath
     * @param int $width
     * @param int $height
     * @return string
     */
    function getProductImage($imagePath = null, $width = 400, $height = 300)
    {
        // Check if actual image exists
        if ($imagePath && file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }
        
        // Check for SVG alternative if original doesn't exist
        if ($imagePath) {
            // First check in the same directory
            $svgPath = pathinfo($imagePath, PATHINFO_DIRNAME) . '/' . pathinfo($imagePath, PATHINFO_FILENAME) . '.svg';
            if (file_exists(public_path($svgPath))) {
                return asset($svgPath);
            }
            
            // Also check in product-images directory if the original was in products directory
            if (strpos($imagePath, 'products/') === 0) {
                $newPath = str_replace('products/', 'product-images/', $imagePath);
                if (file_exists(public_path($newPath))) {
                    return asset($newPath);
                }
                
                // Check for SVG in the new directory
                $newSvgPath = pathinfo($newPath, PATHINFO_DIRNAME) . '/' . pathinfo($newPath, PATHINFO_FILENAME) . '.svg';
                if (file_exists(public_path($newSvgPath))) {
                    return asset($newSvgPath);
                }
            }
        }
        
        // Try placeholder service first
        try {
            return "https://via.placeholder.com/{$width}x{$height}/667eea/ffffff?text=Product+Image";
        } catch (Exception $e) {
            // Fallback to local SVG placeholder
            return asset('images/placeholders/product-placeholder.svg');
        }
    }
}

if (!function_exists('getCategoryIcon')) {
    /**
     * Get FontAwesome icon class for category
     *
     * @param string $categorySlug
     * @return string
     */
    function getCategoryIcon($categorySlug)
    {
        $icons = [
            'electronics' => 'fas fa-laptop',
            'clothing' => 'fas fa-tshirt',
            'books' => 'fas fa-book',
            'home-garden' => 'fas fa-home',
            'sports-outdoors' => 'fas fa-dumbbell',
        ];
        
        return $icons[$categorySlug] ?? 'fas fa-box';
    }
}

if (!function_exists('getPlaceholderImage')) {
    /**
     * Generate placeholder image URL
     *
     * @param int $width
     * @param int $height
     * @param string $text
     * @param string $bgColor
     * @param string $textColor
     * @return string
     */
    function getPlaceholderImage($width = 400, $height = 300, $text = 'No Image', $bgColor = '667eea', $textColor = 'ffffff')
    {
        $text = urlencode($text);
        return "https://via.placeholder.com/{$width}x{$height}/{$bgColor}/{$textColor}?text={$text}";
    }
}
