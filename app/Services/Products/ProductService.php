<?php

namespace App\Services\Products;

use App\Repositories\Products\ProductRepository;
use App\Services\Base\BaseService;
use Darkness\Repository\BaseRepository;

class ProductService extends BaseService
{
    /**
     * ProductRepository.
     * @var BaseRepository
     */
    protected $repository;

    /**
     * ProductService constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

}
