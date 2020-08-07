<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->enum('status', ['Aguardando Resposta', 'Respondida', 'Finalizada']);
            $table->string('description');
            $table->string('photo');
            $table->string('geolocation');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitations');
    }
}
