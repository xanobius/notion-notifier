<?php


namespace Xanobius\NotionNotifier\Console;


use Exception;
use Illuminate\Console\Command;
use Xanobius\NotionNotifier\LaravelNotionNotifier;

class NotionNotifierVersion extends Command
{

    protected $signature = 'notion-notifier:version';

    protected $description = 'Notify notion about the current versions of your project.';

    public function handle()
    {
        $notifier = new LaravelNotionNotifier();
        $jobs = $notifier->getActiveProperties();
        foreach($jobs as $job){
            $this->info('Update ' . $job['label'] . ' version...');
            try{
                $notifier->updatePageValue($job['prop'], $job['val']);
            }catch(Exception $e){
                $this->error('Failed: ' . $e->getMessage());
                continue;
            }
            $this->info('Successfully updated');
        }
        $this->info('Finished');
    }

}