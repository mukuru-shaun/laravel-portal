<?php

use App\Models\Environment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->timestamps();
        });

        $environments = [
            'production' => 'Production',
            'staging' => 'Staging',
            'review' => 'Review',
        ];

        foreach ($environments as $name => $displayName) {
            Environment::create([
                'name' => $name,
                'display_name' => $displayName,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('environments');
    }
}
