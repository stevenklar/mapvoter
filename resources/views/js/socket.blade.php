<script src="https://js.pusher.com/3.2/pusher.min.js"></script>
<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<script>
    // dynamic
    var matchID = '{{ $match }}'; // DeSBL MatchID
    var maps = {{ $maps }}; // BO3
    var team1 = '{{ $team1 }}';
    var team2 = '{{ $team2 }}';
    var myTeam = '{{ $myTeam }}';
    var activeVoter = '{{ $voter }}';
    var locked = {{ $locked }};

    var io = io('{{ env('SOCKET_URL') }}');
    io.on('connect', function() {
        showOnline();
    });
    io.on('disconnect', function() {
        showOffline();
    });

    io.on('dismissed{{ $match }}', function(data) {
        status('blue', 'Die Map "' + data.map + '" wurde rausgevotet!');
        dismissMap(data.map);
        switchVoter();
    });

    $('.maps > li > img').on('click', dismissMapEvent);

    @if ($result != '')
        $(function() {
                @foreach ($result as $index => $winningMap)
        var tempText = $('ul.maps li[data-key="{{ $winningMap }}"]').find('span').text();
        $('ul.maps li[data-key="{{ $winningMap }}"]').find('span').text(tempText + ' ({{ $index+1 }})');
        @endforeach
    })
    @endif

    function evaluateMapPool() {
        var mapPool = [];
        $('.maps li').each(function (k, v) {
            mapPool.push($(this).data('key'));
        });

        $.post('/maps/' + matchID, {maps: mapPool})
                .done(function (data) {
                    status('darkgreen', 'Die Maps stehen fest!');
                    $.each(data, function (k, v) {
                        var tempMap = $('.maps li[data-key="' + v + '"] span').text();
                        $('.maps li[data-key="' + v + '"] span').text(tempMap + ' (' + (k + 1) + ')');
                    });
                });
    }
    function dismissMapEvent() {
        var map = $(this).parent().data('key');

        if (locked) {
            return;
        }

        locked = true;

        // may already have all maps?
        if ($('.maps li').length <= maps) {
            evaluateMapPool();

            return;
        }

        // check if i can vote
        if (activeVoter != myTeam) {
            status('darkgreen', 'Euer Team wartet auf die Auswahl des Gegners');
            locked = false;
            return;
        }

        if (io.connected) {
            $.get('/dismiss/'+matchID+'/'+myTeam+'/'+map, function(data) {
                locked = false;
            });
        } else {
            alert('Keine Verbindung zum anderen Clan');
            locked = false;
        }
    }

    function switchVoter() {
        if (activeVoter == team1) {
            activeVoter = team2;
        } else {
            activeVoter = team1;
        }
    }
    function status(color, text) {
        $('#message').css('color', color);
        $('#message').text(text);
    }
    function dismissMap(map) {
        $('*[data-key="'+map+'"]').remove();
    }
    function showOnline() {
        $('div#status').text('Online');
        $('div#status').css('color', 'darkgreen');
    }
    function showOffline() {
        $('div#status').text('Offline');
        $('div#status').css('color', 'red');
    }
</script>
