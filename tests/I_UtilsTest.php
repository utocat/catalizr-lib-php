<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 19/06/18
 * Time: 17:32
 */

/**
 * @groups utils
 */
class I_UtilsTest extends TestMain
{
    /**
     * @test
     * @throws \Catalizr\Lib\HttpException
     */
    public function postAddress()
    {
        $results = $this->api->utils->postAddress("165 Avenue de Bretagne, Lille, France");
        $this->assertInternalType('array', $results);
        $this->assertNotEmpty($results);
        $this->assertObjectHasAttribute('description', $results[0]);
        $this->assertObjectHasAttribute('id', $results[0]);
        $this->assertEquals("165 Avenue de Bretagne, Lille, France", $results[0]->description);
    }

    /**
     * @test
     * @throws \Catalizr\Lib\HttpException
     */
    public function getAddressDetails()
    {
        $streetNumber = new stdClass();
        $streetNumber->long_name = "165";
        $streetNumber->short_name = "165";
        $streetNumber->types = ["street_number"];

        $route = new stdClass();
        $route->long_name = "Avenue de Bretagne";
        $route->short_name = "Avenue de Bretagne";
        $route->types = ["route"];

        $locality = new stdClass();
        $locality->long_name = "Lille";
        $locality->short_name = "Lille";
        $locality->types = ["locality", "political"];

        $administrative_area_level_2 = new stdClass();
        $administrative_area_level_2->long_name = "Nord";
        $administrative_area_level_2->short_name = "Nord";
        $administrative_area_level_2->types = ["administrative_area_level_2", "political"];

        $administrative_area_level_1 = new stdClass();
        $administrative_area_level_1->long_name = "Hauts-de-France";
        $administrative_area_level_1->short_name = "Hauts-de-France";
        $administrative_area_level_1->types = ["administrative_area_level_1", "political"];

        $country = new stdClass();
        $country->long_name = "France";
        $country->short_name = "FR";
        $country->types = ["country", "political"];

        $postalCode = new stdClass();
        $postalCode->long_name = "59000";
        $postalCode->short_name = "59000";
        $postalCode->types = ["postal_code"];

        $expected = [
            $streetNumber,
            $route,
            $locality,
            $administrative_area_level_2,
            $administrative_area_level_1,
            $country,
            $postalCode
        ];

        $placeId = 'ChIJ80YKbFzVwkcR1xM0RqFdZuM'; // id for "165 Avenue de Bretagne, Lille, France"
        $result = $this->api->utils->getAddressDetails($placeId);
        $this->assertEquals($expected, $result);
    }
}
