<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobIdsToImportGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_group', function (Blueprint $table) {
            $table->string('job_ids', 1000)->nullable()->after('characters');
            $table->boolean('isDone')->default(0)->after('job_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_group', function (Blueprint $table) {
            $table->dropColumn('job_ids');
            $table->dropColumn('isDone');
        });
    }
}
