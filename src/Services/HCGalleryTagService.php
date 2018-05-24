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

    /**
     * @param array $tags
     * @return array
     */
    public function createFromRequest(array $tags)
    {
        $tagIds = [];

        foreach ($tags as $tag) {

            if (isset($tag['className'])) {
                $tag['id'] = str_slug($tag['label']);

                $tag = array_only($tag, ['id', 'label']);
                $tag = $this->getRepository()->updateOrCreate($tag)->toArray();
            }

            $tagIds[] = $tag['id'];
        }

        return $tagIds;
    }
}