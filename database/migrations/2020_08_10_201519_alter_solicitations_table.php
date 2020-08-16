<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSolicitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitations', function (Blueprint $table) {

            if (Schema::hasColumn('solicitations', 'comment')) {
            } else {
                $table->string('comment')->nullable(true);
            }
            $table->string('protocol')->nullable(true);
            $table->string('geolocation')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumn('comment');
    }
}
