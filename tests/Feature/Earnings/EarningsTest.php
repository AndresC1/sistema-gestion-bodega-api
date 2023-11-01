<?php

namespace Tests\Feature\Earnings;

use App\Services\Earnings\EarningsDays;
use App\Services\Earnings\EarningsForMonth;
use App\Services\Earnings\EarningsLastWeek;
use App\Services\Earnings\EarningsMonth;
use Carbon\Carbon;
use Database\Factories\OrganizationFactory;
use Database\Factories\SaleFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EarningsTest extends TestCase
{
//    use DatabaseTransactions;

    protected $organization_new;
    protected $client_new;
    protected $user_new;

    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::create(2023, 9, 16, 0, 0, 0));
        $this->organization_new = OrganizationFactory::new()->create();
        $this->client_new = UserFactory::new()->create();
        $this->user_new = UserFactory::new()->create();

        $this->client_new->organization_id = $this->organization_new->id;
        $this->user_new->organization_id = $this->organization_new->id;
        $this->actingAs($this->user_new);
        $this->generateSales();
    }

    public function createSale($date, $number_bill, $total, $earning_total){
        return SaleFactory::new()->create([
            'number_bill' => $number_bill,
            'organization_id' => $this->organization_new->id,
            'client_id' => $this->client_new->id,
            'user_id' => $this->user_new->id,
            'date' => $date,
            'total' => $total,
            'earning_total' => $earning_total,
        ]);
    }

    public function generateSales(){
        $this->createSale(now('America/Managua')->format('Y-m-d'), 'TEST-0001', 200, 100);
        $this->createSale(now('America/Managua')->format('Y-m-d'), 'TEST-0002', 200, 100);
        $this->createSale(now('America/Managua')->subDays(1)->format('Y-m-d'), 'TEST-0003', 200, 100);
        $this->createSale(now('America/Managua')->subDays(8)->format('Y-m-d'), 'TEST-0004', 200, 100);
        $this->createSale(now('America/Managua')->subDays(29)->format('Y-m-d'), 'TEST-0005', 200, 100);
        $this->createSale(now('America/Managua')->subDays(31)->format('Y-m-d'), 'TEST-0006', 200, 100);
        $this->createSale(now('America/Managua')->subDays(62)->format('Y-m-d'), 'TEST-0006', 200, 100);
        $this->createSale(now('America/Managua')->subDays(362)->format('Y-m-d'), 'TEST-0006', 200, 100);
    }

    /**
     * @test
     */
    public function earnings_today(): void
    {
        $earnings = new EarningsDays();
        $earnings_today = $earnings->calculate();

        dump($earnings_today);

        $this->assertEquals($earnings_today['earnings_total'], 200);
        $this->assertEquals($earnings_today['sales_total'], 2);
    }

    /**
     * @test
     */
    public function earnings_last_7_days(): void
    {
        $earnings = new EarningsLastWeek();
        $earnings_last_7_days = $earnings->calculate();

        $this->assertEquals($earnings_last_7_days['earnings_total'], 300);
        $this->assertEquals($earnings_last_7_days['sales_total'], 3);
    }

    /**
     * @test
     */
    public function earnings_last_30_days(): void
    {
        $earnings = new EarningsMonth();
        $earnings_last_30_days = $earnings->calculate();

        $this->assertEquals($earnings_last_30_days['earnings_total'], 500);
        $this->assertEquals($earnings_last_30_days['sales_total'], 5);
    }

    /**
     * @test
     */
    public function earnings_last_12_months(): void
    {
        $earningsLastYear = new EarningsForMonth();
        $earnings = $earningsLastYear->calculate();

        dump($earnings);

        // September 2022
        $this->assertEquals($earnings[0]['mes'], 'September');
        $this->assertEquals($earnings[0]['year'], 2022);
        $this->assertEquals($earnings[0]['total'], '100.00');
        // July 2023
        $this->assertEquals($earnings[1]['mes'], 'July');
        $this->assertEquals($earnings[1]['year'], 2023);
        $this->assertEquals($earnings[1]['total'], '100.00');
        // August 2023
        $this->assertEquals($earnings[2]['mes'], 'August');
        $this->assertEquals($earnings[2]['year'], 2023);
        $this->assertEquals($earnings[2]['total'], '200.00');
    }
}
