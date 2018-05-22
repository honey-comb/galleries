<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Services;

use HoneyComb\Galleries\Repositories\HCGalleryTagRepository;

class HCGalleryTagService
{
    /**
     * @var HCGalleryTagRepository
     */
    private $repository;

    /**
     * HCGalleryTagService constructor.
     * @param HCGalleryTagRepository $repository
     */
    public function __construct(HCGalleryTagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return HCGalleryTagRepository
     */
    public function getRepository(): HCGalleryTagRepository
    {
        return $this->repository;
    }
}