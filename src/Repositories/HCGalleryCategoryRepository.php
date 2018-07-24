<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Repositories;

use HoneyComb\Galleries\Http\Requests\HCGalleryCategoryRequest;
use HoneyComb\Galleries\Models\HCGalleryCategory;
use HoneyComb\Starter\Repositories\Traits\HCQueryBuilderTrait;
use HoneyComb\Galleries\Models\HCGalleryCategoryTranslation;
use HoneyComb\Starter\Repositories\HCBaseRepository;
use Illuminate\Support\Collection;

class HCGalleryCategoryRepository extends HCBaseRepository
{
    use HCQueryBuilderTrait;

    /**
     * @return string
     */
    public function model(): string
    {
        return HCGalleryCategory::class;
    }

    /**
     * @return string
     */
    public function translationModel(): string
    {
        return HCGalleryCategoryTranslation::class;
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
            /** @var HCGalleryCategory $record */
            $record->translations()->delete();
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
            /** @var HCGalleryCategory $record */
            $record->translations()->restore();
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
            /** @var HCGalleryCategory $record */
            $record->translations()->forceDelete();
            $record->forceDelete();
        }
    }

    /**
     * @param \HoneyComb\Galleries\Http\Requests\HCGalleryCategoryRequest $request
     * @return \Illuminate\Support\Collection
     */
    public function getOptions(HCGalleryCategoryRequest $request): Collection
    {
        return $this->createBuilderQuery($request)->get()->map(function($record) {
            return [
                'id' => $record->id,
                'label' => $record->translation->label,
            ];
        });
    }
}