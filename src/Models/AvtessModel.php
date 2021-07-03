<?php

namespace Deonoize\AvtessCMS\Models;

use Deonoize\AvtessCMS\Classes\Scopes\AvtessOrderScope;
use Deonoize\AvtessCMS\Classes\Scopes\AvtessScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Trait AvtessModel
 * @package Deonoize\AvtessCMS\Classes\Models
 */
trait AvtessModel {
    use SoftDeletes;

    /**
     * @var array
     */
    protected $changes_update = [];

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootAvtessModel() {
        static::addGlobalScope(new AvtessScope());
        static::addGlobalScope(new AvtessOrderScope());

        self::creating(
            function ($model) {
                $model->created_at = Carbon::now();
                $model->updated_at = Carbon::now();
            }
        );

        self::updating(
            function ($model) {
                $is_update = false;
                $changes = $model->getDirty();

                foreach ($model->changes_update as $key) {
                    if (array_key_exists($key, $changes)) {
                        $is_update = true;
                        break;
                    }
                }

                if ($is_update) {
                    $model->updated_at = Carbon::now();
                }
            }
        );
    }

    /**
     *
     */
    public function initializeAvtessModel() {
        $this->perPage = config('avtess_cms.site_per_page');

        $this->timestamps = false;

        $this->fillable = array_merge(
            $this->fillable,
            [
                'created_at',
                'updated_at',
                'deleted_at',
                'parent_id',
                'priority',
                'visible',
            ]
        );

        $this->dates = array_merge(
            $this->dates,
            [
                'created_at',
                'updated_at',
                'deleted_at',
            ]
        );
    }

    /**
     * Visible model instance.
     *
     * @param  bool  $visible
     *
     * @return bool|null
     */
    public function visible($visible = true) {
        if (!$visible) {
            return $this->invisible();
        }
        $this->attributes['visible'] = 1;
        return $this->save();
    }

    /**
     * Invisible model instance.
     *
     * @param  bool  $invisible
     *
     * @return bool|null
     */
    public function invisible($invisible = true) {
        if (!$invisible) {
            return $this->visible();
        }
        $this->attributes['visible'] = 0;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function getIsVisibleAttribute() {
        return $this->attributes['visible'] == 1;
    }
}
