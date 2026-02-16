<?php

namespace App\Services;

use AizPackages\CombinationGenerate\Services\CombinationService;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Upload;
use App\Models\User;
use App\Models\Wishlist;
use App\Utility\ProductUtility;
use Combinations;
use Illuminate\Support\Str;

class ProductService
{
    public function store(array $data)
    {
       
        $collection = collect($data);

        $approved = 1;
        if (auth()->user()->user_type == 'seller') {
            $user_id = auth()->user()->id;
            if (get_setting('product_approve_by_admin') == 1) {
                $approved = 0;
            }
        } else {
            $user_id = User::where('user_type', 'admin')->first()->id;
        }
        $tags = array();
        if ($collection['tags'][0] != null) {
            foreach (json_decode($collection['tags'][0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        // pdf specification 
         $pdf_specifications = [];

    // Check if the 'pdf_ids' and 'pdf_titles' keys exist in the collection
    if ($collection->has('pdf_ids') && $collection->has('pdf_titles')) {
        $pdfIds = explode(',', $collection->get('pdf_ids'));
        $pdfTitles = $collection->get('pdf_titles');

        // Loop through the selected PDF IDs and build the specifications array
        foreach ($pdfIds as $pdf_id) {
            // Ensure the title for this PDF exists and is not empty
            if (isset($pdfTitles[$pdf_id]) && !empty($pdfTitles[$pdf_id])) {
                $pdf_specifications[] = [
                    'id' => (int) $pdf_id, // Cast to integer for a clean JSON output
                    'title' => $pdfTitles[$pdf_id],
                ];
            }
        }

        // Encode the specifications array into a JSON string
        $pdf_json = json_encode($pdf_specifications);

        // Add the JSON string back to the collection under the 'pdf' key
        $collection->put('pdf', $pdf_json);

        // Remove the temporary 'pdf_ids' and 'pdf_titles' keys from the collection
        // This prevents them from being passed to the create method, which only expects 'pdf'
        $collection->forget(['pdf_ids', 'pdf_titles']);
    }
        // local video
        if ($data['video_provider'] == 'local' && !empty($data['local_video_id'])) {
            $upload  = Upload::find($data['local_video_id']);
            $collection->put('video_link', $upload->file_name);
        }
        if (!empty($data['video_thumbnail'])) {
            $upload  = Upload::find($data['video_thumbnail']);
            $collection->put('video_thumbnail', $upload->file_name);
        }
        $collection->forget('local_video_id');
        $collection['tags'] = implode(',', $tags);
        $discount_start_date = null;
        $discount_end_date   = null;
        if ($collection['date_range'] != null) {
            $date_var               = explode(" to ", $collection['date_range']);
            $discount_start_date = strtotime($date_var[0]);
            $discount_end_date   = strtotime($date_var[1]);
        }
        unset($collection['date_range']);
        
      

        // video links 
       
        // $collection->put('video_links', json_encode([]));
        // if (isset($data['video_links']) && is_array($data['video_links'])) {
            
        //       $links = array_values(array_filter(array_map('trim', $data['video_links']), function ($v) {
        //                 return $v !== '' && $v !== null;
        //           }));

        //     if (!empty($links)) {

        //         $collection->put('video_links', json_encode($links, JSON_UNESCAPED_SLASHES));
            
        //      }
        // }
        $collection->put('video_links', json_encode([])); // Initialize with an empty JSON array
if (isset($data['video_links']) && is_array($data['video_links'])) {
    
    // Filter out entries where both title and link are empty
    $filteredLinks = array_filter($data['video_links'], function ($item) {
        return !empty(trim($item['link'])) || !empty(trim($item['title']));
    });

    // Re-index the array and store it
    if (!empty($filteredLinks)) {
        $reindexedLinks = array_values($filteredLinks);
        $collection->put('video_links', json_encode($reindexedLinks, JSON_UNESCAPED_SLASHES));
    }
}

// specifications 
$collection->put('specifications', json_encode([])); // Initialize with an empty JSON array
if (isset($data['specifications']) && is_array($data['specifications'])) {
    
   
    
    // Filter out entries where both key and value are empty
    $filteredSpecs = array_filter($data['specifications'], function ($item) {
        return !empty(trim($item['key'])) || !empty(trim($item['value']));
    });

    // Re-index the array and store it
    if (!empty($filteredSpecs)) {
        $reindexedSpecs = array_values($filteredSpecs);
        $collection->put('specifications', json_encode($reindexedSpecs, JSON_UNESCAPED_SLASHES));
    }
}

        if ($collection['meta_title'] == null) {
            $collection['meta_title'] = $collection['name'];
        }
        if ($collection['meta_description'] == null) {
            $collection['meta_description'] = strip_tags($collection['description']);
        }

        if ($collection['meta_img'] == null) {
            $collection['meta_img'] = $collection['thumbnail_img'];
        }


        $shipping_cost = 0;
        if (isset($collection['shipping_type'])) {
            if ($collection['shipping_type'] == 'free') {
                $shipping_cost = 0;
            } elseif ($collection['shipping_type'] == 'flat_rate') {
                $shipping_cost = $collection['flat_shipping_cost'];
            }
        }
        unset($collection['flat_shipping_cost']);

        $slug = Str::slug($collection['name']);
        $same_slug_count = Product::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $colors = json_encode(array());
        if (
            isset($collection['colors_active']) &&
            $collection['colors_active'] &&
            $collection['colors'] &&
            count($collection['colors']) > 0
        ) {
            $colors = json_encode($collection['colors']);
        }

        $options = ProductUtility::get_attribute_options($collection);

        $combinations = (new CombinationService())->generate_combination($options);

        if (count($combinations) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = ProductUtility::get_combination_string($combination, $collection);

                unset($collection['price_' . str_replace('.', '_', $str)]);
                unset($collection['sku_' . str_replace('.', '_', $str)]);
                unset($collection['qty_' . str_replace('.', '_', $str)]);
                unset($collection['img_' . str_replace('.', '_', $str)]);
            }
        }

        unset($collection['colors_active']);

        $choice_options = array();
        if (isset($collection['choice_no']) && $collection['choice_no']) {
            $str = '';
            $item = array();
            foreach ($collection['choice_no'] as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['attribute_id'] = $no;
                $attribute_data = array();
                // foreach (json_decode($request[$str][0]) as $key => $eachValue) {
                foreach ($collection[$str] as $key => $eachValue) {
                    // array_push($data, $eachValue->value);
                    array_push($attribute_data, $eachValue);
                }
                unset($collection[$str]);

                $item['values'] = $attribute_data;
                array_push($choice_options, $item);
            }
        }

        $choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        if (isset($collection['choice_no']) && $collection['choice_no']) {
            $attributes = json_encode($collection['choice_no']);
            unset($collection['choice_no']);
        } else {
            $attributes = json_encode(array());
        }

        $published = 1;
        if ($collection['button'] == 'unpublish' || $collection['button'] == 'draft') {
            $published = 0;
        }
        unset($collection['button']);

        $collection['has_warranty'] = isset($collection['has_warranty']) ? 1 : 0;

        $data = $collection->merge(compact(
            'user_id',
            'approved',
            'discount_start_date',
            'discount_end_date',
            'shipping_cost',
            'slug',
            'colors',
            'choice_options',
            'attributes',
            'published',
        ))->toArray();

        return Product::create($data);
    }

    public function update(array $data, Product $product)
    {

        $collection = collect($data);

        $slug = Str::slug($collection['name']);
        $slug = $collection['slug'] ? Str::slug($collection['slug']) : Str::slug($collection['name']);
        $same_slug_count = Product::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count > 1 ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        if (addon_is_activated('refund_request') && !isset($collection['refundable'])) {
            $collection['refundable'] = 0;
        }

        if (!isset($collection['is_quantity_multiplied'])) {
            $collection['is_quantity_multiplied'] = 0;
        }

        if (!isset($collection['cash_on_delivery'])) {
            $collection['cash_on_delivery'] = 0;
        }
        if (!isset($collection['featured'])) {
            $collection['featured'] = 0;
        }
        if (!isset($collection['todays_deal'])) {
            $collection['todays_deal'] = 0;
        }
        
        // multiple files start 
           $specifications = [];

    // Check if the 'pdf_ids' key exists and if its value is not empty
    if ($collection->has('pdf_ids') && $collection->get('pdf_ids')) {
        $pdfIds = explode(',', $collection->get('pdf_ids'));
        $pdfTitles = $collection->get('pdf_titles') ?? []; // Use a default empty array to avoid errors

        // Loop through the selected PDF IDs and build the specifications array
        foreach ($pdfIds as $pdf_id) {
            // Ensure the title for this PDF exists and is not empty
            if (isset($pdfTitles[$pdf_id]) && !empty($pdfTitles[$pdf_id])) {
                $specifications[] = [
                    'id' => (int) $pdf_id, // Cast to integer for a clean JSON output
                    'title' => $pdfTitles[$pdf_id],
                ];
            }
        }
      // Remove the temporary 'pdf_ids' and 'pdf_titles' keys from the collection
           $collection->forget(['pdf_ids', 'pdf_titles']);
    }

    // Encode the specifications array into a JSON string, or null if empty
    $pdf_json = !empty($specifications) ? json_encode($specifications) : null;

    // Add the JSON string back to the collection under the 'pdf' key
    $collection->put('pdf', $pdf_json);

  
        // multiple pdf files 
        
        // local video upload 
        if ($data['video_provider'] == 'local' && !empty($data['local_video_id'])) {
            $upload  = Upload::find($data['local_video_id']);
            $collection['video_link'] = $upload->file_name;
        }
        unset($collection['local_video_id']);

        if (!empty($data['video_thumbnail'])) {
            $upload  = Upload::find($data['video_thumbnail']);
            $collection['video_thumbnail'] = $upload->file_name;
        }


        $tags = array();
        if ($collection['tags'][0] != null) {
            foreach (json_decode($collection['tags'][0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $collection['tags'] = implode(',', $tags);
        $discount_start_date = null;
        $discount_end_date   = null;
        if ($collection['date_range'] != null) {
            $date_var               = explode(" to ", $collection['date_range']);
            $discount_start_date = strtotime($date_var[0]);
            $discount_end_date   = strtotime($date_var[1]);
        }
        unset($collection['date_range']);
        
          

        // if (isset($data['video_links']) && is_array($data['video_links'])) {
        //     $links = array_values(array_filter(array_map('trim', $data['video_links']), function ($v) {
        //         return $v !== '' && $v !== null;
        //     }));

        //     if (!empty($links)) {
        //         // If Product::$casts has 'video_links' => 'array', use the next line instead:
        //         // $collection->put('video_links', $links);

        //         $collection->put('video_links', json_encode($links, JSON_UNESCAPED_SLASHES));
        //     }
        // } 
         $collection->put('video_links', json_encode([])); // Initialize with an empty JSON array
         if (isset($data['video_links']) && is_array($data['video_links'])) {
    
    // Filter out entries where both title and link are empty
    $filteredLinks = array_filter($data['video_links'], function ($item) {
        return !empty(trim($item['link'])) || !empty(trim($item['title']));
    });

    // Re-index the array and store it
    if (!empty($filteredLinks)) {
        $reindexedLinks = array_values($filteredLinks);
        $collection->put('video_links', json_encode($reindexedLinks, JSON_UNESCAPED_SLASHES));
    }
}

         // specifications 
$collection->put('specifications', json_encode([])); // Initialize with an empty JSON array
if (isset($data['specifications']) && is_array($data['specifications'])) {
    
   
    
    // Filter out entries where both key and value are empty
    $filteredSpecs = array_filter($data['specifications'], function ($item) {
        return !empty(trim($item['key'])) || !empty(trim($item['value']));
    });

    // Re-index the array and store it
    if (!empty($filteredSpecs)) {
        $reindexedSpecs = array_values($filteredSpecs);
        $collection->put('specifications', json_encode($reindexedSpecs, JSON_UNESCAPED_SLASHES));
    }
}


        if ($collection['meta_title'] == null) {
            $collection['meta_title'] = $collection['name'];
        }
        if ($collection['meta_description'] == null) {
            $collection['meta_description'] = strip_tags($collection['description']);
        }

        if ($collection['meta_img'] == null) {
            $collection['meta_img'] = $collection['thumbnail_img'];
        }

        if ($collection['lang'] != env("DEFAULT_LANGUAGE")) {
            unset($collection['name']);
            unset($collection['unit']);
            unset($collection['description']);
        }
        unset($collection['lang']);


        $shipping_cost = 0;
        if (isset($collection['shipping_type'])) {
            if ($collection['shipping_type'] == 'free') {
                $shipping_cost = 0;
            } elseif ($collection['shipping_type'] == 'flat_rate') {
                $shipping_cost = $collection['flat_shipping_cost'];
            }
        }
        unset($collection['flat_shipping_cost']);
        // speci

        $colors = json_encode(array());
        if (
            isset($collection['colors_active']) &&
            $collection['colors_active'] &&
            $collection['colors'] &&
            count($collection['colors']) > 0
        ) {
            $colors = json_encode($collection['colors']);
        }

        $options = ProductUtility::get_attribute_options($collection);

        $combinations = (new CombinationService())->generate_combination($options);
        if (count($combinations) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = ProductUtility::get_combination_string($combination, $collection);

                unset($collection['price_' . str_replace('.', '_', $str)]);
                unset($collection['sku_' . str_replace('.', '_', $str)]);
                unset($collection['qty_' . str_replace('.', '_', $str)]);
                unset($collection['img_' . str_replace('.', '_', $str)]);
            }
        }

        unset($collection['colors_active']);

        $choice_options = array();
        if (isset($collection['choice_no']) && $collection['choice_no']) {
            $str = '';
            $item = array();
            foreach ($collection['choice_no'] as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['attribute_id'] = $no;
                $attribute_data = array();
                // foreach (json_decode($request[$str][0]) as $key => $eachValue) {
                foreach ($collection[$str] as $key => $eachValue) {
                    // array_push($data, $eachValue->value);
                    array_push($attribute_data, $eachValue);
                }
                unset($collection[$str]);

                $item['values'] = $attribute_data;
                array_push($choice_options, $item);
            }
        }

        $choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        if (isset($collection['choice_no']) && $collection['choice_no']) {
            $attributes = json_encode($collection['choice_no']);
            unset($collection['choice_no']);
        } else {
            $attributes = json_encode(array());
        }

        $collection['has_warranty'] = isset($collection['has_warranty']) ? 1 : 0;

        unset($collection['button']);

        $data = $collection->merge(compact(
            'discount_start_date',
            'discount_end_date',
            'shipping_cost',
            'slug',
            'colors',
            'choice_options',
            'attributes',
        ))->toArray();

        $product->update($data);

        return $product;
    }

    public function product_duplicate_store($product)
    {
        $product_new = $product->replicate();
        $product_new->slug = $product_new->slug . '-' . Str::random(5);
        $product_new->approved = (get_setting('product_approve_by_admin') == 1 && $product->added_by != 'admin') ? 0 : 1;
        $product_new->save();

        return $product_new;
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->product_translations()->delete();
        $product->categories()->detach();
        $product->stocks()->delete();
        $product->taxes()->delete();
        $product->wishlists()->delete();
        $product->carts()->delete();
        $product->frequently_bought_products()->delete();
        $product->last_viewed_products()->delete();
        $product->flash_deal_products()->delete();
        deleteProductReview($product);
        Product::destroy($id);
    }

    public function product_search(array $data)
    {
        $collection     = collect($data);
        $auth_user      = auth()->user();
        $productType    = $collection['product_type'];
        $products       = Product::query();

        if ($collection['category'] != null) {
            $category = Category::with('childrenCategories')->find($collection['category']);
            $products = $category->products();
        }

        $products = in_array($auth_user->user_type, ['admin', 'staff']) ? $products->where('products.added_by', 'admin') : $products->where('products.user_id', $auth_user->id);
        $products->where('published', '1')->where('auction_product', 0)->where('approved', '1');

        if ($productType == 'physical') {
            $products->where('digital', 0)->where('wholesale_product', 0);
        } elseif ($productType == 'digital') {
            $products->where('digital', 1);
        } elseif ($productType == 'wholesale') {
            $products->where('wholesale_product', 1);
        }

        if ($collection['product_id'] != null) {
            $products->where('id', '!=', $collection['product_id']);
        }

        if ($collection['search_key'] != null) {
            $products->where('name', 'like', '%' . $collection['search_key'] . '%');
        }

        return $products->limit(20)->get();
    }

    public function setCategoryWiseDiscount(array $data)
    {
        $auth_user      = auth()->user();
        $discount_start_date = null;
        $discount_end_date   = null;
        if ($data['date_range'] != null) {
            $date_var               = explode(" to ", $data['date_range']);
            $discount_start_date = strtotime($date_var[0]);
            $discount_end_date   = strtotime($date_var[1]);
        }
        $seller_product_discount =  isset($data['seller_product_discount']) ? $data['seller_product_discount'] : null;
        $admin_id = User::where('user_type', 'admin')->first()->id;

        $products = Product::where('category_id', $data['category_id'])->where('auction_product', 0);
        if (in_array($auth_user->user_type, ['admin', 'staff']) && $seller_product_discount == 0) {
            $products = $products->where('user_id', $admin_id);
        } elseif ($auth_user->user_type == 'seller') {
            $products = $products->where('user_id', $auth_user->id);
        }

        $products->update([
            'discount' => $data['discount'],
            'discount_type' => 'percent',
            'discount_start_date' => $discount_start_date,
            'discount_end_date' => $discount_end_date,
        ]);
        return 1;
    }
}
