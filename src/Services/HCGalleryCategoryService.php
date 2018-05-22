<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Services;

use HoneyComb\Galleries\Repositories\HCGalleryCategoryRepository;

class HCGalleryCategoryService
{
    /**
     * @var HCGalleryCategoryRepository
     */
    private $repository;

    /**
     * HCGalleryCategoryService constructor.
     * @param HCGalleryCategoryRepository $repository
     */
    public function __construct(HCGalleryCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return HCGalleryCategoryRepository
     */
    public function getRepository(): HCGalleryCategoryRepository
    {
        return $this->repository;
    }
}