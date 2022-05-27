<?php


namespace App\Services;


use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class Screenshot
{
    public function FetchPage($url) {
//        $observer = new MyCrawlObserver();
//        Browsershot::url((string)$url)
//            ->setNodeBinary("/opt/bitnami/node/bin/node")
//            ->setNpmBinary("/opt/bitnami/node/bin/npm")
////            ->setIncludePath("/opt/bitnami/node/bin")
//            ->addChromiumArguments([
//                '--disable-extensions'
//            ])
//            ->save(public_path("abc.jpg"));
//            ->save("\"".public_path("abc.jpg")."\"");
//        Crawler::create()->startCrawling($url)
//                        ->addCrawlObserver(MyCrawlObserver);
//        return $observer->getPages();
        $model = new \App\Models\screenshot();
        $model->title ="abc";
        $model->path = "/a/b/c.jpg";
        $model->url = $url;
        $result = $model->save();
//        dd($result);
//        dd($model);/
        return $result;
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
