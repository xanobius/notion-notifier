<?php


namespace Xanobius\NotionNotifier;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class NotionNotifier
{

    private string $notionAPIURL = 'https://api.notion.com/v1/';
    private string $notionVersion = '2022-06-28';

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var string $pageId
     */
    public string $pageId;

    /**
     * @var string $notionSecret
     */
    protected string $notionSecret;

    /**
     * NotionNotifier constructor
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    /**
     * @throws Exception
     */
    public function updatePageValue(string $property, string $value) : mixed
    {
        if(empty($this->notionSecret) || empty($this->pageId)){
            throw new Exception('NotionSecret and PageId must be set');
        }

        $payload = [
            'properties' => [
                $property => [
                    "rich_text" => [[
                        "text" => [
                            "content" => $value
                        ]
                    ]]
                ]
            ]
        ];

        try{
            $request = $this->client->patch(
                $this->notionAPIURL . 'pages/' . $this->pageId,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->notionSecret,
                        'Content-Type' => 'application/json',
                        'Notion-Version' => $this->notionVersion
                    ],
                    'body' => json_encode($payload)
                ]);
        }catch(ClientException $exception) {
            throw new Exception($exception->getMessage());
        }

        return $request;
    }

    /**
     * @return string
     */
    public function getPageId(): string
    {
        return $this->pageId;
    }

    /**
     * @param string $pageId
     */
    public function setPageId(string $pageId): void
    {
        $this->pageId = $pageId;
    }

    /**
     * @return string
     */
    public function getNotionSecret(): string
    {
        return $this->notionSecret;
    }

    /**
     * @param string $notionSecret
     */
    public function setNotionSecret(string $notionSecret): void
    {
        $this->notionSecret = $notionSecret;
    }
}