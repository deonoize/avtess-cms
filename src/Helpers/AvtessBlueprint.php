<?php

namespace Deonoize\AvtessCMS\Helpers;

use Illuminate\Database\Schema\Blueprint;

class AvtessBlueprint {
    /**
     * Add in table page fields.
     * title
     *
     * @param  Blueprint  $table
     */
    static public function page(Blueprint $table) {
        $table->string('title');
        $table->string('description')->nullable();
        $table->string('keywords')->nullable();
        $table->string('route')->nullable();
        $table->string('method')->nullable();
        $table->bigInteger('views')->default(0);
    }

    /**
     * Add in table required fields.
     *
     * @param  Blueprint  $table
     */
    static public function required(Blueprint $table) {
        $table->dateTime('created_at');
        $table->dateTime('updated_at');
        $table->dateTime('deleted_at')->nullable()->default(null);
        $table->bigInteger('parent_id')->nullable()->unsigned()->default(null);
        $table->bigInteger('priority')->default(0);
        $table->boolean('visible')->default(1);
    }

    /**
     * Setting table after created.
     *
     * @param  Blueprint  $table
     */
    static public function requiredAfterCreate(Blueprint $table) {
        $table->bigIncrements('id')->first();
        $table->foreign('parent_id')->references('id')->on($table->getTable())->onDelete('cascade')->onUpdate(
                'cascade'
            );
    }
}
