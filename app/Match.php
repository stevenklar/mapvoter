<?php

namespace App;

use Goutte\Client;

class Match
{
    public $id;
    public $team1;
    public $team2;
    public $team1id;
    public $team2id;
    public $time;
    public $mode;

    public function __construct($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        // team data
        $firstTeam = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[5]/fieldset/table/tr[2]/td[1]/a/span');
        $secondTeam = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[5]/fieldset/table/tr[2]/td[3]/a/span');
        $team1id = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[5]/fieldset/table/tr[2]/td[1]/a');
        $team2id = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[5]/fieldset/table/tr[2]/td[3]/a');

        // match data

        if (str_contains($url, 'showcupmatch')) {
            $playtime = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[8]/fieldset/div[1]/dl/dd/span');
            $matchId = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[8]/fieldset/div[2]/dl/dd/span');
            $mode = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[8]/fieldset/div[3]/dl/dd/span');

            $this->team1id = substr($team1id->attr('href'), 56);
            $this->team2id = substr($team2id->attr('href'), 56);
        } else {
            $playtime = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[8]/fieldset/div[1]/dl/dd/p');
            $matchId = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[8]/fieldset/div[3]/dl/dd/span');
            $mode = $crawler->filterXPath('//*[@id="content"]/div[3]/div/div[2]/fieldset/div[8]/fieldset/div[4]/dl/dd/span');

            $this->team1id = substr($team1id->attr('href'), 59);
            $this->team2id = substr($team2id->attr('href'), 59);
        }

        $this->id = $matchId->text();
        $this->team1 = $firstTeam->text();
        $this->team2 = $secondTeam->text();
        $this->time = $playtime->text();
        $this->mode = $mode->text();
    }
}