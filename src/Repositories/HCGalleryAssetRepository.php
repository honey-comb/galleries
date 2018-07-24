<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Repositories;

use HoneyComb\Galleries\Models\HCGalleryAsset;
use HoneyComb\Starter\Repositories\Traits\HCQueryBuilderTrait;
use HoneyComb\Starter\Repositories\HCBaseRepository;

class HCGalleryAssetRepository extends HCBaseRepository
{
    use HCQueryBuilderTrait;

    /**
     * @return string
     */
    public function model(): string
    {
        return HCGalleryAsset::class;
    }

    /**
     * Soft deleting records
     * @param $ids
     * @throws \Exception
     */
    public function deleteSoft(array $ids): void
    {
        $records = $this->makeQuery()->whereIn('id', $ids)->get();

        foreach ($records as $record) {
            /** @var HCGalleryAsset $record */
            $record->delete();
        }
    }

    /**
     * Restore soft deleted records
     *
     * @param array $ids
     * @return void
     */
    public function restore(array $ids): void
    {
        $records = $this->makeQuery()->withTrashed()->whereIn('id', $ids)->get();

        foreach ($records as $record) {
            /** @var HCGalleryAsset $record */
            $record->restore();
        }
    }

    /**
     * Force delete records by given id
     *
     * @param array $ids
     * @return void
     * @throws \Exception
     */
    public function deleteForce(array $ids): void
    {
        $records = $this->makeQuery()->withTrashed()->whereIn('id', $ids)->get();

        foreach ($records as $record) {
            /** @var HCGalleryAsset $record */
            $record->forceDelete();
        }
    }
}
