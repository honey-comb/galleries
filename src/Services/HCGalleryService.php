<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Services;

use HoneyComb\Galleries\Repositories\HCGalleryRepository;

class HCGalleryService
{
    /**
     * @var HCGalleryRepository
     */
    private $repository;

    /**
     * HCGalleryService constructor.
     * @param HCGalleryRepository $repository
     */
    public function __construct(HCGalleryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return HCGalleryRepository
     */
    public function getRepository(): HCGalleryRepository
    {
        return $this->repository;
    }
}