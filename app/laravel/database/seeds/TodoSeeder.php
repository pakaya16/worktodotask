<?php

use Illuminate\Database\Seeder;

use App\Model\Todo;

class TodoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $status = 'pending';

    for($loop = 0; $loop < 100; $loop ++)
    {
      Todo::create([
        'subject' => 'subject ' . $loop,
        'detail'  => 'detail' . $loop,
        'status'  => $status
      ]);

      $status = $status === 'pending' ? 'done' : ($status === 'done' ? 'pending' : 'done');
    }
  }
}
