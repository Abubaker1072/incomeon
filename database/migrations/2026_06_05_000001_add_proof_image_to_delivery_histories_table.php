<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('delivery_histories') && !Schema::hasColumn('delivery_histories', 'proof_image')) {
            Schema::table('delivery_histories', function (Blueprint $table) {
                $table->unsignedBigInteger('proof_image')->nullable()->after('collection');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('delivery_histories') && Schema::hasColumn('delivery_histories', 'proof_image')) {
            Schema::table('delivery_histories', function (Blueprint $table) {
                $table->dropColumn('proof_image');
            });
        }
    }
};
