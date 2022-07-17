<?php


namespace Xanobius\NotionNotifier\Facades;


use Illuminate\Support\Facades\Facade;

class NotionNotifier extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'notion-notifier';
    }
}