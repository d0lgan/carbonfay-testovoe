<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->string('subject'); // Действие
            $table->string('url'); // Где на сайте были сделаны изменения
            $table->string('method'); // Метод создания (изменения) записи
            $table->string('ip'); // IP-адрес пользователя
            $table->string('agent')->nullable(); // Браузер, операционная система пользователя
            $table->integer('user_id')->nullable(); // Идентификатор
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
        Schema::dropIfExists('log_activities');
    }
};
