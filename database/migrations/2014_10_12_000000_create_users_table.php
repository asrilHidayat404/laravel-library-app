<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('avatar')->nullable();
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role_id')->default(2);
            $table->foreign('role_id')->references('id_role')->on('roles')->onDelete('cascade');
            $table->timestamps();
        });

        User::create([
            "username" => "Admin Library",
            "email" => "admin@gmail.com",
            "password" => Hash::make("password"),
            "role_id" => 1
        ]);
        User::create([
            "username" => "Member Library",
            "email" => "member@gmail.com",
            "password" => Hash::make("password"),
            "role_id" => 2
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
