<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'TestMain.php';

/**
 * Description of investorTest
 *
 * @author codati
 * @group document
 */
class F_DocumentTest extends TestMain {

    /**
     * @var \Catalizr\Entity\Documents
     */
    static $document;

    /**
     * @var \Catalizr\Entity\Documents[]
     */
    static $documents;

    public function testUploadCompanyError() {// TODO => use @expectedExceptionCode @expectedExceptionMessage not try ... catch
        $document1 = new \Catalizr\Entity\Documents();
        $document2 = new \Catalizr\Entity\Documents();
        $document3 = new \Catalizr\Entity\Documents();

        $document1->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        try {
            $this->api->companies->createDocumentByCompany(C_CompaniesTest::$companie, $document1);
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"type_mime" is required', $ex->getMessage());
        }
        $document2->type = 'KBIS';
        $document2->type_mime = 'application/pdf';
        $document2->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'not_existe.png';

        try{
            $this->api->companies->createDocumentByExternalCompanyId(C_CompaniesTest::$companie->iid, $document2);

        } catch (Exception $ex) {
            $this->assertSame('document file not exists', $ex->getMessage());
        }

        $document3->type = 'KBIS';
        $document3->type_mime = 'application/pdf';
        $document3->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';

        try{
            $this->api->companies->createDocumentByExternalCompanyId('not_existe', $document3);
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');
            $this->assertSame('Company not found', $ex->getMessage());
        }
    }

    public function testUploadCompany() {
        $document1 = new \Catalizr\Entity\Documents();
        $document2 = new \Catalizr\Entity\Documents();
        $document3 = new \Catalizr\Entity\Documents();

        $document1->type = 'STATUTS';
        $document1->type_mime = 'application/pdf';
        $document1->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->companies->createDocumentByCompany(C_CompaniesTest::$companie, $document1);

        $document2->type = 'KBIS';
        $document2->type_mime = 'application/pdf';
        $document2->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->companies->createDocumentByExternalCompanyId(C_CompaniesTest::$companie->iid, $document2);

        $document3->type = 'RIB_COMPANY';
        $document3->type_mime = 'application/pdf';
        $document3->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'50Mo.pdf';
        $this->api->companies->createDocumentByCompanyId(C_CompaniesTest::$companie->id, $document3);
    }

    public function testUploadFundraisingError() {// TODO => use @expectedExceptionCode @expectedExceptionMessage not try ... catch
        $document1 = new \Catalizr\Entity\Documents();
        $document2 = new \Catalizr\Entity\Documents();
        $document3 = new \Catalizr\Entity\Documents();

        $document1->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        try {
            $this->api->fundraisings->createDocumentByFundraising(D_FundraisingsTest::$fundraisingHaveIid, $document1);
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"type_mime" is required', $ex->getMessage());
        }
        $document2->type = 'PV_OUVERTURE_CAPITAL';
        $document2->type_mime = 'application/pdf';
        $document2->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'not_existe.png';

        try{
            $this->api->fundraisings->createDocumentByExternalFundraisingId(D_FundraisingsTest::$fundraisingHaveIid->iid, $document2);

        } catch (Exception $ex) {
            $this->assertSame('document file not exists', $ex->getMessage());
        }

        $document3->type = 'PV_OUVERTURE_CAPITAL';
        $document3->type_mime = 'application/pdf';
        $document3->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';

        try{
            $this->api->fundraisings ->createDocumentByExternalFundraisingId('not_existe', $document3);
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');
            $this->assertSame('Fundraising not found', $ex->getMessage());
        }
    }

    public function testUploadFundraisings() {
        $document1 = new \Catalizr\Entity\Documents();
        $document2 = new \Catalizr\Entity\Documents();
        $document3 = new \Catalizr\Entity\Documents();

        $document1->type = 'PV_OUVERTURE_CAPITAL';
        $document1->type_mime = 'application/pdf';
        $document1->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->fundraisings->createDocumentByExternalFundraisingId(D_FundraisingsTest::$fundraisingHaveIid->iid, $document1);

        $document2->type = 'PV_OUVERTURE_CAPITAL';
        $document2->type_mime = 'application/pdf';
        $document2->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->fundraisings->createDocumentByFundraising(D_FundraisingsTest::$fundraisings[0], $document2);

        $document3->type = 'PV_OUVERTURE_CAPITAL';
        $document3->type_mime = 'application/pdf';
        $document3->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->fundraisings->createDocumentByFundraisingId(D_FundraisingsTest::$fundraisings[1]->id, $document3);
    }

