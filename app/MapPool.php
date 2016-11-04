<?php

namespace App;

class MapPool
{
    protected $table = 'maps';

    private $maps = [
        'favela',
        'border',
        'yacht',
        'bank',
        'chalet',
        'clubhouse',
        'consulate',
        'hereford',
        'house',
        'kafe',
        'kanal',
        'oregon',
        'plane'
    ];

    private $link = [
        '<li data-key="favela"><span>Favela</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-favela-01_263234.jpg" data-src="tcm:150-263233" alt="Favela"></li>',
        '<li data-key="border"><span>Grenze</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-border-01_250244.jpg" data-src="tcm:150-250244" alt="Grenzlinie"></li>',
        '<li data-key="yacht"><span>Yacht</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-yacht-01_236382.jpg" data-src="tcm:150-236382" alt="Yacht"></li>',
        '<li data-key="bank"><span>Bank</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-bank-01_227817.jpg" data-src="tcm:150-227817" alt="Bank"></li>',
        '<li data-key="chalet"><span>Chalet</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-chalet-01_227824.jpg" data-src="tcm:150-227824" alt="Chalet"></li>',
        '<li data-key="clubhouse"><span>Clubhaus</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-clubhouse-01_227835.jpg" data-src="tcm:150-227835" alt="Clubhaus"></li>',
        '<li data-key="consulate"><span>Konsulat</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-consulate-01_211993.jpg" data-src="tcm:150-211993" alt="Konsulat"></li>',
        '<li data-key="hereford"><span>Hereford Base</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-hereford-01_212000.jpg" data-src="tcm:150-212000" alt="Hereford-Basis"></li>',
        '<li data-key="house"><span>Haus</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-house-01_211956.jpg" data-src="tcm:150-211956" alt="Haus"></li>',
        '<li data-key="kafe"><span>Café Dostojewski</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-kafe-dostoyevsky-01_227839.jpg" data-src="tcm:150-227839" alt="Café Dostojewski"></li>',
        '<li data-key="kanal"><span>Kanal</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-kanal-01_227842.jpg" data-src="tcm:150-227842" alt="Kanal"></li>',
        '<li data-key="oregon"><span>Oregon</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-oregon-01_227852.jpg" data-src="tcm:150-227852" alt="Oregon"></li>',
        '<li data-key="plane"><span>Plane</span><img src="https://ubistatic9-a.akamaihd.net/resource/de-DE/game/rainbow6/siege/R6-game-info-map-plane-01_211963.jpg" data-src="tcm:150-211963" alt="Präsidentenflugzeug"></li>',
    ];

    public function __construct($matchId)
    {
        $maps = Maps::where('matchId', '=', $matchId)->get();

        foreach ($maps as $map) {
            $index = array_search($map->map, $this->maps);

            unset($this->maps[$index]);
            unset($this->link[$index]);

            $this->maps = array_values($this->maps);
            $this->link = array_values($this->link);
        }

        $this->maps = array_values($this->maps);
        $this->link = array_values($this->link);
    }

    public function getMaps()
    {
        $mergedData = [];
        foreach ($this->maps as $index => $map) {
            $mergedData[] = [
                'key' => $this->maps[$index],
                'link' => $this->link[$index]
            ];
        }

        return $mergedData;
    }
}