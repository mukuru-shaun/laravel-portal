<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationInstanceResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_instance_databases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_instance_id')->constrained('application_instances', 'id');
            $table->foreignId('database_id')->constrained('databases', 'id');
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
        Schema::dropIfExists('application_instance_resources');
    }
}
