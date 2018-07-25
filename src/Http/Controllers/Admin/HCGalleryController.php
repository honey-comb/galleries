<?php

declare(strict_types = 1);

namespace HoneyComb\Galleries\Http\Controllers\Admin;

use HoneyComb\Galleries\Services\HCGalleryService;
use HoneyComb\Galleries\Http\Requests\HCGalleryRequest;
use HoneyComb\Galleries\Models\HCGallery;

use HoneyComb\Core\Http\Controllers\HCBaseController;
use HoneyComb\Core\Http\Controllers\Traits\HCAdminListHeaders;
use HoneyComb\Galleries\Services\HCGalleryTagService;
use HoneyComb\Starter\Helpers\HCFrontendResponse;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class HCGalleryController extends HCBaseController
{
    use HCAdminListHeaders;

    /**
     * @var HCGalleryService
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
     * @var \HoneyComb\Galleries\Services\HCGalleryTagService
     */
    private $galleryTagService;

    /**
     * HCGalleryController constructor.
     * @param Connection $connection
     * @param HCFrontendResponse $response
     * @param HCGalleryService $service
     * @param \HoneyComb\Galleries\Services\HCGalleryTagService $galleryTagService
     */
    public function __construct(
        Connection $connection,
        HCFrontendResponse $response,
        HCGalleryService $service,
        HCGalleryTagService $galleryTagService
    ) {
        $this->connection = $connection;
        $this->response = $response;
        $this->service = $service;
        $this->galleryTagService = $galleryTagService;
    }

    /**
     * Admin panel page view
     *
     * @return View
     */
    public function index(): View
    {
        $config = [
            'title' => trans('HCGalleries::gallery.page_title'),
            'url' => route('admin.api.gallery'),
            'form' => route('admin.api.form-manager', ['gallery']),
            'headers' => $this->getTableColumns(),
            'actions' => $this->getActions('honey_comb_galleries_gallery', [
                /*'_update',*/
                '_delete',
                '_restore',
                '_force_delete',
                '_merge',
                '_clone',
            ]),
            'type' => 'gallery',
            'options' => [
                'separatePage' => true,
            ],
        ];

        return view('HCCore::admin.service.index', ['config' => $config]);
    }

    /**
     * @param \HoneyComb\Galleries\Http\Requests\HCGalleryRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(HCGalleryRequest $request)
    {
        $config = [
            'title' => trans('HCGalleries::gallery.page_title'),
            'url' => route('admin.api.form-manager', 'gallery-new'),
        ];

        return view('HCCore::admin.service.record', ['config' => $config]);
    }

    /**
     * @param \HoneyComb\Galleries\Http\Requests\HCGalleryRequest $request
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(HCGalleryRequest $request, string $id)
    {
        $config = [
            'title' => trans('HCGalleries::gallery.page_title'),
            'url' => route('admin.api.form-manager', 'gallery-edit'),
            'recordId' => $id,
        ];

        return view('HCCore::admin.service.record', ['config' => $config]);
    }

    /**
     * Get admin page table columns settings
     *
     * @return array
     */
    public function getTableColumns(): array
    {
        $columns = [
            'cover_id' => $this->headerImage(trans('HCGalleries::gallery.cover_id'), 200, 134),
            'label' => $this->headerHtml(''),
            'published_at' => $this->headerDate(trans('HCGalleries::gallery.published_at')),
            'views' => $this->headerHtml(trans('HCGalleries::gallery.views')),
            'imageViews' => $this->headerHtml(trans('HCGalleries::gallery.imageViews')),
            'total' => $this->headerHtml(trans('HCGalleries::gallery.count')),
        ];

        return $columns;
    }

    /**
     * @param string $id
     * @return \HoneyComb\Galleries\Models\HCGallery|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById(string $id)
    {
        return $this->service->getRepository()->makeQuery()->with(
            [
                'author' => function(HasOne $builder) {
                    $builder->select('id', 'name as label');
                },
                'creator',
                'tags',
                'assets',
                'categories',
            ])->find($id);
    }

    /**
     * Creating data list
     * @param HCGalleryRequest $request
     * @return JsonResponse
     */
    public function getListPaginate(HCGalleryRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->getRepository()->getListPaginate($request, ['tags', 'categories'])
        );
    }

    /**
     * Creating data list
     * @param HCGalleryRequest $request
     * @return JsonResponse
     */
    public function getOptions(HCGalleryRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->getRepository()->getOptions($request, ['tags', 'categories'])
        );
    }

    /**
     * Create record
     *
     * @param HCGalleryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(HCGalleryRequest $request): JsonResponse
    {
        $this->connection->beginTransaction();

        try {
            /** @var HCGallery $model */
            $model = $this->service->getRepository()->create($request->getRecordData());
            $model->tags()->sync($this->galleryTagService->createFromRequest($request->getTags()));

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();

            return $this->response->error($e->getMessage());
        }

        return $this->response->success('', null, route('admin.api.gallery.edit', $model->id));
    }


    /**
     * Update record
     *
     * @param HCGalleryRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(HCGalleryRequest $request, string $id): JsonResponse
    {
        try {
            /** @var HCGallery $model */
            $model = $this->service->getRepository()->findOneBy(['id' => $id]);
            $model->update($request->getRecordData());
            $model->assets()->sync($request->getAssets());
            $model->tags()->sync($this->galleryTagService->createFromRequest($request->getTags()));
        } catch (\Throwable $e) {
            $this->connection->rollBack();

            return $this->response->error($e->getMessage());
        }
        
        $request->session()->flash('success-message', trans('HCStarter::core.updated', ['name' => $request->name]));

        return $this->response->success('', null, route('admin.gallery.index'));
    }


    /**
     * Soft delete record
     *
     * @param HCGalleryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteSoft(HCGalleryRequest $request): JsonResponse
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
     * @param HCGalleryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function restore(HCGalleryRequest $request): JsonResponse
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
     * @param HCGalleryRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteForce(HCGalleryRequest $request): JsonResponse
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