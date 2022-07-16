<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Xanobius\NotifyNotion\NotionNotifier;

$errorMock = new MockHandler([
    new RequestException('Error Communicationg with Server', new Request('GET', 'test'))
]);

$successMock = new MockHandler([
    new Response(200, [], json_encode(''))
]);

it('can update a correct property', function() use ($successMock){
    $client = new Client(['handler' => HandlerStack::create($successMock)]);
    $notifier = new NotionNotifier($client);
    $notifier->setPageId('dummyPageId');
    $notifier->setNotionSecret('dummySecret');
    $response = $notifier->updatePageValue('correctProperty', 'value');
    $this->assertTrue($response->getStatusCode() === 200);

});

it('throws an exception with an incorrect property', function() use ($errorMock) {
    $client = new Client(['handler' => HandlerStack::create($errorMock)]);
    $notifier = new NotionNotifier($client);
    $notifier->setPageId('dummyPageId');
    $notifier->setNotionSecret('dummySecret');
    $notifier->updatePageValue('wrongProperty', 'value');
})->throws(Exception::class);

it('throws exception if all settings are missing', function() {
    $notifier = new NotionNotifier();
    $notifier->updatePageValue('pasdasd', 'asdasd');
})->throws(Exception::class);

it('throws exception if page id is missing', function() {
    $notifier = new NotionNotifier();
    $notifier->setNotionSecret('asdasdasd');
    $notifier->updatePageValue('pasdasd', 'asdasd');
})->throws(Exception::class);

it('throws exception if notion secret is missing', function() {
    $notifier = new NotionNotifier();
    $notifier->setPageId('asdasdasd');
    $notifier->updatePageValue('pasdasd', 'asdasd');
})->throws(Exception::class);