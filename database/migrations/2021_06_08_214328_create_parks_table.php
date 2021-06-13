<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->string('code',160)->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('type',120)->nullable();
            $table->string('color',100)->nullable();
            $table->time('opens_at')->nullable();
            $table->time('closes_at')->nullable();
            $table->unsignedBigInteger('intermission')->default(0);
            $table->unsignedInteger('max_capacity')->default(0);
            $table->unsignedBigInteger('start_to_end')->default(0);
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
        Schema::dropIfExists('parks');
    }
}
