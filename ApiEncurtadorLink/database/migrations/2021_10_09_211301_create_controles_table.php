<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controles', function (Blueprint $table) {
            $table->increments('Id')->unique();
            $table->string('Ip');
            $table->string('UserAgent');
            $table->integer('NumeroDeAcessos');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controles');
    }
}
