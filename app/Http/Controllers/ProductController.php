<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZfrShopify\ShopifyClient;
use GuzzleHttp\Client;
use App\User;
use App\Shop;
use App\Desc;
use Auth;
use Yajra\Datatables\Datatables;

class ProductController extends Controller 
{
    public function __construct(){
        $this->middleware('auth');

    }
    public function index(){   
        return view('products.view');
    }
    public function user(){
        $user  = Auth::user();
        $shop = Shop::where('user_id','=',$user->id)->first();
        $api_key = "fb61431549ababa9500e38d296f326ad";
        $shared_secret = "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";

        $shopifyClient = new ShopifyClient([
            'private_app'   => false,
            'api_key'       => $api_key,
            'access_token'  => $shop->access_token,
            'shop'          => $shop->domain,
            'version'       => '2019-04'
        ]);
        return $shopifyClient;
    }

    /// to show all products
    public function get(){
        $shopifyClient = self::user();
        $products = $shopifyClient->getProducts();
        $data= [];
        $test = -1;
        foreach ($products as $product){ 


            foreach ($product['variants'] as $key =>  $variant){ 
                $test++;
                $data[$test]['id'] = $product['id']."/".$variant['id'];
                $data[$test]['title'] = $product['title']." (".$variant['title'].")";
                $data[$test]['vendor'] = $product['vendor'];
                $check =0;
                foreach ($product['images'] as $image){ 
                    if($image['id'] == $variant['image_id']){
                        $check++;
                      $data[$test]['image'] = $image['src'];
                    }
                }
                if($check ==0){
                    $data[$test]['image'] = $product['image']['src'];
                }
                }
            }
            return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '<a href="products/edit/'.$data["id"].'" class="btn btn-xs btn-primary"><i class="fas fa-edit"></i> Edit</a>';
            })
            ->make(true);
          
    }

    ///to show a single variant
    public function edit(Request $request,$pid,$vid){
        $pid = (int)$pid;
        $p = ['id'=>$pid];
        $shopifyClient = self::user();
        $product = $shopifyClient->getProduct($p);
        $shop = $shopifyClient->getShop();
        $shopDomain = $shop['domain'];
        $matchThese = ['shop_domain' => $shopDomain, 'product_id' => $pid, 'variant_id' => $request->vid];
        $desc  = Desc::where($matchThese)->first();
        if ($desc === NULL) {
            return view ('products.edit',['product'=> $product,'vid' => $vid]);
        }
       else{
        return view ('products.edit',['product'=> $product,'vid' => $vid,'description' => $desc]);
       }
     }

    //// upload and save image by tinymce
    public function upload(Request $request){
        $file=$request->file('file');
        $path= url('/uploads/').'/'.$file->getClientOriginalName();
        $imgpath=$file->move(public_path('/uploads/'),$file->getClientOriginalName());
        $fileNameToStore= $path;
        return json_encode(['location' => $fileNameToStore]); 
        
    }

    /// store or update variant description
    public function update(Request $request){
        $user  = Auth::user();
        $shop = Shop::where('user_id','=',$user->id)->first();
        $shopDomain = $shop->domain;
        $matchThese = ['shop_domain' => $shopDomain, 'product_id' => $request->product_id, 'variant_id' => $request->variant_id];
        $desc  = Desc::where($matchThese)->get();
        if ($desc->isEmpty()) {
            Desc::insert([
                'shop_domain' => $shopDomain,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'description' => $request->description
            ]);
         }
         else{
            Desc::where($matchThese)->update([
                'description' => $request->description
            ]);
         }
         return back();

    }


    /// send detail to requested variant
    public function singleget(Request $request){
        return $request;
    }
}
