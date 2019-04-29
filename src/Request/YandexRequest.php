<?php

namespace Acme\Request;

class YandexRequest extends BaseRequest
{
    public function sendQuery()
    {
        $params = [
            'query' => [
                'user' => $_ENV['USER_NAME'],
                'key' => $_ENV['API_KEY'],
                'query' => $this->text,
                'lr' => $_ENV['LR'],
                'i10n' => 'en',
            ],
        ];

        $url = $_ENV['SEARCH_URL'];

        return $this->request($url, $params);
    }
}
