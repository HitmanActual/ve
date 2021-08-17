<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->constrained();
            $table->unsignedBigInteger('developer_id')->constrained();
            $table->enum('usage',['commercial','residential'])->default('residential');
            $table->enum('unit_type',['condo','villa','office','penthouse'])->default('condo');
            $table->string('floor_space');
            $table->string('bedroom');
            $table->string('bathroom');
            $table->enum('status',['available','sold','reserved'])->default('available');
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
        Schema::dropIfExists('units');
    }
}
