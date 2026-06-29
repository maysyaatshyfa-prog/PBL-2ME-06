<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {

            $table->id();

              $table->string('order_id')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('room_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('room_variant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('room_number_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            $table->string('guest_name');

            $table->text('special_request')->nullable();

            $table->date('check_in');
            $table->date('check_out');

            $table->integer('total_harga');

            $table->string('status')->default('Aktif');

            $table->string('status_pembayaran')
                ->default('Menunggu');

            $table->timestamps();
        });
    }

   public function down(): void
{
    Schema::dropIfExists('reservations');
}
};