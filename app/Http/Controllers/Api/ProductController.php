<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Products\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productRepo;
 
    public function __construct(ProductRepository $productRepo){
        $this->productRepo = $productRepo; // Khởi tạo repository


    }

     // Hàm xử lý lấy danh sách Product và phân trang theo $limit
    // Url api method GET: https://yoururl.com/api/products
    public function index(Request $request)
    {
        try {

            $limit = $request->get('limit', config('constants.DEFAULT_PAGE_SIZE'));
            $records = $this->productRepo->getByQuery($request->query(), $limit);
            return $this->successResponse($records);
        } catch (\Exception $exception) {
            return $this->errorResponse([
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $product = $this->productRepo->store($request->all());
            return $this->successResponse($product);
        } catch (\Exception $exception) {
            return $this->errorResponse([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
