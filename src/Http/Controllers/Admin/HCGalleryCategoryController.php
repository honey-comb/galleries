<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Http\Controllers\Admin;

use HoneyComb\Galleries\Services\HCGalleryCategoryService;
use HoneyComb\Galleries\Http\Requests\HCGalleryCategoryRequest;
use HoneyComb\Galleries\Models\HCGalleryCategory;

use HoneyComb\Core\Http\Controllers\HCBaseController;
use HoneyComb\Core\Http\Controllers\Traits\HCAdminListHeaders;
use HoneyComb\Starter\Helpers\HCFrontendResponse;
use Illuminate\Database\Connection;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class HCGalleryCategoryController extends HCBaseController
{
    use HCAdminListHeaders;

    /**
     * @var HCGalleryCategoryService
     */
    protected $service;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var HCFrontendResponse
     */
    private $response;

    /**
     * HCGalleryCategoryController constructor.
     * @param Connection $connection
     * @param HCFrontendResponse $response
     * @param HCGalleryCategoryService $service
     */
    public function __construct(Connection $connection, HCFrontendResponse $response, HCGalleryCategoryService $service)
    {
        $this->connection = $connection;
        $this->response = $response;
        $this->service = $service;
    }

    /**
     * Admin panel page view
     *
     * @return View
     */
    public function index(): View
    {
        $config = [
            'title' => trans('HCGalleries::gallery_category.page_title'),
            'url' => route('admin.api.gallery.category'),
            'form' => route('admin.api.form-manager', ['gallery.category']),
            'headers' => $this->getTableColumns(),
            'actions' => $this->getActions('honey_comb_galleries_gallery_category'),
        ];

        return view('HCCore::admin.service.index', ['config' => $config]);
    }

    /**
     * Get admin page table columns settings
     *
     * @return array
     */
    public function getTableColumns(): array
    {
        $columns = [
            'translation.label' => $this->headerText(trans('HCGalleries::gallery_category.label')),
        ];

        return $columns;
    }

    /**
     * @param string $id
     * @return \HoneyComb\Galleries\Models\HCGalleryCategory|\HoneyComb\Galleries\Repositories\HCGalleryCategoryRepository|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById(string $id)
    {
        return $this->service->getRepository()->findOneBy(['id' => $id]);
    }

    /**
     * Creating data list
     * @param HCGalleryCategoryRequest $request
     * @return JsonResponse
     */
    public function getListPaginate(HCGalleryCategoryRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->getRepository()->getListPaginate($request)
        );
    }

    /**
     * Create record
     *
     * @param HCGalleryCategoryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(HCGalleryCategoryRequest $request): JsonResponse
    {
        $this->connection->beginTransaction();

        try {
            /** @var HCGalleryCategory $model */
            $model = $this->service->getRepository()->create($request->getRecordData());
            $model->updateTranslations($request->getTranslations());

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();

            return $this->response->error($e->getMessage());
        }

        return $this->response->success("Created");
    }


    /**
     * Update record
     *
     * @param HCGalleryCategoryRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(HCGalleryCategoryRequest $request, string $id): JsonResponse
    {
        /** @var HCGalleryCategory $model */
        $model = $this->service->getRepository()->findOneBy(['id' => $id]);
        $model->update($request->getRecordData());
        $model->updateTranslations($request->getTranslations());

        return $this->response->success("Created");
    }


    /**
     * Soft delete record
     *
     * @param HCGalleryCategoryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteSoft(HCGalleryCategoryRequest $request): JsonResponse
    {
        $this->connection->beginTransaction();

        try {
            $this->service->getRepository()->deleteSoft($request->getListIds());

            $this->connection->commit();
        } catch (\Throwable $exception) {
            $this->connection->rollBack();

            return $this->response->error($exception->getMessage());
        }

        return $this->response->success('Successfully deleted');
    }


    /**
     * Restore record
     *
     * @param HCGalleryCategoryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function restore(HCGalleryCategoryRequest $request): JsonResponse
    {
        $this->connection->beginTransaction();

        try {
            $this->service->getRepository()->restore($request->getListIds());

            $this->connection->commit();
        } catch (\Throwable $exception) {
            $this->connection->rollBack();

            return $this->response->error($exception->getMessage());
        }

        return $this->response->success('Successfully restored');
    }


    /**
     * Force delete record
     *
     * @param HCGalleryCategoryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteForce(HCGalleryCategoryRequest $request): JsonResponse
    {
        $this->connection->beginTransaction();

        try {
            $this->service->getRepository()->deleteForce($request->getListIds());

            $this->connection->commit();
        } catch (\Throwable $exception) {
            $this->connection->rollBack();

            return $this->response->error($exception->getMessage());
        }

        return $this->response->success('Successfully deleted');
    }

}