<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Http\Controllers\Admin;

use HoneyComb\Galleries\Services\HCGalleryTagService;
use HoneyComb\Galleries\Http\Requests\HCGalleryTagRequest;
use HoneyComb\Galleries\Models\HCGalleryTag;

use HoneyComb\Core\Http\Controllers\HCBaseController;
use HoneyComb\Core\Http\Controllers\Traits\HCAdminListHeaders;
use HoneyComb\Starter\Helpers\HCFrontendResponse;
use Illuminate\Database\Connection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HCGalleryTagController extends HCBaseController
{
    use HCAdminListHeaders;

    /**
     * @var HCGalleryTagService
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
     * HCGalleryTagController constructor.
     * @param Connection $connection
     * @param HCFrontendResponse $response
     * @param HCGalleryTagService $service
     */
    public function __construct(Connection $connection, HCFrontendResponse $response, HCGalleryTagService $service)
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
            'title' => trans('HCGalleries::gallery_tag.page_title'),
            'url' => route('admin.api.gallery.tag'),
            'form' => route('admin.api.form-manager', ['gallery.tag']),
            'headers' => $this->getTableColumns(),
            'actions' => $this->getActions('honey_comb_galleries_gallery_tag'),
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
            'label' => $this->headerText(trans('HCGalleries::gallery_tag.label')),
            'id' => $this->headerText(trans('HCGalleries::gallery_tag.slug')),
        ];

        return $columns;
    }

    /**
     * @param string $id
     * @return \HoneyComb\Galleries\Models\HCGalleryTag|\HoneyComb\Galleries\Repositories\HCGalleryTagRepository|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById(string $id)
    {
        return $this->service->getRepository()->findOneBy(['id' => $id]);
    }

    /**
     * Creating data list
     * @param HCGalleryTagRequest $request
     * @return JsonResponse
     */
    public function getListPaginate(HCGalleryTagRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->getRepository()->getListPaginate($request)
        );
    }

    /**
     * Create record
     *
     * @param HCGalleryTagRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(HCGalleryTagRequest $request): JsonResponse
    {
        $this->connection->beginTransaction();

        try {
            $this->service->getRepository()->updateOrCreate(['id' => $request->getSlug()], $request->getRecordData());

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
     * @param HCGalleryTagRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(HCGalleryTagRequest $request, string $id): JsonResponse
    {
        $model = $this->service->getRepository()->findOneBy(['id' => $id]);
        $model->update($request->getRecordData());

        return $this->response->success("Created");
    }


    /**
     * Soft delete record
     *
     * @param HCGalleryTagRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteSoft(HCGalleryTagRequest $request): JsonResponse
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
     * @param HCGalleryTagRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function restore(HCGalleryTagRequest $request): JsonResponse
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
     * @param HCGalleryTagRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteForce(HCGalleryTagRequest $request): JsonResponse
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

    /**
     * @param \HoneyComb\Galleries\Http\Requests\HCGalleryTagRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptions(HCGalleryTagRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->getRepository()->getOptions($request)
        );
    }

}