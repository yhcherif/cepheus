<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('ip_address')->unique();
            $table->string('sudo_password');
            $table->boolean('active')->default(false);
            $table->unsignedInteger('ram_size')->default(0);
            $table->text('ssh_key')->nullable();
            $table->string('token')->unique();
            $table->integer('ssh_port')->default(22);
            $table->enum('server_type', ['web', 'zimbra', 'iredmail', 'gitlab'])->default('web');
            $table->enum('server_provider', ['aws', 'linode', 'digitalocean', 'custom'])->default('custom');
            $table->enum('status', ['inactive', 'provisioning', 'failed', 'active'])->default('provisioning');
            $table->text('database_root_password')->nullable();
            // $table->unsignedInteger('php_version_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
