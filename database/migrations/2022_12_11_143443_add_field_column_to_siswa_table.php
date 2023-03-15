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
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('jk', 30)->after('nama');
            $table->string('ttl', 30)->default('kota')->after('jk');
            $table->string('kelas', 30)->after('ttl');
            $table->string('image', 255)->nullable()->default('default.png')->after('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'jk')) {
                $table->dropColumn('jk');
            }
            if (Schema::hasColumn('siswa', 'ttl')) {
                $table->dropColumn('ttl');
            }
            if (Schema::hasColumn('siswa', 'kelas')) {
                $table->dropColumn('kelas');
            }
            if (Schema::hasColumn('siswa', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
