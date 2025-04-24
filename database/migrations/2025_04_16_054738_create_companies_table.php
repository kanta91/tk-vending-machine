<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('company_name');
        $table->string('representative_name')->default(''); // ←ここでデフォルト指定
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('representative_name')->nullable()->change();
        });
    }
};
