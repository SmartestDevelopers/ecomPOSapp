<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeoController extends Controller
{
    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /cart/\n";
        $content .= "Disallow: /checkout/\n";
        $content .= "Disallow: /orders/\n";
        $content .= "\n";
        $content .= "Sitemap: " . url('/sitemap.xml');
        
        return response($content)
            ->header('Content-Type', 'text/plain');
    }

    public function sitemap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Homepage
        $xml .= $this->addUrl(url('/'), now(), 'daily', '1.0');
        
        // Static pages
        $xml .= $this->addUrl(url('/about'), now(), 'monthly', '0.8');
        $xml .= $this->addUrl(url('/contact'), now(), 'monthly', '0.8');
        $xml .= $this->addUrl(url('/categories'), now(), 'weekly', '0.9');
        $xml .= $this->addUrl(url('/products'), now(), 'daily', '0.9');
        
        // Categories
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            $xml .= $this->addUrl(
                url('/category/' . $category->slug),
                $category->updated_at,
                'weekly',
                '0.8'
            );
        }
        
        // Products
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $xml .= $this->addUrl(
                url('/product/' . $product->slug),
                $product->updated_at,
                'weekly',
                '0.7'
            );
        }
        
        $xml .= '</urlset>';
        
        return response($xml)
            ->header('Content-Type', 'application/xml');
    }
    
    private function addUrl($loc, $lastmod, $changefreq, $priority)
    {
        $xml = "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($loc) . "</loc>\n";
        $xml .= "    <lastmod>" . date('Y-m-d', strtotime($lastmod)) . "</lastmod>\n";
        $xml .= "    <changefreq>" . $changefreq . "</changefreq>\n";
        $xml .= "    <priority>" . $priority . "</priority>\n";
        $xml .= "  </url>\n";
        
        return $xml;
    }
}
