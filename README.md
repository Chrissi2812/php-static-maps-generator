# php-static-maps-generator
A PHP library to generate Google Static Map Links. The Google Static Maps Library (V2) is a free service, [made available by Google] (https://developers.google.com/maps/documentation/staticmaps/).

Using simple OO methods, this project will build the URL which can be used in an image tag.


## Example Code
```
$oStaticMap = new \GoogleStaticMap\Map();
$oStaticMap->setCenter("London,UK")
    ->setHeight(300)
    ->setWidth(232)
    ->setZoom(8)
    ->setFormat("jpg")
    ->setFeatureStyling(array(
        "feature" => "all",
        "element" => "all",
        "style" => array(
            "hue" => "#006400",
            "lightness" => 50
        )
    ));

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
```

## Example Output:
![Sample map generated by the Class](http://maps.google.com/maps/api/staticmap?center=London%2CUK&zoom=8&language=en-GB&maptype=roadmap&format=jpg&size=232x300&scale=1&style=feature:all|element:all|lightness:50|hue:0x006400&sensor=false)


## Fix coding standards:
    /usr/local/bin/php-cs-fixer fix --config=.php_cs.dist -v --dry-run


## Requirements:
This library requires no additional software beyond  a functional version of PHP
7.1 (or greater) and if you wish to retrieve the Map image, a working Internet
connection.