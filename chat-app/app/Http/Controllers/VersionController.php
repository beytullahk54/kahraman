<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class VersionController extends Controller
{
    public function index($erisim = null)
    {
        ini_set('memory_limit', '1024M');
        if ($erisim == null) {
            return 'Erişiminiz yok';
        } elseif ($erisim == 'chat') {
            $this->version240824();
            
            //return "Toplam Öğrenci sayısı:".$nowDay." <br> Bugün eklenen öğrenci sayısı  ".$nowStudentCount." <br> Toplam Sertifika Verilen Katılımcı  version20201228 Veritabanı güncellemeleri başarılı";
            return "Güncelleme başarılı oldu";
        }
    }



    public function version240824()
    {

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name', 25);
                $table->string('last_name', 25);
                $table->string('email', 50)->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('rooms')) {
            Schema::create('rooms', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->integer('user_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_rooms')) {
            Schema::create('user_rooms', function (Blueprint $table) {
                $table->increments('id');
                $table->foreignId('user_id');
                $table->foreignId('room_id');
                $table->timestamps();
            });
        }
        if (!Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('is_admin')->nullable();
            });
        }

        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->string('body');
                $table->integer('user_id');
                $table->string('user_name');
                $table->string('room_id');
                $table->timestamps();
            });
        }
        if(!User::where("email","=","admin@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'Admin',
                'last_name' => '',
                'email' => 'admin@gmail.com',
                'is_admin' => '1',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","admin2@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'Admin 2',
                'last_name' => '',
                'email' => 'admin2@gmail.com',
                'is_admin' => '1',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user1@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 1',
                'last_name' => '',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user2@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 2',
                'last_name' => '',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user3@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 3',
                'last_name' => '',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user4@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 4',
                'last_name' => '',
                'email' => 'user4@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user5@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 5',
                'last_name' => '',
                'email' => 'user5@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user6@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 6',
                'last_name' => '',
                'email' => 'user6@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user7@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 7',
                'last_name' => '',
                'email' => 'user7@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
        if(!User::where("email","=","user8@gmail.com")->first())
        {
            User::factory()->create([
                'first_name' => 'User 8',
                'last_name' => '',
                'email' => 'user8@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }





    }


}
