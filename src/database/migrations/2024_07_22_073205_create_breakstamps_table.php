<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakstampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakstamps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timestamp_id')->constrained()->cascadeOnDelete();
            $table->timestamp('break_in')->nullable();
            $table->timestamp('break_out')->nullable();
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
        Schema::dropIfExists('breakstamps');
    }
}
