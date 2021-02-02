<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleCategory;

class ParseRBK
{
    private $link = 'https://www.rbc.ru/';
    private $content = null;
    public $error = null;

    /**
     * ParseRBK constructor.
     */
    public function __construct()
    {
        try {
            $this->content = $this->getContentFromURL($this->link);
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Get news content
     */
    public function getTopNews()
    {
        if ($this->error != null) {
            return response()->json(['error' => true, 'error_message' => $this->error]);
        }

        $dom = new \DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->content);

        $xpath = new \DOMXpath($dom);
        $articles = $xpath->query("//a[@class='news-feed__item js-news-feed-item js-yandex-counter']");

        foreach($articles as $key => $article) {
            $get_info_news = [];
            $link_news = explode('?', $article->getAttribute('href'))[0];

            $content_news = $this->getContentFromURL($link_news);
            $article_dom = new \DOMDocument;
            libxml_use_internal_errors(true);
            $article_dom->loadHTML($content_news);
            $xpath_article = new \DOMXpath($article_dom);
            $title = $xpath_article->query("//h1[@class='article__header__title-in js-slide-title']");
            $content = $xpath_article->query("//div[@class='article__text article__text_free']");

            if ($content->length == 0) continue;

            foreach($content[0]->childNodes as $content_element) {
                if ($content_element->nodeName == 'p') {
                    $content_article[] = $content_element->nodeValue;
                }
            }
           
            $check_on_article = Article::where('title', trim($title[0]->nodeValue))->first();
            if ($check_on_article == null) {
                foreach ($article->childNodes as $va) {
                    if (trim($va->nodeValue) != '') {
                        $get_info_news[] = trim($va->nodeValue);
                    }
                }

                $category_from_page = trim(explode(',', $get_info_news[1])[0]);
                $category = ArticleCategory::where('category_name', $category_from_page)->first();
                if ($category == null) {
                    $category =  new ArticleCategory;
                    $category->category_name = $category_from_page;
                    $category->save();
                }

                $article = new Article;
                $article->title = $title[0]->nodeValue;
                $article->content = implode('<br />', $content_article);
                $article->category_id = $category->id;
                $article->source_link = $link_news;
                $article->save();
            }
        }

        return response()->json(['error' => false]);
    }

    /**
     * Get HTML code page on link
     * @param $url - Address for pars data
     * @return string - html
     */
    private function getContentFromURL($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_REFERER, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, FALSE);

        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($curl, CURLOPT_ENCODING, TRUE);

        curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');

        curl_setopt($curl, CURLOPT_HTTPHEADER, ['text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9']);

        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 11_1_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');

        $content = curl_exec($curl);
        curl_close($curl);

        return $content;
    }
}
