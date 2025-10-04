<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->timestamp('returned_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn('returned_at');
        });
    }
};