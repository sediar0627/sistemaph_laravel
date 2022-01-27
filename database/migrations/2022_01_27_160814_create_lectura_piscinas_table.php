<?php

use App\Models\Piscina;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturaPiscinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectura_piscinas', function (Blueprint $table) {
            $table->id();
            $table->float('lectura');
            $table->foreignIdFor(Piscina::class);
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
        Schema::dropIfExists('lectura_piscinas');
    }
}
