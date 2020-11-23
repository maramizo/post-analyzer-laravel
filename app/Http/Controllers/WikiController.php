<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WikiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * @param $name
     * Name of the person received from the form.
     *
     * @return array|mixed
     * JSON containing wikiquote response
     */
    public function search($name){

        //More than one name given.
        if(strpos($name, " ") != false)
            //Add 'intitle before each name'
            $name = str_replace(' ', ' intitle:', $name);

        return Http::get('https://en.wikiquote.org/w/api.php?action=query&list=search&srnamespace=0&format=json&srprop=timestamp&srsearch=intitle:' . $name)['query'];
    }

    public function show($name){
        $result = Http::get('https://en.wikiquote.org/w/api.php?action=query&formatversion=2&prop=pageimages%7Cpageterms&format=json&titles=' . $name)['query']['pages'][0];
        if(array_key_exists('thumbnail', $result) == false) {
            $result['thumbnail'] = [];
            $result['thumbnail']['source'] = '';
        }
        $result['thumbnail'] = preg_replace('/(.*?)[0-9]+(px.*)/', '${1}150$2', $result['thumbnail']);

        if(array_key_exists('terms', $result) == false){
            $result['terms'] = [];
            $result['terms']['description'] = [];
            $result['terms']['description'][0] = 'No description found.';
        }

        if(array_key_exists('pageid', $result) == false){
            $result['pageid'] = -1;
        }

        $formattedResult = [
            'thumbnail' => $result['thumbnail']['source'],
            'description' => $result['terms']['description'][0],
            'id' => $result['pageid'],
        ];

        return $formattedResult;
    }

    /*
     * Loads a wikiquotes page, grabs all quotes
     * (through handling <ul> elements which contain the quotes)
     * and stores them in a cleaned array (no empty elements),
     * returning this array afterwards.
     */
    public function getQuotes($id){
        $url = 'https://en.wikiquote.org/wiki/?curid=' . $id;
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTMLFile($url);
        $data = $dom->getElementById('mw-content-text');

        $quotes = [];

        foreach($data->childNodes[0]->childNodes as $child){
            if($child->nodeName == 'ul') {
                $currentQuote = "";
                $child->childNodes[0]->removeChild($child->childNodes[0]->lastChild);
                array_push($quotes, $child->childNodes[0]->nodeValue);
            }
        }
        $quotes = array_filter(preg_replace("/\r|\n/", "", $quotes));
        return $quotes;
    }
}
