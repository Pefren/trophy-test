<?

$lat1 = "55.677855";
$lon1 = "12.569008";
$lat2 = "55.677922";
$lon2 = "12.571465";
$lat3 = "55.677069";
$lon3 = "12.571208";
$lat4 = "55.677057";
$lon4 = "12.568837";

$str = [
        "type" => "FeatureCollection",
        "features" => [
            [
                "type" => "Feature",
                "geometry" => [
                    "type" => "Polygon",
                    "coordinates" => [
                        [
                            [$lon1, $lat1],
                            [$lon2, $lat2],
                            [$lon3, $lat3],
                            [$lon4, $lat4]
                        ]
                    ]
                ],
                "properties" => [
                    "prop0" => "value0",
                    "prop1" => ["this" => "that"]
                ]
            ]
        ]
    ];

function geoJson($str) {
    return json_encode($str); // error! here should not be ; sign
}
