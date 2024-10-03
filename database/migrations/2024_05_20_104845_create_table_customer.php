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
        Schema::create('customer', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('name',150);
            $table->string('email',150);
            $table->string('phone',150);            
            $table->string('country',150);
            $table->string('profile_image',150);
            $table->text('gallery_image');
            $table->string('subscription',150);
            $table->integer('gender');              
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_customer');
    }
};
