<?php

namespace Tests\Feature;

use App\Models\Agencies;
use App\Models\Appraisals;
use App\Models\BusinessLine;
use App\Models\Calls;
use App\Models\Companies;
use App\Models\Opportunities;
use App\Models\Talks;
use App\Models\TalksAppraisals;
use App\Models\TalksCalls;
use App\Models\TalksOpportunities;
use App\Models\TalksTraffic;
use App\Models\Tickets;
use App\Models\Traffic;
use App\Models\User;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoryTalksTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->setInitDataUser();
    }

    /** @test */
    public function getTalks()
    {
        $response = $this->get('/talksHistory/0201599479');
        $content = json_decode($response->content());

        $expectedTalks = Talks::where('numero_identificacion', '0201599479')
            ->where('deleted', '0')
            ->orderBy('date_entered', 'desc')
            ->pluck('name');

        $this->assertEquals($expectedTalks[0], $content->talksHistory[0]->name);
        $response->assertStatus(202);
    }

     /** @test */
    public function getTalksTraffic()
    {
        $response = $this->get('/talksHistory/0201599479');
        $content = json_decode($response->content());
        $expectedTalks = $this->getExpectedTalks();
        $talksTraffic = TalksTraffic::where('cb_negociacion_cb_traficocontrolcb_negociacion_ida', $expectedTalks[0])->pluck('cb_negociacion_cb_traficocontrolcb_traficocontrol_idb');
        $expectedTraffics = Traffic::whereIn('id', $talksTraffic)->where('deleted', 0)->orderBy('date_entered', 'desc')
            ->selectRaw('id, cb_agencias_id_c,assigned_user_id, tiempo_atencion, cotizo, genero_hoja_opciones, solicito_credito, name, estado, revisado, fecha_revisado, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered')
            ->get();

        foreach ($expectedTraffics as $traffic)
        {
            $traffic->user = Users::where('id', $traffic->assigned_user_id)->select('first_name', 'last_name')->first();
            $traffic->agency = Agencies::where('id', $traffic->cb_agencias_id_c)->select('name')->first();
        }

        $this->assertEquals(json_decode($expectedTraffics), $content->talksHistory[0]->traffic);
        $response->assertStatus(202);
    }

    /** @test */
    public function getTalksCalls()
    {
        $response = $this->get('/talksHistory/0201599479');
        $content = json_decode($response->content());
        $expectedTalks = $this->getExpectedTalks();
        $talksCalls = TalksCalls::where('cb_negociacion_callscb_negociacion_ida', $expectedTalks[0])->pluck('cb_negociacion_callscalls_idb');
        $expectedCalls = Calls::whereIn('id', $talksCalls)->where('deleted', 0)->orderBy('date_entered', 'desc')
            ->selectRaw('id, CONVERT_TZ(date_start,\'+00:00\',\'-05:00\') as date_start, CONVERT_TZ(date_end,\'+00:00\',\'-05:00\') as date_end, duration_hours, duration_minutes, description, direction')
            ->get();

        $this->assertEquals(json_decode($expectedCalls), $content->talksHistory[0]->calls);
        $response->assertStatus(202);
    }

    /** @test */
    public function getTalksOpportunities()
    {
        $response = $this->get('/talksHistory/0201599479');
        $content = json_decode($response->content());
        $expectedTalks = $this->getExpectedTalks();
        $talksOpportunities = TalksOpportunities::where('cb_negociacion_opportunitiescb_negociacion_ida', $expectedTalks[1])->pluck('cb_negociacion_opportunitiesopportunities_idb');
        $expectedOpportunities = Opportunities::whereIn('id', $talksOpportunities)
            ->join('opportunities_cstm', 'opportunities.id', '=', 'opportunities_cstm.id_c')
            ->where('deleted', 0)
            ->selectRaw('id, amount, valorentrada_c, tipofinancieratext_c, modelo_c, anio_c, assigned_user_id, cb_agencias_id_c, cb_lineanegocio_id_c, name, sales_stage, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered')
            ->orderBy('date_entered', 'desc')
            ->get();

        foreach ($expectedOpportunities as $opportunity)
        {
            $opportunity->user = Users::where('id', $opportunity->assigned_user_id)->select('first_name', 'last_name')->first();
            $opportunity->agency = Agencies::where('id', $opportunity->cb_agencias_id_c)->select('name')->first();
            $opportunity->business_line = BusinessLine::where('id', $opportunity->cb_lineanegocio_id_c)->select('name')->first();
        }

        $this->assertEquals(json_decode($expectedOpportunities), $content->talksHistory[1]->opportunities);
        $response->assertStatus(202);
    }

    /** @test */
    public function getTalksAppraisals()
    {
        $response = $this->get('/talksHistory/0201599479');
        $content = json_decode($response->content());
        $expectedTalks = $this->getExpectedTalks();
        $talksAppraisals = TalksAppraisals::where('cb_negociacion_cb_avaluoscb_negociacion_ida', $expectedTalks[2])->pluck('cb_negociacion_cb_avaluoscb_avaluos_idb');
        $expectedAppraisals = Appraisals::whereIn('id', $talksAppraisals)->where('deleted', 0)->orderBy('date_entered', 'desc')
            ->selectRaw('id, name, estadotecnico, numavaluotecnico, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered, CONVERT_TZ(fechaavaluotecnico,\'+00:00\',\'-05:00\') as fechaavaluotecnico, CONVERT_TZ(fechasolicitudtecnico,\'+00:00\',\'-05:00\') as fechasolicitudtecnico, tipo, preciocliente')
            ->get();

        $this->assertEquals(json_decode($expectedAppraisals), $content->talksHistory[2]->appraisals);
        $response->assertStatus(202);
    }

    public function getExpectedTalks(){
        return Talks::where('numero_identificacion', '0201599479')
            ->where('deleted', '0')
            ->orderBy('date_entered', 'desc')
            ->pluck('id');
    }
}
