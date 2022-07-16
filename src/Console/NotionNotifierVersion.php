<?php


namespace Xanobius\NotionNotifier\Console;


use Illuminate\Console\Command;

class NotionNotifierVersion extends Command
{

    protected $signature = 'notion-notifier:version';

    protected $description = 'Notify notion about the current versions of your project.';

    public function handle()
    {
        echo "shot the infos to notion";
    }

}