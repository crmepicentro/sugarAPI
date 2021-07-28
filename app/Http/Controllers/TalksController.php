<?php

namespace App\Http\Controllers;

use App\Models\Agencies;
use App\Models\Appraisals;
use App\Models\BusinessLine;
use App\Models\Calls;
use App\Models\Opportunities;
use App\Models\Talks;
use App\Models\TalksAppraisals;
use App\Models\TalksCalls;
use App\Models\TalksOpportunities;
use App\Models\TalksTraffic;
use App\Models\Traffic;
use App\Models\Users;

class TalksController extends Controller
{
    public function history($numero_identificacion)
    {
        $data = Talks::where('numero_identificacion', $numero_identificacion)
            ->where('deleted', '0')
            ->orderBy('date_entered', 'desc')
            ->get();

        foreach ($data as $t)
        {
            $t->asesor = Users::where('id', $t->assigned_user_id)->first();
            $talksTraffic = TalksTraffic::where('cb_negociacion_cb_traficocontrolcb_negociacion_ida', $t->id)->pluck('cb_negociacion_cb_traficocontrolcb_traficocontrol_idb');
            $t->traffic = Traffic::whereIn('id', $talksTraffic)->where('deleted', 0)->orderBy('date_entered', 'desc')->get();

            foreach ($t->traffic as $traffic)
            {
                $traffic->user = Users::where('id', $traffic->assigned_user_id)->first();
                $traffic->agency = Agencies::where('id', $traffic->cb_agencias_id_c)->first();
            }

            $talksCalls = TalksCalls::where('cb_negociacion_callscb_negociacion_ida', $t->id)->pluck('cb_negociacion_callscalls_idb');
            $t->calls = Calls::whereIn('id', $talksCalls)->where('deleted', 0)->orderBy('date_entered', 'desc')->get();
            $talksOpportunities = TalksOpportunities::where('cb_negociacion_opportunitiescb_negociacion_ida', $t->id)->pluck('cb_negociacion_opportunitiesopportunities_idb');
            $t->opportunities = Opportunities::whereIn('id', $talksOpportunities)
                ->join('opportunities_cstm', 'opportunities.id', '=', 'opportunities_cstm.id_c')
                ->where('deleted', 0)
                ->orderBy('date_entered', 'desc')
                ->get();

            foreach ($t->opportunities as $opportunity)
            {
                $opportunity->user = Users::where('id', $opportunity->assigned_user_id)->first();
                $opportunity->agency = Agencies::where('id', $opportunity->cb_agencias_id_c)->first();
                $opportunity->business_line = BusinessLine::where('id', $opportunity->cb_lineanegocio_id_c)->first();
            }

            $talksAppraisals = TalksAppraisals::where('cb_negociacion_cb_avaluoscb_negociacion_ida', $t->id)->pluck('cb_negociacion_cb_avaluoscb_avaluos_idb');
            $t->appraisals = Appraisals::whereIn('id', $talksAppraisals)->where('deleted', 0)->orderBy('date_entered', 'desc')->get();
        }

        return response()->json(['talksHistory' => json_decode($data)], 202);
    }
}
