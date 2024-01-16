<?php

use App\Constants\Role;
use App\Constants\Status;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaccine_center_id')->nullable()->constrained();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nid')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('role')->default(Role::USER);
            $table->string('status')->default(Status::NOT_VACCINATED);
            $table->date('scheduled_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
