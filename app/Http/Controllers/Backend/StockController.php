<?php

namespace App\Http\Controllers\Backend;

use App\Image;
use App\Product;
use App\ProductImage;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示库存页面
     */
    public function stockShow(Request $request){
        $total = Product::all()->count();
        return view('backend.stock.stockShow',['total'=>$total]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 添加库存页面
     */
    public function stockAdd(Request $request){
        return view('backend.stock.stockAdd');
    }

    /**
     * @param Request $request
     * @return array
     * 保存添加库存
     */
    public function addProducts(Request $request){
        $products = $request->products;
        try{
        foreach ($products as $product){
            $imageList = $product["imageList"];
            $product["imageList"] = "";
            $productId = DB::table("products")->insertGetId($product);
            $_product = Product::find($productId);
            //获取图片
            $images = Image::whereIn('id',$imageList)->get();
            $productImages = array();
            foreach ($images as $image){
                $p_image = new ProductImage();
                $p_image->productId = $_product->id;
                $p_image->fileOriginalName = $image->fileOriginalName;
                $p_image->fileRealName = $image->fileRealName;
                array_push($productImages,$p_image);
            }
            //保存产品图片
            $_product->images()->saveMany($productImages);
        }
        } catch (EncryptException $err){
            return ['status'=>'error','msg'=>'出现错误！'];
        }
        return ['status'=>'success','msg'=>'保存成功！'];
    }

    /**
     * @param Request $request
     * @return array
     * 删除产品
     */
    public function delProduct(Request $request){
        if(Product::destroy($request->productId)){
            return ["status"=>'success','msg'=>'删除成功'];
        }else{
            return ["status"=>'error','msg'=>'删除失败'];
        }
    }

    /**
     * @param Request $request
     * @return array
     * 删除产品
     */
    public function changeCount(Request $request){
        $product = Product::find($request->productId);
        $product->count = $request->count;
        if($product->save()){
            return ["status"=>'success','msg'=>'修改成功'];
        }else{
            return ["status"=>'error','msg'=>'修改失败'];
        }
    }

    /**
     * @param Request $request
     * @return array
     * 获取产品数据
     */
    public function getAllProducts(Request $request){
        switch ($request->type){
            case 1:$products = Product::where('No','like','%'.$request->criteria.'%')->get();break;//查找全部
            case 2:$products = Product::where('productName','like','%'.$request->criteria.'%')->get();break;//查找全部
            default :$products = Product::offset(($request->currentPage-1)*$request->pagesize)->limit($request->pagesize)->get();
        }
        $products->each(function ($product){
            $product->imageList = $product->images;
        });
        return response()->json(['products'=>$products]);
//        return ['products'=>$products];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 修改页面的进入与提交
     */
    public function alterProduct(Request $request){
        if($request->isMethod('get')){//进入
            return view('backend.stock.alterProduct',['productId'=>$request->productId]);
        }else{
            $new_product = $request->product;
            $product = Product::find($request->product['id']);

            $product->No = $new_product['No'];
            $product->productName = $new_product['productName'];
            $product->unit = $new_product['unit'];
            $product->unitPrice = $new_product['unitPrice'];
            $product->count = $new_product['count'];
            $product->position = $new_product['position'];
            $product->describe = $new_product['describe'];
            if($product->save()){
                return ["status"=>'success','msg'=>'修改成功'];
            }else{
                return ["status"=>'success','msg'=>'修改失败'];
            }
        }
    }


    /**
     * @param Request $request
     * @return mixed
     * 根据id获取产品
     */
    public function getProduct(Request $request){
        $product = Product::find($request->productId);
        $imageList = $product->images;
        return ['product'=>$product,'imageList'=>$imageList];
    }

    /**
     * @param Request $request
     * @return array
     * 上传图片--》添加页面
     */
    public function imageUpload(Request $request){
        $image = $request->file("productImage");
        $fileDir=base_path()."/public/productImage/";//保存路径
        $originalName=$image->getClientOriginalName();//获取文件原名
        $extension = $image -> getClientOriginalExtension();//获取文件后缀
        $newImagesName=md5(time()).random_int(5,5).".".$extension;//生成新的文件名
        $productImg = new Image();
        $productImg->fileOriginalName = $originalName;
        $productImg->fileRealName = $newImagesName;
        if($image->move($fileDir,$newImagesName) && $productImg->save()){
            return ['status' => 'success',
                'info' => '添加成功！',
                'productIndex'=>$request->productIndex,
                'imageId' => $productImg->id
            ];
        }
    }


    /**
     * @param Request $request
     * @return array
     * 上传图片-->修改页面
     */
    public function imageUploadAlter(Request $request){
        $image = $request->file("productImage");
        $fileDir=base_path()."/public/productImage/";//保存路径
        $originalName=$image->getClientOriginalName();//获取文件原名
        $extension = $image -> getClientOriginalExtension();//获取文件后缀
        $newImagesName=md5(time()).random_int(5,5).".".$extension;//生成新的文件名

        $product = Product::find($request->productId);
        $p_image = new ProductImage();
        $p_image->productId = $product->id;
        $p_image->fileOriginalName = $originalName;
        $p_image->fileRealName = $newImagesName;
        $productImages = array();
        array_push($productImages,$p_image);
        $product->images()->saveMany($productImages);
        if($image->move($fileDir,$newImagesName)){
            //保存产品图片
                return ['status' => 'success',
                    'info' => '添加成功！',
                    'productIndex'=>$request->productIndex,
                    'imageId' => $p_image->id
                ];
        }
    }

    /**
     * @param Request $request
     * 修改时删除上传的图片
     */
    public function delProductImage(Request $request){
        $fileRealName = ProductImage::find($request->imageId)->fileRealName;
        unlink ( base_path()."/public/productImage/". $fileRealName);
        ProductImage::destroy($request->imageId);
    }

}
