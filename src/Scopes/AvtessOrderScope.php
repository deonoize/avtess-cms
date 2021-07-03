<?php

namespace Deonoize\AvtessCMS\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AvtessOrderScope implements Scope {
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'WithoutOrderA',
        'WithOrderA',
    ];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     * @param  Model  $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model) {
        $builder->orderBy($model->qualifyColumn('priority'))->orderBy($model->qualifyColumn('id'));
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  Builder  $builder
     *
     * @return void
     */
    public function extend(Builder $builder) {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the without-order-avtess extension to the builder.
     *
     * @param  Builder  $builder
     *
     * @return void
     */
    public function addWithoutOrderA(Builder $builder) {
        $builder->macro(
            'withoutOrderA',
            function (Builder $builder, $withOrder = true) {
                if (!$withOrder) {
                    return $builder->withOrderA();
                }
                return $builder->withoutGlobalScope($this);
            }
        );
    }

    /**
     * Add the with-order-avtess extension to the builder.
     *
     * @param  Builder  $builder
     *
     * @return void
     */
    protected function addWithOrderA(Builder $builder) {
        $builder->macro(
            'withOrderA',
            function (Builder $builder) {
                $model = $builder->getModel();

                $builder->withoutGlobalScope($this)->orderBy($model->qualifyColumn('priority'))->orderBy(
                        $model->qualifyColumn('id')
                    );

                return $builder;
            }
        );
    }
}
