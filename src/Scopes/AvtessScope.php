<?php

namespace Deonoize\AvtessCMS\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AvtessScope
    implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'Visible',
        'Invisible',
        'WithInvisible',
        'WithoutInvisible',
        'OnlyInvisible'
    ];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->qualifyColumn('visible'), 1);
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the visible extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addVisible(Builder $builder)
    {
        $builder->macro('visible', function (Builder $builder) {
            $builder->withInvisible();

            return $builder->update([$builder->getModel()->qualifyColumn('visible') => 1]);
        });
    }

    /**
     * Add the invisible extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addInvisible(Builder $builder)
    {
        $builder->macro('invisible', function (Builder $builder) {
            $builder->withInvisible();

            return $builder->update([$builder->getModel()->qualifyColumn('visible') => 0]);
        });
    }

    /**
     * Add the with-invisible extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function addWithInvisible(Builder $builder)
    {
        $builder->macro('withInvisible', function (Builder $builder, $withInvisible = true) {
            if (!$withInvisible) {
                return $builder->withoutInvisible();
            }
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-invisible extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutInvisible(Builder $builder)
    {
        $builder->macro('withoutInvisible', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where($model->qualifyColumn('visible'), 1);

            return $builder;
        });
    }

    /**
     * Add the only-invisible extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function addOnlyInvisible(Builder $builder)
    {
        $builder->macro('onlyInvisible', function (Builder $builder, $visible = true) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where($model->qualifyColumn('visible'), 0);

            return $builder;
        });
    }
}
