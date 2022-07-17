<?php


namespace Xanobius\NotionNotifier;


use GuzzleHttp\Client;

class LaravelNotionNotifier extends NotionNotifier
{

    /**
     * LaravelNotionNotifier constructor.
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();

        $this->setNotionSecret(config('notion-notifier.secret'));
        $this->setPageId(config('notion-notifier.page_id'));
    }

    public function getActiveProperties()
    {
        return collect(config('notion-notifier.patch'))
            ->filter(fn($item) => $item['active'])
            ->map(function($val, $type) {
                $version = match ($type) {
                    'git' => $this->getGitVersion($val['last_proper'] ?? true),
                    'framework' => $this->getFrameworkVersion()
                };

                return [
                    'prop' => $val['property'],
                    'val' => $version,
                    'label' => $type,
                    'valid' => !empty($val['property']) && !empty($version)
                ];
            })
            ->filter(fn($item) => $item['valid']) // final check to just submit proper pairs
            ;

    }

    protected function getGitVersion($lastProper)
    {
        $abbrev = $lastProper ? ' --abbrev=0' : '';
        exec('git describe' . $abbrev, $out);
        return $out[0];
    }

    protected function getFrameworkVersion()
    {
        return app()->version();
    }


}