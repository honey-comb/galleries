<?php
/**
 * @copyright 2018 interactivesolutions
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
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

Route::prefix(config('hc.admin_url'))
    ->namespace('Admin')
    ->middleware(['web', 'auth'])
    ->group(function() {

        Route::get('gallery/category', 'HCGalleryCategoryController@index')
            ->name('admin.gallery.category.index')
            ->middleware('acl:honey_comb_galleries_gallery_category_admin_list');

        Route::prefix('api/gallery/category')->group(function() {

            Route::get('/', 'HCGalleryCategoryController@getListPaginate')
                ->name('admin.api.gallery.category')
                ->middleware('acl:honey_comb_galleries_gallery_category_admin_list');

            Route::get('list', 'HCGalleryCategoryController@getList')
                ->name('admin.api.gallery.category.list')
                ->middleware('acl:honey_comb_galleries_gallery_category_admin_list');

            Route::get('options', 'HCGalleryCategoryController@getOptions')
                ->name('admin.api.gallery.category.options');

            Route::post('/', 'HCGalleryCategoryController@store')
                ->name('admin.api.gallery.category.create')
                ->middleware('acl:honey_comb_galleries_gallery_category_admin_create');

            Route::delete('/', 'HCGalleryCategoryController@deleteSoft')
                ->name('admin.api.gallery.category.delete')
                ->middleware('acl:honey_comb_galleries_gallery_category_admin_delete');

            Route::delete('force', 'HCGalleryCategoryController@deleteForce')
                ->name('admin.api.gallery.category.delete.force')
                ->middleware('acl:honey_comb_galleries_gallery_category_admin_delete_force');

            Route::post('restore', 'HCGalleryCategoryController@restore')
                ->name('admin.api.gallery.category.restore')
                ->middleware('acl:honey_comb_galleries_gallery_category_admin_restore');


            Route::prefix('{id}')->group(function() {

                Route::get('/', 'HCGalleryCategoryController@getById')
                    ->name('admin.api.gallery.category.single')
                    ->middleware('acl:honey_comb_galleries_gallery_category_admin_list');

                Route::put('/', 'HCGalleryCategoryController@update')
                    ->name('admin.api.gallery.category.update')
                    ->middleware('acl:honey_comb_galleries_gallery_category_admin_update');

                Route::patch('/', 'HCGalleryCategoryController@patch')
                    ->name('admin.api.gallery.category.patch')
                    ->middleware('acl:honey_comb_galleries_gallery_category_admin_update');


            });
        });

    });
