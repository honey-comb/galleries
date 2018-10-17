<?php
/**
 * @copyright 2017 interactivesolutions
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the 'Software'), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Contact InteractiveSolutions:
 * E-mail: hello@interactivesolutions.lt
 * http://www.interactivesolutions.lt
 */

declare(strict_types = 1);

namespace HoneyComb\Galleries\Forms;

use HoneyComb\Galleries\Enum\HCGalleryStartPositionEnum;
use HoneyComb\Starter\Enum\BoolEnum;
use HoneyComb\Starter\Forms\HCBaseForm;

/**
 * Class HCGalleryForm
 * @package HoneyComb\Galleries\Forms
 */
class HCGalleryForm extends HCBaseForm
{
    /**
     * Creating form
     *
     * @param bool $edit
     * @return array
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function createForm(bool $edit = false): array
    {
        $form = [
            'storageUrl' => route('admin.api.gallery'),
            'buttons' => [
                'submit' => [
                    'label' => $this->getSubmitLabel($edit),
                ],
            ],
            'newLabel' => trans('HCGalleries::galleries.new'),
            'structure' => $this->getStructure($edit),
        ];

        if ($this->multiLanguage) {
            $form['availableLanguages'] = getHCContentLanguages();
        }

        return $form;
    }

    /**
     * @param string $prefix
     * @return array
     * @throws \ReflectionException
     */
    public function getStructureNew(string $prefix): array
    {
        return [

            $prefix . 'label' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'singleLine',
                    'label' => trans('HCGalleries::gallery.label'),
                    'required' => 1,
                ],
            $prefix . 'author' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownSearchable',
                    'required' => true,
                    'label' => trans('HCResource::resource.author'),
                    'new' => route('admin.api.form-manager', ['resource.author-new']),
                    'searchUrl' => route('admin.api.resource.author.options'),
                    'required' => 1,
                ],
            $prefix . 'published_at' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dateTimePicker',
                    'showTime' => true,
                    'label' => trans('HCGalleries::gallery.published_at'),
                ],
            $prefix . 'description' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'textArea',
                    'label' => trans('HCGalleries::gallery.description'),
                    'required' => 1,
                ],
            $prefix . 'tags' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownSearchable',
                    'creatable' => true,
                    'multi' => true,
                    'required' => true,
                    'label' => trans('HCGalleries::gallery.tags'),
                    'searchUrl' => route('admin.api.gallery.tag.options'),
                ],
            $prefix . 'cover_id' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'media',
                    'label' => trans('HCGalleries::gallery.cover_id'),
                    'uploadUrl' => route('resource.upload'),
                    'libraryUrl' => route('admin.api.resource.options'),
                    'viewUrl' => route('resource.get', '/'),
                    'editUrl' => route('admin.api.form-manager', ['resource-edit']),
                    'newUrl' => route('admin.api.form-manager', ['resource-new']),
                    'count' => 1,
                ],
            $prefix . 'categories' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownSearchable',
                    'label' => trans('HCGalleries::gallery.categories'),
                    'new' => route('admin.api.form-manager', ['gallery.category-new']),
                    'searchUrl' => route('admin.api.gallery.category.options'),
                ],

            $prefix . 'warning_flag' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownList',
                    'label' => trans('HCGalleries::gallery.warning_flag'),
                    'options' => BoolEnum::options(),
                    'required' => 1,
                ],
            $prefix . 'warning_content' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'textArea',
                    'label' => trans('HCGalleries::gallery.warning_content'),
                    'dependencies' => [
                        $prefix . 'warning_flag' => ['1'],
                    ],
                ],
            $prefix . 'show_titles' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownList',
                    'label' => trans('HCGalleries::gallery.show_titles'),
                    'options' => BoolEnum::options(),
                    'required' => 1,
                    'value' => 1,
                ],
            $prefix . 'show_descriptions' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownList',
                    'label' => trans('HCGalleries::gallery.show_descriptions'),
                    'options' => BoolEnum::options(),
                    'required' => 1,
                    'value' => 1,
                ],
            $prefix . 'hidden' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownList',
                    'label' => trans('HCGalleries::gallery.hidden'),
                    'options' => BoolEnum::options(),
                    'required' => 1,
                ],

            $prefix . 'start_position' =>
                [
                    'tab' => trans('HCCore::core.general'),
                    'type' => 'dropDownList',
                    'label' => trans('HCGalleries::gallery.start_position'),
                    'options' => HCGalleryStartPositionEnum::options(),
                    'required' => 0,
                ],
        ];
    }

    /**
     * @param string $prefix
     * @return array
     * @throws \ReflectionException
     */
    public function getStructureEdit(string $prefix): array
    {
        $form = $this->getStructureNew($prefix);

        $form[$prefix . 'media_name'] =
            [
                'tab' => trans('HCGalleries::gallery.assets'),
                'type' => 'singleLine',
                'reequired' => 'true',
                'label' => trans('HCGalleries::gallery.media_name'),
            ];

        $form[$prefix . 'assets'] =
            [
                'tab' => trans('HCGalleries::gallery.assets'),
                'type' => 'media',
                'label' => trans('HCGalleries::gallery.assets'),
                'uploadUrl' => route('resource.upload'),
                'viewUrl' => route('resource.get', '/'),
                'editUrl' => route('admin.api.form-manager', ['resource-edit']),
                'width' => 220,
                'height' => 220,
                'count' => 999999,
                'previewSizes' => ['220x220'],       
                'dependencies' => [
                    $prefix . 'author' => [
                        'sendAs' => 'author_id'
                    ],
                    $prefix . 'description' => [
                        'sendAs' => 'translation.description'
                    ],
                    $prefix . 'tags' => [],
                    $prefix . 'media_name' => [
                        'sendAs' => 'translation.label'
                    ]
                ]
            ];

        $form[$prefix . 'views'] =
            [
                'type' => 'singleLine',
                'tab' => trans('HCGalleries::gallery.stats'),
                'label' => trans('HCGalleries::gallery.views'),
                'readonly' => 1,
            ];

        $form[$prefix . 'imageViews'] =
            [
                'type' => 'singleLine',
                'tab' => trans('HCGalleries::gallery.stats'),
                'label' => trans('HCGalleries::gallery.imageViews'),
                'readonly' => 1,
            ];

        return $form;
    }
}
