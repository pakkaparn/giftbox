<?php

use Phinx\Seed\AbstractSeed;

class WcmsUserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('password'),
                'name' => 'Administrator',
                'email' => 'admin@giftbox.com',
                'contact' => '0840840846',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $users = $this->table('wcms_users');
        $users->truncate();
        $users->insert($data)
            ->save();
    }
}
