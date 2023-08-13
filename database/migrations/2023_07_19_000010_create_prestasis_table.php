<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasisTable extends Migration
{
    public function up()
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_lomba');
            $table->string('bidang_lomba');
            $table->date('tanggal_pelaksanaan');
            $table->string('tempat_pelaksanaan');
            $table->string('prestasi_juara');
            $table->string('tingkat');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}