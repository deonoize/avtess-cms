<?php

namespace Deonoize\AvtessCMS\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\DynamicPage
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $keywords
 * @property string|null $route
 * @property string|null $method
 * @property int $views
 * @property string $controller
 * @property int|null $pages_category_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $parent_id
 * @property int $priority
 * @property int $visible
 * @property-read bool $is_visible
 * @method static Builder|DynamicPage newModelQuery()
 * @method static Builder|DynamicPage newQuery()
 * @method static Builder|DynamicPage query()
 * @method static Builder|DynamicPage whereController($value)
 * @method static Builder|DynamicPage whereCreatedAt($value)
 * @method static Builder|DynamicPage whereDeletedAt($value)
 * @method static Builder|DynamicPage whereDescription($value)
 * @method static Builder|DynamicPage whereId($value)
 * @method static Builder|DynamicPage whereKeywords($value)
 * @method static Builder|DynamicPage whereMethod($value)
 * @method static Builder|DynamicPage wherePagesCategoryId($value)
 * @method static Builder|DynamicPage whereParentId($value)
 * @method static Builder|DynamicPage wherePriority($value)
 * @method static Builder|DynamicPage whereRoute($value)
 * @method static Builder|DynamicPage whereTitle($value)
 * @method static Builder|DynamicPage whereUpdatedAt($value)
 * @method static Builder|DynamicPage whereViews($value)
 * @method static Builder|DynamicPage whereVisible($value)
 * @mixin Eloquent
 */
class DynamicPage extends Model {
    use AvtessModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'controller',
        'title',
        'description',
        'keywords',
        'route',
    ];
}
