<?php

use App\Models\LecturaPiscina;
use App\Models\Notificacion;
use App\Models\Piscina;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->text('mensaje');
            $table->string("telefono")->nullable();
            $table->integer("estado_sms");
            $table->integer("estado_whatsapp");
            $table->string("fecha_sms")->nullable();
            $table->string("fecha_whatsapp")->nullable();
            $table->text("observacion_sms")->nullable();
            $table->text("observacion_whatsapp")->nullable();
            $table->foreignIdFor(LecturaPiscina::class);
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
        Schema::dropIfExists('notificacions');
    }
}
