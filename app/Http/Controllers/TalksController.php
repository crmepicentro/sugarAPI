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
        return response()->json(['talksHistory' => json_decode($this->gethistory($numero_identificacion))], 202);
    }

    public function gethistory($numero_identificacion)
    {
        $data = Talks::where('numero_identificacion', $numero_identificacion)
            ->where('deleted', '0')
            ->selectRaw('id, name, estado_venta, estado_negociacion, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered')
            ->orderBy('date_entered', 'desc')
            ->get();

        foreach ($data as $t)
        {
            $talksTraffic = TalksTraffic::where('cb_negociacion_cb_traficocontrolcb_negociacion_ida', $t->id)->pluck('cb_negociacion_cb_traficocontrolcb_traficocontrol_idb');
            $t->traffic = Traffic::whereIn('id', $talksTraffic)->where('deleted', 0)
                ->selectRaw('id, cb_agencias_id_c,assigned_user_id, tiempo_atencion, cotizo, genero_hoja_opciones, solicito_credito, name, estado, revisado, fecha_revisado, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered')
                ->orderBy('date_entered', 'desc')->get();

            foreach ($t->traffic as $traffic)
            {
                $traffic->user = Users::where('id', $traffic->assigned_user_id)->select('first_name', 'last_name')->first();
                $traffic->agency = Agencies::where('id', $traffic->cb_agencias_id_c)->select('name')->first();
            }

            $talksCalls = TalksCalls::where('cb_negociacion_callscb_negociacion_ida', $t->id)->pluck('cb_negociacion_callscalls_idb');

            $t->calls = Calls::whereIn('id', $talksCalls)->where('deleted', 0)->orderBy('date_entered', 'desc')
                ->selectRaw('id, CONVERT_TZ(date_start,\'+00:00\',\'-05:00\') as date_start, CONVERT_TZ(date_end,\'+00:00\',\'-05:00\') as date_end, duration_hours, duration_minutes, description, direction')
                ->get();
            $talksOpportunities = TalksOpportunities::where('cb_negociacion_opportunitiescb_negociacion_ida', $t->id)->pluck('cb_negociacion_opportunitiesopportunities_idb');

            $t->opportunities = Opportunities::whereIn('id', $talksOpportunities)
                ->join('opportunities_cstm', 'opportunities.id', '=', 'opportunities_cstm.id_c')
                ->where('deleted', 0)
                ->selectRaw('id, amount, valorentrada_c, tipofinancieratext_c, modelo_c, anio_c, assigned_user_id, cb_agencias_id_c, cb_lineanegocio_id_c, name, sales_stage, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered')
                ->orderBy('date_entered', 'desc')
                ->get();

            foreach ($t->opportunities as $opportunity)
            {
                $opportunity->user = Users::where('id', $opportunity->assigned_user_id)->select('first_name', 'last_name')->first();
                $opportunity->agency = Agencies::where('id', $opportunity->cb_agencias_id_c)->select('name')->first();
                $opportunity->business_line = BusinessLine::where('id', $opportunity->cb_lineanegocio_id_c)->select('name')->first();
            }

            $talksAppraisals = TalksAppraisals::where('cb_negociacion_cb_avaluoscb_negociacion_ida', $t->id)->pluck('cb_negociacion_cb_avaluoscb_avaluos_idb');
            $t->appraisals = Appraisals::whereIn('id', $talksAppraisals)->where('deleted', 0)
                ->selectRaw('id, name, estadotecnico, numavaluotecnico, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered, CONVERT_TZ(fechaavaluotecnico,\'+00:00\',\'-05:00\') as fechaavaluotecnico, CONVERT_TZ(fechasolicitudtecnico,\'+00:00\',\'-05:00\') as fechasolicitudtecnico, tipo, preciocliente')
                ->orderBy('date_entered', 'desc')->get();
        }

        return $data;
    }
}
