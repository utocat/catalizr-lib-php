<?php
/**
 * Created by PhpStorm.
 * User: ludovicszymalka
 * Date: 14/06/18
 * Time: 10:18
 */

/**
 * @group reports
 */
class H_ReportsTest extends TestMain
{
    /**
     * @test
     *
     * @return \Catalizr\Entity\ReportTemplate
     * @throws \Catalizr\Lib\HttpException
     */
    public function getByCode()
    {
        $report = $this->api->reports->getByCode('REPORT_SIGNATURE_MISSING');

        $this->assertInternalType('string', $report->id);
        $this->assertInternalType('string', $report->createdAt);
        $this->assertInternalType('string', $report->updatedAt);

        $this->assertNotEmpty($report->id);

        $this->assertSame('Signature manquante', $report->label);
        $this->assertSame('Une signature est manquant dans votre dossier d\'investissement', $report->mail_body);
        $this->assertSame('Une signature est manquante dans votre dossier', $report->mail_subject);

        return $report;
    }

    /**
     * @test
     * @depends getByCode
     *
     * @throws \Catalizr\Lib\HttpException
     */
    public function get(\Catalizr\Entity\ReportTemplate $reportTemplate)
    {
        $report = $this->api->reports->getById($reportTemplate->id);

        $this->assertInternalType('string', $report->createdAt);
        $this->assertInternalType('string', $report->updatedAt);

        $this->assertSame('REPORT_SIGNATURE_MISSING', $report->code);
        $this->assertSame('Signature manquante', $report->label);
        $this->assertSame('Une signature est manquant dans votre dossier d\'investissement', $report->mail_body);
        $this->assertSame('Une signature est manquante dans votre dossier', $report->mail_subject);
    }
}
