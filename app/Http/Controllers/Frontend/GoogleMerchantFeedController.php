<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MerchantFeedLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GoogleMerchantFeedController extends Controller
{
    public function feed(Request $request): Response
    {
        $products = Product::with(['featuredImage', 'category'])
            ->where('status', 'published')
            ->get();

        $siteName = setting('site_name', 'Plantaric');
        $siteUrl = config('app.url');

        // Log this sync / feed fetch
        MerchantFeedLog::create([
            'channel' => 'google_merchant',
            'trigger_type' => $request->query('trigger', 'auto_fetch'),
            'status' => 'success',
            'items_count' => $products->count(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->header('User-Agent'), 0, 250),
            'message' => 'Google Merchant RSS Feed generated with ' . $products->count() . ' items.',
        ]);

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" xmlns:g="http://base.google.com/ns/1.0"></rss>');
        
        $channel = $xml->addChild('channel');
        $channel->addChild('title', htmlspecialchars($siteName . ' — Google Merchant Product Feed'));
        $channel->addChild('link', $siteUrl);
        $channel->addChild('description', htmlspecialchars('Live Google Merchant Center product catalog feed for ' . $siteName));

        foreach ($products as $product) {
            $item = $channel->addChild('item');
            
            $item->addChild('g:id', (string) ($product->sku ?: $product->id), 'http://base.google.com/ns/1.0');
            $item->addChild('g:title', htmlspecialchars($product->name), 'http://base.google.com/ns/1.0');
            $item->addChild('g:description', htmlspecialchars(strip_tags($product->short_description ?: $product->description ?: $product->name)), 'http://base.google.com/ns/1.0');
            $item->addChild('g:link', route('frontend.shop.product', $product->slug), 'http://base.google.com/ns/1.0');
            
            if ($product->featuredImage) {
                $imagePath = asset('storage/' . $product->featuredImage->file_path);
                $item->addChild('g:image_link', $imagePath, 'http://base.google.com/ns/1.0');
            } else {
                $item->addChild('g:image_link', asset('images/products/monstera_table.jpg'), 'http://base.google.com/ns/1.0');
            }

            $availability = ($product->stock_status?->value === 'in_stock' || $product->stock_quantity > 0) ? 'in_stock' : 'out_of_stock';
            $item->addChild('g:availability', $availability, 'http://base.google.com/ns/1.0');
            
            $formattedPrice = number_format((float) $product->price, 2, '.', '') . ' PKR';
            $item->addChild('g:price', $formattedPrice, 'http://base.google.com/ns/1.0');
            
            if ($product->compare_price && $product->compare_price > $product->price) {
                $item->addChild('g:sale_price', $formattedPrice, 'http://base.google.com/ns/1.0');
            }

            $brand = $product->brand_name ?: $siteName;
            $item->addChild('g:brand', htmlspecialchars($brand), 'http://base.google.com/ns/1.0');
            
            $item->addChild('g:condition', 'new', 'http://base.google.com/ns/1.0');
            
            if ($product->category) {
                $item->addChild('g:product_type', htmlspecialchars($product->category->name), 'http://base.google.com/ns/1.0');
            }

            if ($product->gtin) {
                $item->addChild('g:gtin', htmlspecialchars($product->gtin), 'http://base.google.com/ns/1.0');
            }

            if ($product->mpn) {
                $item->addChild('g:mpn', htmlspecialchars($product->mpn), 'http://base.google.com/ns/1.0');
            }
        }

        return response($xml->asXML(), 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
