<?php

namespace Acme\Parser;

class YandexParser extends BaseParser
{
    public function parse()
    {
        $response = $this->request->sendQuery();

        $searchData = new \SimpleXMLElement($response);
        $groups = $searchData->xpath('//group');

        $results = $this->prepareResults($groups);

        return $results;
    }

    private function prepareResults($groups)
    {
        $count = 0;
        $results = [];
        foreach ($groups as $group) {
            if ($count == 5) {
                break;
            }

            $count++;

            $results[] = [
                'url' => (string) $group->doc->url,
                'title' => (string) $group->doc->title,
                'description' => (string) $group->doc->passages->passage,
            ];
        }

        return $results;
    }
}
