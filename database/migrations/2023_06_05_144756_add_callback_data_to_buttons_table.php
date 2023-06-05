<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buttons', function (Blueprint $table) {
            $table->string('callback_data');
            $table->string('url')->nullable();
            $table->string('url_button_text')->nullable();

            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buttons', function (Blueprint $table) {
            $table->smallInteger('type');

            $table->dropColumn('callback_data');
            $table->dropColumn('url');
            $table->dropColumn('url_button_text');
        });
    }
};
