<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Mail\TaskEmail;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command send emails when task due date is in the past';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*
         * Ideally we need to set a new flag in DB 'isSend' in the tasks table.
         * Once the email is send we need to set the flag as 1 and then to fetch all records which are not send
         */
        $tasks = Task::where('due_date', '<', now())->get();
        foreach ($tasks as $task) {
            Mail::to($task->user->email)->send(new TaskEmail());
        }
        return 0;
    }
}
