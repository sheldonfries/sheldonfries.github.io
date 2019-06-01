function computeMarketCap() {
    var api_id = "3X8HWV-KX37Y4R3R5";
    var estimate = "http://api.wolframalpha.com/v2/query?input=10^(3.23720++*+ln((number+of+weeks+since+2009+Jan+09)%2Fweeks)+-+8.81809)&appid=" + api_id;
    var actual = "https://api.coinmarketcap.com/v2/global/";
}

function computeBTCValue() {
    var actual = "https://api.coinmarketcap.com/v2/ticker/1/";
}