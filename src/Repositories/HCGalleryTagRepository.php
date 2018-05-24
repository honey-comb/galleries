<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Repositories;

use HoneyComb\Galleries\Http\Requests\HCGalleryTagRequest;
use HoneyComb\Galleries\Models\HCGalleryTag;
use HoneyComb\Core\Repositories\Traits\HCQueryBuilderTrait;
use HoneyComb\Starter\Repositories\HCBaseRepository;
use Illuminate\Support\Collection;

class HCGalleryTagRepository extends HCBaseRepository
{
    use HCQueryBuilderTrait;

    /**
     * @return string
     */
    public function model(): string
    {
        return HCGalleryTag::class;
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
            /** @var HCGalleryTag $record */
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
            /** @var HCGalleryTag $record */
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
            /** @var HCGalleryTag $record */
            $record->forceDelete();
        }
    }

    /**
     * @param \HoneyComb\Galleries\Http\Requests\HCGalleryTagRequest $request
     * @return \Illuminate\Support\Collection
     */
    public function getOptions(HCGalleryTagRequest $request): Collection
    {
        return $this->createBuilderQuery($request)->get()->map(function ($record) {
            return [
                'id' => $record->id,
                'label' => $record->id
            ];
        });
    }
}