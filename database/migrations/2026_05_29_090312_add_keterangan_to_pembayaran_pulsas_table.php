<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pembayaran_pulsas', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('total_uang');
        });
    }

    public function down()
    {
        Schema::table('pembayaran_pulsas', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};