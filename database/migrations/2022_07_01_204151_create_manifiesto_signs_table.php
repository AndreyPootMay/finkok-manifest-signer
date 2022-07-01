<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateManifiestoSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manifiesto_signs', function (Blueprint $table) {
            $table->id()->unsigned()->nullable(false);
            $table->text('message')->nullable(false);
            $table->string('uuid', 40)->nullable(false);
            $table->string('date', 20)->nullable(false);
            $table->string('total', 250)->nullable(false);
            $table->string('xml', 250)->nullable(false);
            $table->string('pdf', 250)->nullable(false);
            $table->string('cadena', 250)->nullable(false);
            $table->tinyInteger('active', false, true)->default(1);
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
        Schema::dropIfExists('manifiesto_signs');
    }
}
