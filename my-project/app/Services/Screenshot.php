<?php


namespace App\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class Screenshot
{
    public function FetchPage($url) {
        // retrieving title of the site
        $title = $this->getSiteTitle($url);
        // capture website snapshot via 3rd party service
        $image = $this->callSnapshotService($url);
        $imageName = md5(microtime(true).$url).".jpg";
        // write into public folder
        $fp = fopen(public_path($imageName), "w");
        fwrite($fp, $image);
        fclose($fp);

        $model = new \App\Models\screenshot();
        $model->title = $title;
        $model->path = $imageName;
        $model->url = $url;
        $result = $model->save();
        return $result;
    }

    public function callSnapshotService($url) {
        $req = [
            'url' => $url,
            'delay' => 1800,
        ];
        $token = config('screenshot.token');
        $secret = config('screenshot.secret');
        $sha256 = hash('sha256', http_build_query($req).$secret);

        // Ref: https://doc.website-download.io/en/screenshot-api/parameters/
        $url = "https://api.screenshot-capture-api.com/v1/capture/".$token."/".$sha256;

        $client = new Client();
        $resp = $client->get($url, [
            'query' => $req
        ]);
        return $resp->getBody()->getContents();
    }

    public function getSiteTitle($url) {
        $content = file_get_contents($url);
        $dom = new \DOMDocument();
        if (@$dom->loadHTML($content)) {
            $titles = $dom->getElementsByTagName("title");
            if ($titles->length > 0) {
                return $titles->item(0)->nodeValue;
            }
        }
        return "";

    }
}

class MyCrawlObserver extends CrawlObserver {
    private $pages = [];
    public function getPages() {
        return $this->pages;
    }

    public function willCrawl(UriInterface $url): void
    {
    }


    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ) :void {
//        Browsershot::url((string)$url)
//            ->setNodeBinary("/opt/bitnami/node/bin/node")
//            ->setNpmBinary("/opt/bitnami/node/bin/npm")
//            ->setIncludePath("/opt/bitnami/node/bin")
//            ->save(public_path("abc.jpg"));
//        $browsershot = Browsershot::url((string)$url)->save(public_path("abc.jpg"));
////        $browsershot
//        $browsershot->setNodeBinary("/opt/bitnami/node/bin/node");
//        $browsershot->setNpmBinary("/opt/bitnami/node/bin/npm");
////        $browsershot->setIncludePath("/opt/bitnami/node/bin");
        $this->pages[] = [
            'url' => (string) $url,
        ];
    }

    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ) :void {

    }

    public function finishedCrawling(): void
    {
    }
}
