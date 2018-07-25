<?php
/**
 * @copyright 2018 interactivesolutions
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

namespace HoneyComb\Galleries\Models;

use HoneyComb\Resources\Models\HCResource;
use HoneyComb\Resources\Models\HCResourceAuthor;
use HoneyComb\Starter\Models\HCUuidModel;
use HoneyComb\Starter\Models\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * Class HCGallery
 * @package HoneyComb\Galleries\Models
 */
class HCGallery extends HCUuidModel
{
    use CreatedByTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hc_gallery';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'published_at',
        'label',
        'slug',
        'description',
        'author_id',
        'created_by',
        'cover_id',
        'warning_flag',
        'warning_content',
        'show_titles',
        'show_descriptions',
        'hidden',
        'views',
        'imageViews',
        'total',
        'media_name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne(HCResourceAuthor::class, 'id', 'author_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(HCGalleryTag::class, HCGalleryTagConnection::getTableName(), 'gallery_id',
            'tag_id');
    }

    /**
     * Assets
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(HCResource::class, HCGalleryAsset::getTableName(), 'gallery_id', 'resource_id');
    }

    /**
     * Getting categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(HCGalleryCategory::class, HCGalleryCategoryConnection::getTableName(), 'gallery_id',
            'category_id');
    }

}