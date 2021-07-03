<?php

use Deonoize\AvtessCMS\Classes\Helpers\AvtessBlueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicPagesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(
            'dynamic_pages',
            function (Blueprint $table) {
                // Page columns
                AvtessBlueprint::page($table);

                $table->string('controller');
                $table->bigInteger('pages_category_id')->nullable()->unsigned()->default(null);

                // Required columns
                AvtessBlueprint::required($table);
            }
        );

        Schema::table(
            'dynamic_pages',
            function (Blueprint $table) {
                AvtessBlueprint::requiredAfterCreate($table);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('dynamic_pages');
    }
}