    public function testUploadInvestmentError() {// TODO => use @expectedExceptionCode @expectedExceptionMessage not try ... catch
        $document1 = new \Catalizr\Entity\Documents();
        $document2 = new \Catalizr\Entity\Documents();
        $document3 = new \Catalizr\Entity\Documents();

        $document1->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        try {
            $this->api->investments->createDocumentByInvestment(E_InvestmentsTest::$investment, $document1);
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(400, $ex->getCode(),'http code');
            $this->assertSame('"type_mime" is required', $ex->getMessage());
        }
        $document2->type = 'BULLETIN_SOUSCRIPTION';
        $document2->type_mime = 'application/pdf';
        $document2->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'not_existe.png';

        try{
            $this->api->investments->createDocumentByExternalInvestmentId(E_InvestmentsTest::$investment->iid, $document2);

        } catch (Exception $ex) {
            $this->assertSame('document file not exists', $ex->getMessage());
        }

        $document3->type = 'BULLETIN_SOUSCRIPTION';
        $document3->type_mime = 'application/pdf';
        $document3->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';

        try{
            $this->api->investments->createDocumentByExternalInvestmentId('not_existe', $document3);
        } catch (\Catalizr\Lib\HttpException $ex) {
            $this->assertSame(404, $ex->getCode(),'http code');
            $this->assertSame('Investment not found', $ex->getMessage());
        }
    }

    public function testUploadInvestment() {
        $document1 = new \Catalizr\Entity\Documents();
        $document2 = new \Catalizr\Entity\Documents();
        $document3 = new \Catalizr\Entity\Documents();
        $document4 = new \Catalizr\Entity\Documents();
        $document5 = new \Catalizr\Entity\Documents();

        $document1->type = 'BULLETIN_SOUSCRIPTION';
        $document1->type_mime = 'application/pdf';
        $document1->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->investments->createDocumentByExternalInvestmentId(E_InvestmentsTest::$investment->iid, $document1);
        self::$documents[] = $document1;

        $document2->type = 'LETTRE_ENGAGEMENT';
        $document2->type_mime = 'application/pdf';
        $document2->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->investments->createDocumentByInvestment(E_InvestmentsTest::$investment, $document2);
        self::$documents[] = $document2;

        $document3->type = 'LETTRE_INFORMATION';
        $document3->type_mime = 'application/pdf';
        $document3->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->investments->createDocumentByInvestmentId(E_InvestmentsTest::$investment->id, $document3);
        self::$documents[] = $document3;

        $document4->type = 'ORDRE_VIREMENT';
        $document4->type_mime = 'application/pdf';
        $document4->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'pdf-test.pdf';
        $this->api->investments->createDocumentByInvestmentId(E_InvestmentsTest::$investment->id, $document4);
        self::$documents[] = $document4;

        $document5->type = 'TITRE_PROPRIETE';
        $document5->type_mime = 'application/pdf';
        $document5->path_to_file = __DIR__ .DIRECTORY_SEPARATOR .'test_upload' .DIRECTORY_SEPARATOR.'50Mo.pdf';
        $this->api->investments->createDocumentByInvestmentId(E_InvestmentsTest::$investment->id, $document5);
        self::$documents[] = $document5;

        self::$document = $document1;

        return $document1;
    }

    /**
     * @depends testUploadInvestment
     */
    public function testGetDocuments(\Catalizr\Entity\Documents $document) {
        $docFile= $this->api->documents->getDocumentToBinaryByIdDocument($document->id);
        $hash = hash('sha512', $docFile);
        $this->assertSame($hash, "ab5a2534c3fc29a4d97e1f4216e0787f197d797da67ac2d7a2bd4b891fc78003b15e870242bde5066b9c943b3dad5009f08ef6c15ef96e6a546fc60387ac5b2a");

        $this->api->documents->getDocumentToPathFolderByIdDocument($document->id,'');
        $hashFile = hash_file('sha512', "BULLETIN_SOUSCRIPTION-$document->id.pdf");
        $this->assertSame($hashFile, "ab5a2534c3fc29a4d97e1f4216e0787f197d797da67ac2d7a2bd4b891fc78003b15e870242bde5066b9c943b3dad5009f08ef6c15ef96e6a546fc60387ac5b2a");

        unlink("BULLETIN_SOUSCRIPTION-$document->id.pdf");
    }

    /**
     * @depends testUploadInvestment
     * @runInSeparateProcess
     */
    public function testGetStdOutDocuments(\Catalizr\Entity\Documents $document) {
        ob_start();

        $this->api->documents->getDocumentToStdOutByIdDocument($document->id);
        $hashStdout = hash('sha512', ob_get_clean());
        $this->assertSame($hashStdout, "ab5a2534c3fc29a4d97e1f4216e0787f197d797da67ac2d7a2bd4b891fc78003b15e870242bde5066b9c943b3dad5009f08ef6c15ef96e6a546fc60387ac5b2a");
    }

    /**
     * @test
     * @depends testUploadInvestment
     * @param \Catalizr\Entity\Documents $documents
     * @throws \Catalizr\Lib\HttpException
     */
    public function getDocumentsMetadata(\Catalizr\Entity\Documents $documents)
    {
        $metadata = $this->api->documents->getDocumentMetadata($documents->id);
        $this->assertNotEmpty($metadata);
    }
}
